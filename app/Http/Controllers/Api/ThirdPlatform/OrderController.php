<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Category;
use App\Classes\PartnerCalculator;
use App\Country;
use App\CourierRegion;
use App\Currency;
use App\EmailListContent;
use App\Exceptions\PackageAlreadyExistException;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\InvoiceLog;
use App\Item;
use App\Jobs\CollectorInWarehouseJob;
use App\Location;
use App\Package;
use App\PackageStatus;
use App\Platform;
use App\Settings;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function GuzzleHttp\json_decode;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api\ThirdPlatform
 */
class OrderController extends Controller
{
    /**
     * @var
     */
    private $platform;

    /**
     * OrderController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
            return Platform::where('status_id', 1)->get();
        });
        $platform = $platforms
            ->where('authorization_key', $request->header('X-AUTH-KEY'))
            ->first();

        $this->platform = $platform;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'nullable|min:2',
            'surname' => 'nullable|min:2',
            'phone' => 'required|starts_with:994',
            'email' => 'required|email',
            'fin_number' => 'required',
            'address' => 'sometimes|string',
            'latitude' => 'sometimes',
            'longitude' => 'sometimes',
            'orders' => 'required|array',
            'orders.*.tracking_id' => 'required|string|max:255|min:12',
            'orders.*.category_id' => 'required|integer',
            'orders.*.title' => 'required|string|max:500',
            'orders.*.price' => 'required|numeric',
            'orders.*.description' => 'nullable|string|max:5000',
            'orders.*.invoice' => 'required|mimes:pdf,docx,doc,png,jpg,jpeg',
            'orders.*.gross_weight' => 'required|numeric|min:0.01',
            'fullname' => 'nullable|min:2',
            'is_pick_up' => 'required|string|max:15',
            'zip_code' => 'nullable|string|max:25',
            'city' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:50',
        ]);

        $validator->setCustomMessages([
            'accepted' => 'The :attribute must be accepted.',
            'active_url' => 'The :attribute is not a valid URL.',
            'after' => 'The :attribute must be a date after :date.',
            'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
            'alpha' => 'The :attribute may only contain letters.',
            'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
            'alpha_num' => 'The :attribute may only contain letters and numbers.',
            'array' => 'The :attribute must be an array.',
            'before' => 'The :attribute must be a date before :date.',
            'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
            'between' => [
                'numeric' => 'The :attribute must be between :min and :max.',
                'file' => 'The :attribute must be between :min and :max kilobytes.',
                'string' => 'The :attribute must be between :min and :max characters.',
                'array' => 'The :attribute must have between :min and :max items.',
            ],
            'boolean' => 'The :attribute field must be true or false.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'date' => 'The :attribute is not a valid date.',
            'date_equals' => 'The :attribute must be a date equal to :date.',
            'date_format' => 'The :attribute does not match the format :format.',
            'different' => 'The :attribute and :other must be different.',
            'digits' => 'The :attribute must be :digits digits.',
            'digits_between' => 'The :attribute must be between :min and :max digits.',
            'dimensions' => 'The :attribute has invalid image dimensions.',
            'distinct' => 'The :attribute field has a duplicate value.',
            'email' => 'The :attribute must be a valid email address.',
            'ends_with' => 'The :attribute must end with one of the following: :values',
            'exists' => 'The selected :attribute is invalid.',
            'file' => 'The :attribute must be a file.',
            'filled' => 'The :attribute field must have a value.',
            'gt' => [
                'numeric' => 'The :attribute must be greater than :value.',
                'file' => 'The :attribute must be greater than :value kilobytes.',
                'string' => 'The :attribute must be greater than :value characters.',
                'array' => 'The :attribute must have more than :value items.',
            ],
            'gte' => [
                'numeric' => 'The :attribute must be greater than or equal :value.',
                'file' => 'The :attribute must be greater than or equal :value kilobytes.',
                'string' => 'The :attribute must be greater than or equal :value characters.',
                'array' => 'The :attribute must have :value items or more.',
            ],
            'image' => 'The :attribute must be an image.',
            'in' => 'The selected :attribute is invalid.',
            'in_array' => 'The :attribute field does not exist in :other.',
            'integer' => 'The :attribute must be an integer.',
            'ip' => 'The :attribute must be a valid IP address.',
            'ipv4' => 'The :attribute must be a valid IPv4 address.',
            'ipv6' => 'The :attribute must be a valid IPv6 address.',
            'json' => 'The :attribute must be a valid JSON string.',
            'lt' => [
                'numeric' => 'The :attribute must be less than :value.',
                'file' => 'The :attribute must be less than :value kilobytes.',
                'string' => 'The :attribute must be less than :value characters.',
                'array' => 'The :attribute must have less than :value items.',
            ],
            'lte' => [
                'numeric' => 'The :attribute must be less than or equal :value.',
                'file' => 'The :attribute must be less than or equal :value kilobytes.',
                'string' => 'The :attribute must be less than or equal :value characters.',
                'array' => 'The :attribute must not have more than :value items.',
            ],
            'max' => [
                'numeric' => 'The :attribute may not be greater than :max.',
                'file' => 'The :attribute may not be greater than :max kilobytes.',
                'string' => 'The :attribute may not be greater than :max characters.',
                'array' => 'The :attribute may not have more than :max items.',
            ],
            'mimes' => 'The :attribute must be a file of type: :values.',
            'mimetypes' => 'The :attribute must be a file of type: :values.',
            'min' => [
                'numeric' => 'The :attribute must be at least :min.',
                'file' => 'The :attribute must be at least :min kilobytes.',
                'string' => 'The :attribute must be at least :min characters.',
                'array' => 'The :attribute must have at least :min items.',
            ],
            'not_in' => 'The selected :attribute is invalid.',
            'not_regex' => 'The :attribute format is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'password' => 'The password is incorrect.',
            'present' => 'The :attribute field must be present.',
            'regex' => 'The :attribute format is invalid.',
            'required' => 'The :attribute field is required.',
            'required_if' => 'The :attribute field is required when :other is :value.',
            'required_unless' => 'The :attribute field is required unless :other is in :values.',
            'required_with' => 'The :attribute field is required when :values is present.',
            'required_with_all' => 'The :attribute field is required when :values are present.',
            'required_without' => 'The :attribute field is required when :values is not present.',
            'required_without_all' => 'The :attribute field is required when none of :values are present.',
            'same' => 'The :attribute and :other must match.',
            'size' => [
                'numeric' => 'The :attribute must be :size.',
                'file' => 'The :attribute must be :size kilobytes.',
                'string' => 'The :attribute must be :size characters.',
                'array' => 'The :attribute must contain :size items.',
            ],
            'starts_with' => 'The :attribute must start with one of the following: :values',
            'string' => 'The :attribute must be a string.',
            'timezone' => 'The :attribute must be a valid zone.',
            'unique' => 'The :attribute has already been taken.',
            'uploaded' => 'The :attribute failed to upload.',
            'url' => 'The :attribute format is invalid.',
            'uuid' => 'The :attribute must be a valid UUID.',
        ]);


        if ($validator->fails()) {
            Log::info('external_order_api_validation_fail', $validator->errors()->toArray());
            return response()->json([
                'message' => 'validation failed',
                'request' => $request->all(),
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
            return Platform::where('status_id', 1)->get();
        });
        $platform = $platforms
            ->where('authorization_key', $request->header('X-AUTH-KEY'))
            ->first();

        try {
            DB::beginTransaction();


            if($request->get('firstname') == null && $request->get('surname') == null && $request->get('fullname') == null)
            {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Please use name, surname or fullname. You cannot be sent empty'
                ], Response::HTTP_BAD_REQUEST);
            }
            else if($request->get('firstname') == null && $request->get('surname') == null && $request->get('fullname') != null)
            {            
                $str = preg_replace('/[ ]+/', ' ', $request->get('fullname'));
       
                $splice = explode(" ", $str);
                
                if (!isset($splice[1])) {
                    $firstname = $splice[0];
                    $surname = ' ';
                }else{
                    $firstname = $splice[0];
                    $surname = $splice[1];
                }

            }
            else{
                if($request->get('firstname') == null || $request->get('surname') == null || $request->get('fullname') != null){
                    return response()->json([
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'Name or surname cannot be sent empty. If you using name and surname, you cannot use fullname'
                    ], Response::HTTP_BAD_REQUEST);
                }
                else{
                    $firstname = $request->get('firstname');
                    $surname = $request->get('surname');
                }
            }

            $client = User::where(function($query) use ($request) {
                $query->where('email', $request->get('email'))
                    ->orWhere('passport_fin', $request->get('fin_number'));
            })->first();

            $upperFinNumber = strtoupper($request->get('fin_number'));

            $clientFin = $client != null ? strtoupper($client->passport_fin) : null;

            $checkFin = $clientFin == $upperFinNumber ? true : false;

            if(!$checkFin){
                $clientCheck = User::whereRaw("UPPER(passport_fin) = ?", [$upperFinNumber])
                    ->first();
                $checkFin = $clientCheck != null ? true : false;
                $client = $clientCheck != null ? $clientCheck : $client;
            }

            $prefix = "fake.";
            $randomDigits = rand(1000, 9999);
            $datePart = date("mdy");
            $randomPart = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);

            $generateMail = $prefix . $randomDigits . $datePart . $randomPart . "@mail.com";
            //dd($userFin);
            if ($checkFin) {
                //dd('edit user', $checkFin, $client->id);
                $user = $client;
                $client->update([
                    'address2' => $client->address1,
                    'phone3' => $client->phone1,
                    'zip2' => $client->zip1,
                    'location_latitude1' => $request->get('latitude'),
                    'location_longitude1' => $request->get('longitude'),
                    'address1' => $request->get('address'),
                    'phone1' => $request->get('phone'),
                    'zip1' => $request->get('zip_code'),
                    'city' => $request->get('city'),
                    'region' => $request->get('region')
                ]);
            }
            else {
                //dd('new user', $checkFin);
                $user = new User();
                //dd($client);
                $user = $user->fill([
                    'name' => $firstname,
                    'surname' => $surname,
                    'phone1' => $request->get('phone'),
                    'role_id' => 2,
                    'passport_fin' => $request->get('fin_number'),
                    'address1' => $request->get('address'),
                    'location_latitude1' => $request->get('latitude'),
                    'location_longitude1' => $request->get('longitude'),
                    'password' => Hash::make(env('THIRD_PLATFORM_USER_PASSWORD')),
                    'username' => $client == null ? $request->get('email') : $generateMail,
                    'email' => $client == null ? $request->get('email') : $generateMail,
                    'email_verified_at' => Carbon::now(),
                    'language' => 'AZ',
                    'zip1' => $request->get('zip_code'),
                    'city' => $request->get('city'),
                    'region' => $request->get('region'),
                    'is_external_user' => 1
                    //'parent_email' => $request->get('email')
                ]);
                $user->markEmailAsVerified();
                $user->save();
            }

            $packages = [];

            foreach ($request->orders as $order) {

                //dd($order['tracking_id']);
                $package = Package::where([
                    ['number', $order['tracking_id']],
                    //['client_id', $user->getAuthIdentifier()]
                ])->first();

                if ($package) {
                    return response()->json([
                        'message' => 'package with given tracking number already exists',
                        'tracking_number' => $order['tracking_id'],
                        'hash' => $package->getAttribute('hash')
                    ]);
                    //                    throw new PackageAlreadyExistException($package);
                }
                $internalId = $this->generateInternalId();
                
                //$calculate = new CalculateController();
                //$amount_response = $calculate->calculate_amount($user->id, $departure_id = $this->platform->country_id, $destination_control = 1, $category_id = $order['category_id'], $seller_id = $platform->seller_id, $order['gross_weight'], $volume_weight = 0, $request->length, $request->width, $request->height, $tariff_type_id = 1);

                //$amount = $this->calculate_amount_platforms($request->city, $request->region, $request->is_pick_up, $order['gross_weight']);

                $location = new \App\Classes\Location($request->city, $request->region);
                $calculator = new PartnerCalculator($location, $request->is_pick_up, $order['gross_weight']);
                $amount = $calculator->calculateAmount();

               // dd($amount);
                if($request->is_pick_up === 'to_home' || $request->is_pick_up === 'from_office'){
                    $pickUpStatus = $request->is_pick_up;
                }else{
                    return response()->json([
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'Please send correct pickup status. You can only send "to_home" or "from_office"'
                    ], Response::HTTP_BAD_REQUEST);
                }

                $package = new Package();

                    $package->fill([
                        'country_id' => $platform->country_id,
                        'number' => $order['tracking_id'],
                        'internal_id' => $internalId,
                        'hash' => Str::random(40),
                        'remark' => isset($order['description']) ? $order['description'] : null,
                        'seller_id' => $platform->seller_id,
                        'client_id' => $user->getAuthIdentifier(),
                        'created_by' => $platform->id,
                        'gross_weight' => $order['gross_weight'],
                        'total_charge_value' => 0.01,
                        'amount_usd' =>  0.01,
                        'is_ok_custom' => 1,
                        'paid' => 0,
                        'paid_status' => 1,
                        'currency_id' =>  1,
                        'departure_id' => $platform->country_id,
                        'is_warehouse' => 1,
                        'collected_by' => $platform->id,
                        'collected_at' => Carbon::now(),
                        'partner_id' => $platform->id,
                        'is_partner_pickup' => $pickUpStatus,
                        'approve_partner' => 0,
                        'partner_amount' => $amount
                    ]);
                    $package->save();

                
                PackageStatus::create([
                    'package_id' => $package->getAttribute('id'),
                    'status_id' => 37,
                    'created_by' => $platform->id
                ]);

                if ($platform->currency_id == 1) {
                    $priceUsd = $order['price'];
                } else {
                    $date = Carbon::today();
                    $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                        ->whereDate('to_date', '>=', $date)
                        ->where(['from_currency_id' => 1, 'to_currency_id' => $platform->currency_id]) //to USD
                        ->select('rate')
                        ->orderBy('id', 'desc')
                        ->first();
                    $priceUsd = 0;

                    if ($rate) {
                        $priceUsd = $order['price'] / $rate->rate;
                        $priceUsd = sprintf('%0.2f', $priceUsd);
                    }
                }

                $title = $order['title'];

                if (strlen($title) > 100){
                    $title = substr($title, 0, 100);
                }else{
                    $title = $title;
                }

                $item = new Item();
                $item->fill([
                    'package_id' => $package->getAttribute('id'),
                    'category_id' => $order['category_id'],
                    'price' => $order['price'],
                    'price_usd' => $priceUsd,
                    'currency_id' => $platform->currency_id,
                    'title' => $title
                ]);

                $invoiceFile = UploadedFile::createFromBase($order['invoice']);
                $fileName = $order['tracking_id'] . '_invoice_' . Str::random(4) . '_' . time();
                Storage::disk('uploads')->makeDirectory('files/packages/external/invoices/' . $platform->id . '/');
                $extension = $invoiceFile->getClientOriginalExtension();
                Storage::disk('uploads')
                    ->put('files/packages/external/invoices/' . $platform->id . '/' . $fileName . '.' . $extension,
                        File::get($invoiceFile));
                $path = '/uploads/files/packages/external/invoices/' . $platform->id . '/' . $fileName . '.' . $extension;
      
                $item->fill([
                    'invoice_doc' => $path,
                    'invoice_uploaded_date' => Carbon::now(),
                    'invoice_confirmed' => 2,
                    'invoice_status' => 4,
                    'created_by' => $platform->id
                ]);
                $item->save();

                $packages[] = [
                    'tracking_id' => $order['tracking_id'],
                    'internal_id' => $package->getAttribute('internal_id'),
                    'order_hash' => $package->getAttribute('hash')
                ];

                $emails = EmailListContent::where(['type' => 'not_declared_notification'])->first();
			
                if ($emails) {
                    $country_check = Country::where('id', $this->platform->country_id)->select('name_az')->first();
            
                    if ($country_check) {
                        $country_name = $country_check->name_az;
                    } else {
                        $country_name = '---';
                    }
                    $store_name = $request->seller;
                    $track = $order['tracking_id'];
                    $client = $request->fullname ? $request->fullname : $firstname . ' ' . $surname;
                    $internal = $internalId;

                    $email_to = $request->email;
                    $email_title = $emails->{'title_' . 'az'}; //from
                    $email_subject = $emails->{'subject_' . 'az'};
                    $email_subject = str_replace('{country_name}', $country_name, $email_subject);
                    $email_bottom = $emails->{'content_bottom_' . 'az'};
                    $email_content = $emails->{'content_' . 'az'};
                    $cc_email = $platform->email;

                    $email_content = str_replace('{client_name}', $client, $email_content);
                    $email_content = str_replace('{seller}', $store_name, $email_content);
                    $email_content = str_replace('{tracking}', $track, $email_content);
                    $email_content = str_replace('{country}', $country_name, $email_content);
                    $email_content = str_replace('{internal}', $internal, $email_content);

                    $job = (new CollectorInWarehouseJob($email_to, $cc_email, $email_title, $email_subject, $email_content, $email_bottom))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }

                InvoiceLog::create([
                    'package_id' => $package->getAttribute('id'),
                    'client_id' => $user->getAuthIdentifier(),
                    'invoice' => $order['price'],
                    'currency_id' => $platform->currency_id,
                    'invoice_doc' => $path,
                    'created_by' => $platform->id,
                    'status_id' => 35
                ]);
            }

            $send_sms = new SendSmsController();
            // dd($user);
            $send_sms->send_sms($user->id, $this->platform->id);


            DB::commit();
        } catch (PackageAlreadyExistException $exception) {
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('package_already_exists', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'package' => $exception->getPackage()
                ]);

            return response()->json([
                'message' => 'package_already_exists by tracking id: ' . $exception->getPackage()->getAttribute('id')
            ], Response::HTTP_CONFLICT);
        } catch (\Exception $exception) {
            // dd($exception);
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('order_create_fail', [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'orders' => $request->only('orders'),
                    'email' => $request->get('email'),
                    'key' => $request->header('X-AUTH-KEY')
                ]);

            return response()->json([
                'message' => 'order_create_fail',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'orders' => $packages
        ], 200);
    }

    /**
     * @param Request $request
     * @param $hash
     * @return JsonResponse
     */
    public function index(Request $request, $hash): JsonResponse
    {
        Log::info([
            $request->all(),
            'partner',
            $hash,
            $this->platform->id
        ]);
        try {
            if (!$hash) {
                return response()->json([
                    'message' => 'hash_required'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            /*$package = Package::where([
                ['hash', $hash],
                ['partner_id', $this->platform->id]
            ])->firstOrFail();*/

            $status = Package::where([
                ['hash', $hash],
                ['partner_id', $this->platform->id]])
                ->leftJoin('lb_status as statuses', 'statuses.id', 'package.last_status_id')
                ->orderBy('package.last_status_date', 'desc')
                ->select([
                    'statuses.status_en as en',
                    'package.last_status_date as status_time',
                    'package.number',
                    'package.internal_id'
                ])
                ->firstOrFail();

            $stat = [
                'en' => $status->en,
                'status_time' => $status->status_time
            ];

            return response()->json([
                'hash' => $hash,
                'tracking_id' => $status->number,
                'internal_id' => $status->internal_id,
                'status' => $stat
            ], 200);
        } catch (ModelNotFoundException $exception) {
            Log::channel('thirdpart_data_logger')
                ->error($exception->getModel() . ' not found', [
                    'message' => $exception->getMessage(),
                    'hash' => $hash
                ]);

            return response()->json([
                'message' => 'order_not_found_by_this_hash',
                'hash' => $hash
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::channel('thirdpart_data_logger')
                ->error('get_order_status_fail', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'order_hash' => $hash
                ]);

            return response()->json([
                'message' => 'get_order_status_fail'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(Request $request, $hash)
    {
        
        $package = Package::where([
            ['hash', $hash]
        ])->firstOrFail();
       
       $position_id = $package->position_id;
       $container_id = $package->container_id;

        if($package){
            if($position_id == null && $container_id == null){
                $status=$package->delete();
                if($status){
                    return response([
                        // 'status' => Response::HTTP_OK,
                        'message' => 'You Have Successfully Delete package',
                    ], Response::HTTP_OK);
                }
                else{
                    return response()->json([
                        'message' => 'order_not_found_by_this_hash',
                        'hash' => $request->hash
                    ], Response::HTTP_NOT_FOUND);
                }
                
            }
            else
            {
                return response()->json([
                    'case' => 'error',
                    'type' => 'error',
                    'title' => 'Error!',
                    'content' => 'Cannot be delete package, because package is container or position!'
                ], Response::HTTP_NOT_FOUND);
            }
        }
        else{
            return response()->json([
                'message' => 'order_not_found_by_this_hash',
                'hash' => $request->hash
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @return false|string
     */
    private function generateInternalId()
    {
        try {
            $settings = Settings::where('id', 1)->select('last_internal_id')->first();
            $last_internal_id = $settings->last_internal_id + 1;
            Settings::where('id', 1)->update(['last_internal_id' => $last_internal_id]);
            $len = strlen($last_internal_id);
            if ($len < 6) {
                for ($i = 0; $i < 6 - $len; $i++) {
                    $last_internal_id = '0' . $last_internal_id;
                }
            }

            $internal_id = 'CBR' . $last_internal_id;

            return $internal_id;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function partner_categories(Request $request){
        $categories = Category::orderBy('id')
            ->select('id', 'name_en')
            ->whereNull('deleted_by')
            ->get();

        return $categories;
    }

    //waybill start
    public function createPDF(Request $request, $hash)
    {

        try{
            $query = Item::LeftJoin('package', 'item.package_id', '=', 'package.id')
                    ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                    ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                    ->leftJoin('currency as pack_cur', 'package.currency_id', '=', 'pack_cur.id')
                    ->leftJoin('seller as s', 'package.seller_id', '=', 's.id')
                    ->leftJoin('category as cat', 'item.category_id', '=', 'cat.id')
                    ->leftJoin('position as pos', 'package.position_id', '=', 'pos.id')
                    ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                    ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                    ->leftJoin('lb_status as status', 'package.last_status_id', '=', 'status.id')
                    //->leftJoin('custom_category', 'item.custom_cat_id', '=', 'custom_category.id')
                    ->leftJoin('locations', 'package.country_id', '=', 'locations.id')
                    ->whereNull('item.deleted_by')
                    ->whereNull('package.deleted_by')
                    ->where('package.hash', $hash);
                
            $data = $query->orderBy('package.id')
            ->select(
                'package.client_id as Suit',
                'client.name as client_name',
                'client.surname as client_surname',
                'client.phone1 as phone',
                'client.address1 as address',
                'package.number as track',
                'package.internal_id',
                'package.gross_weight',
                'package.volume_weight',
                'package.total_charge_value',
                'pack_cur.name as pack_cur',
                'package.carrier_registration_number',
                'package.carrier_status_id',
                'package.last_status_id as last_status',
                'status.status_en as status',
                'package.container_id',
                'package.position_id',
                'pos.name as position',
                's.name as seller',
                'cat.name_en as category',
                'item.price',
                'item.price_usd',
                'item.quantity',
                'cur.name as currency',
                'flight.name',
                'flight.departure',
                'flight.destination',
                'flight.awb',
                'locations.address as location',
                'package.is_partner_pickup'
            )
            ->firstOrFail();
    
            if ($data->price !== null && $data->price != 0) {
                $charge_collect = "x";
            } else {
                $charge_collect = "";
            }
    
            $total_price = $data->total_charge_value + $data->price_usd;
            
            $response = [
                "track" => $data->track,
                "chargeCollect" => $charge_collect,
                'suit' => 'AS' . $data->Suit,
                'fullname' => $data->client_name . ' ' . $data->client_surname,
                'phone' => $data->phone,
                'deliveryAddress' => $data->address,
                'fromAddress' => $data->location,
                'trackingNumber' => $data->number,
                'internal_id' => $data->internal_id,
                'totalGrossWeight' => $data->gross_weight,
                'chargeableVolumeWeight' => $data->volume_weight,
                'shippingPrice' => $data->total_charge_value . ' ' . $data->pack_cur,
                'cdn' => $data->carrier_registration_number,
                'seller' => $data->seller,
                'category' => $data->category,
                'totalNumberOfPackages' => $data->quantity,
                'declaredValueForCustoms' => $data->price . ' ' . $data->currency,
                'totalPrice' => $total_price . ' USD',
                'aserExpressFlight' => $data->name,
                'origin' => $data->departure,
                'destination' => $data->destination,
                'awb' => $data->awb,
                'is_partner_pickup' => $data->is_partner_pickup
            ];
    
             if($data->last_status != 37){
                return $response;
             }else{
                 return response([
                     'Message' => 'Your package not prepared to flight',
                     'Status' => $data->status
                 ]);
            }

        }catch (\Exception $exception) {
            Log::channel('thirdpart_data_logger')
                ->error('get_waybill_create_fail', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'order_hash' => $hash
                ]);

            return response()->json([
                'message' => 'Error'
            ], Response::HTTP_NOT_FOUND);
        }


    }

    public function waybillGenerate($hash)
    {
        
        try{
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://aser.az:8700/api/get-waybill/' . $hash,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{
                "tracking": ""
            }',
            CURLOPT_HTTPHEADER => array(
                'X-AUTH-KEY: ' .$this->platform->authorization_key,
                'Content-Type: application/json'
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
    
            //dd($response);
            
                $filename = $hash;
                Storage::disk('uploads')->put('/files/packages/waybill/' . $filename . '.pdf', $response);
                Storage::disk('uploads')->put('/files/packages/waybill/' . $filename . '.pdf', $response);
                $path = url('/') . '/uploads/files/packages/waybill/' . $filename . '.pdf';
      
            
                return $path;

           

        }catch (\Exception $exception) {
            Log::channel('thirdpart_data_logger')
                ->error('get_waybill_status_fail', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'order_hash' => $hash
                ]);

            return response()->json([
                'message' => 'Error'
            ], Response::HTTP_NOT_FOUND);
        }

    }
    //waybill start


    public function store_v1(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:2',
            'surname' => 'required|min:2',
            'phone' => 'required|starts_with:994',
            'email' => 'required|email',
            'fin_number' => 'required',
            'address' => 'sometimes|string',
            'latitude' => 'sometimes',
            'longitude' => 'sometimes',
            'orders' => 'required|array',
            'orders.*.tracking_id' => 'required|string|max:255|min:12',
            'orders.*.category_id' => 'required|integer',
            'orders.*.title' => 'required|string|max:500',
            'orders.*.price' => 'required|numeric',
            'orders.*.description' => 'nullable|string|max:5000',
            'orders.*.invoice' => 'required|mimes:pdf,png,jpg,jpeg',
            'orders.*.currencyCode' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            Log::info('external_order_api_validation_fail', $validator->errors()->toArray());
            return response()->json([
                'message' => 'validation failed',
                'request' => $request->all(),
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
            return Platform::where('status_id', 1)->get();
        });
        $platform = $platforms
            ->where('authorization_key', $request->header('X-AUTH-KEY'))
            ->first();

        try {
            DB::beginTransaction();
            $client = User::where([
                ['email', $request->get('email')],
            ])->first();

            if ($client) {
                $user = $client;
            } else {
                $user = new User();
                $user = $user->fill([
                    'name' => $request->get('firstname'),
                    'surname' => $request->get('surname'),
                    'phone1' => (0 . ltrim(substr($request->get('phone'), 5), 0)),
                    'role_id' => 2,
                    'passport_fin' => $request->get('fin_number'),
                    'address1' => $request->get('address'),
                    'location_latitude1' => $request->get('latitude'),
                    'location_longitude1' => $request->get('longitude'),
                    'password' => Hash::make(env('THIRD_PLATFORM_USER_PASSWORD')),
                    'username' => $request->get('email'),
                    'email' => $request->get('email'),
                    'email_verified_at' => Carbon::now(),
                    'language' => 'AZ'
                ]);
                $user->markEmailAsVerified();
                $user->save();
            }

            $packages = [];

            foreach ($request->orders as $order) {
                $package = Package::where([
                    ['number', $order['tracking_id']],
                    ['client_id', $user->getAuthIdentifier()]
                ])->first();

                if ($package) {
                    return response()->json([
                        'message' => 'package with given tracking number already exists',
                        'tracking_number' => $order['tracking_id'],
                        'hash' => $package->getAttribute('hash')
                    ]);
                    //                    throw new PackageAlreadyExistException($package);
                }
                $internalId = $this->generateInternalId();

                $package = new Package();
                $package->fill([
                    'country_id' => $platform->country_id,
                    'number' => $order['tracking_id'],
                    'internal_id' => $internalId,
                    'hash' => Str::random(40),
                    'remark' => isset($order['description']) ? $order['description'] : null,
                    'seller_id' => $platform->seller_id,
                    'client_id' => $user->getAuthIdentifier(),
                    'created_by' => $platform->id,
                    'is_ok_custom' => 0,
                    'partner_id' => $platform->id,
                    'approve_partner' => 0
                ]);
                $package->save();

                PackageStatus::create([
                    'package_id' => $package->getAttribute('id'),
                    'status_id' => 37,
                    'created_by' => $platform->id
                ]);

                $currency_ids=null;
                if($order['currencyCode'] != null){
                    $currency_id = Currency::where('code', $order['currencyCode'])->select('id', 'name', 'code')->first();

                    if($currency_id == null){
                        return response()->json([
                            'message' => 'This currency is not supported by us',
                            'supported_currency' => 'AZN, USD, TL, GBP, EUR, RUB, AED, JPY, CNY, GEL'
                        ], Response::HTTP_BAD_REQUEST);
                    };
                    
                    if ($currency_id->id == 1) {
                        $priceUsd = $order['price'];
                    } else {
                        $date = Carbon::today();
                        $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                            ->whereDate('to_date', '>=', $date)
                            ->where(['from_currency_id' => 1, 'to_currency_id' => $platform->currency_id]) //to USD
                            ->select('rate')
                            ->orderBy('id', 'desc')
                            ->first();
                        $priceUsd = 0;
    
                        if ($rate) {
                            $priceUsd = $order['price'] / $rate->rate;
                            $priceUsd = sprintf('%0.2f', $priceUsd);
                        }
                    }

                    $currency_ids = $currency_id->id;
                }else{
                    if ($platform->currency_id == 1) {
                        $priceUsd = $order['price'];
                    } else {
                        $date = Carbon::today();
                        $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                            ->whereDate('to_date', '>=', $date)
                            ->where(['from_currency_id' => 1, 'to_currency_id' => $platform->currency_id]) //to USD
                            ->select('rate')
                            ->orderBy('id', 'desc')
                            ->first();
                        $priceUsd = 0;
    
                        if ($rate) {
                            $priceUsd = $order['price'] / $rate->rate;
                            $priceUsd = sprintf('%0.2f', $priceUsd);
                        }
                    }

                    $currency_ids = $platform->currency_id;
                }
                
        
                $item = new Item();
                $item->fill([
                    'package_id' => $package->getAttribute('id'),
                    'category_id' => $order['category_id'],
                    'price' => $order['price'],
                    'price_usd' => $priceUsd,
                    'currency_id' => $currency_ids,
                    'title' => $order['title']
                ]);

                $invoiceFile = UploadedFile::createFromBase($order['invoice']);
                $fileName = $order['tracking_id'] . '_invoice_' . Str::random(4) . '_' . time();
                Storage::disk('uploads')->makeDirectory('files/packages/external/invoices/' . $platform->id . '/');
                $extension = $invoiceFile->getClientOriginalExtension();
                Storage::disk('uploads')
                    ->put('files/packages/external/invoices/' . $platform->id . '/' . $fileName . '.' . $extension,
                        File::get($invoiceFile));
                $path = '/uploads/files/packages/external/invoices/' . $platform->id . '/' . $fileName . '.' . $extension;

                $item->fill([
                    'invoice_doc' => $path,
                    'invoice_uploaded_date' => Carbon::now(),
                    'invoice_confirmed' => 2,
                    'invoice_status' => 4,
                    'created_by' => $platform->id
                ]);
                $item->save();

                $packages[] = [
                    'tracking_id' => $order['tracking_id'],
                    'internal_id' => $package->getAttribute('internal_id'),
                    'order_hash' => $package->getAttribute('hash')
                ];

                InvoiceLog::create([
                    'package_id' => $package->getAttribute('id'),
                    'client_id' => $user->getAuthIdentifier(),
                    'invoice' => $order['price'],
                    'currency_id' => $platform->currency_id,
                    'invoice_doc' => $path,
                    'created_by' => $platform->id,
                    'status_id' => 35
                ]);
            }
            DB::commit();
        } catch (PackageAlreadyExistException $exception) {
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('package_already_exists', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'package' => $exception->getPackage()
                ]);

            return response()->json([
                'message' => 'package_already_exists by tracking id: ' . $exception->getPackage()->getAttribute('id')
            ], Response::HTTP_CONFLICT);
        } catch (\Exception $exception) {
             //dd($exception);
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('order_create_fail', [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'orders' => $request->only('orders'),
                    'email' => $request->get('email'),
                    'key' => $request->header('X-AUTH-KEY')
                ]);

            return response()->json([
                'message' => 'order_create_fail',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'orders' => $packages
        ], 200);
    }

    public function index_v1(Request $request, $hash): JsonResponse
    {
        try {
            if (!$hash) {
                return response()->json([
                    'message' => 'hash_required'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $package = Package::where([
                ['hash', $hash],
                ['created_by', $this->platform->id]
            ])->firstOrFail();

            $status = PackageStatus::where('package_id', $package->id)
                ->leftJoin('lb_status as statuses', 'statuses.id', 'package_status.status_id')
                ->orderBy('package_status.created_at', 'desc')
                ->select([
                    'statuses.status_en as en',
                    'statuses.status_ru as ru',
                    'statuses.status_az as az',
                ])
                ->first();

            return response()->json([
                'hash' => $hash,
                'tracking_id' => $package->number,
                'internal_id' => $package->internal_id,
                'status' => $status,
                'is_warehouse' => ($package->gross_weight !=0) ? true : false
            ], 200);
        } catch (ModelNotFoundException $exception) {
            Log::channel('thirdpart_data_logger')
                ->error($exception->getModel() . ' not found', [
                    'message' => $exception->getMessage(),
                    'hash' => $hash
                ]);

            return response()->json([
                'message' => 'order_not_found_by_this_hash',
                'hash' => $hash
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::channel('thirdpart_data_logger')
                ->error('get_order_status_fail', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'order_hash' => $hash
                ]);

            return response()->json([
                'message' => 'get_order_status_fail'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    private function calculate_amount_platforms($clientCity, $clientRegion, $is_pick_up, $weight)
    {
        $area_id = null;
        $region_id = null;
        $office_amount = null;
        $amount = null;

        $platformContract = DB::table('platform_contract_details')->get();

        $filteredContracts = $platformContract->filter(function ($contract) use ($weight) {
            return $weight >= $contract->from_weight && $weight <= $contract->to_weight;
        });

        if ($is_pick_up == 'from_office') {
            $office_amount = $filteredContracts->where('contract_id', 2)->first();

            $amount = ($office_amount->rate * $weight) + $office_amount->charge;
        }
        else if($is_pick_up == 'to_home'){
            if (!empty($clientCity)){
                //dd('empty');
                if(mb_strtoupper($clientCity, 'UTF-8') !== mb_strtoupper('Baku', 'UTF-8') && mb_strtoupper($clientCity, 'UTF-8') !== mb_strtoupper('Baki', 'UTF-8')){
                    //dd(mb_strtoupper($clientCity));
                    $is_region = CourierRegion::where(function ($query) use ($clientCity) {
                        $query->whereRaw('UPPER(name_az) = UPPER(?)', [$clientCity])
                            ->orWhereRaw('UPPER(name_en) = UPPER(?)', [$clientCity]);
                    })->first();

                    if ($is_region){
                        $region_id = $is_region->id;
                    }

                    $office_amount = $filteredContracts->where('contract_id', 3)->first();

                    $amount = ($office_amount->rate * $weight) + $office_amount->charge;

                }
                else{
                    $azerpost_region = DB::table('azerpost_region')
                        ->select('*')
                        ->whereRaw('UPPER(SUBSTRING_INDEX(name, " ", 1)) = UPPER(SUBSTRING_INDEX(?, " ", 1))', [$clientRegion])
                        ->where(function ($query) {
                            $query->whereNotNull('area_id')
                                ->orWhereNotNull('region_id');
                        })
                        ->first();

                    //dd($azerpost_region);
                    if($azerpost_region){
                        $areaId = $azerpost_region->area_id;
                        $regionId = $azerpost_region->region_id;

                        if ($areaId){
                            $area_id = $areaId;
                            $office_amount = $filteredContracts->where('contract_id', 1)->first();

                        }else{
                            $office_amount = $filteredContracts->where('contract_id', 3)->first();

                            $region_id = $regionId;
                        }
                    }

                    $amount = ($office_amount->rate * $weight) + $office_amount->charge;
                }
            }


        }

        if($region_id == null && $area_id == null){
            $office_amount = $filteredContracts->where('contract_id', 3)->first();
            $amount = ($office_amount->rate * $weight) + $office_amount->charge;
        }

        //dd($amount, $area_id, $region_id);
        return $amount;
    }
}
