<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Country;
use App\EmailListContent;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\InvoiceLog;
use App\Item;
use App\Jobs\CollectorInWarehouseJob;
use App\Package;
use App\PackageStatus;
use App\Platform;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoreController extends Controller
{

    private $platform;
    private $firstname;
    private $surname;

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

        $firstname = null;
        $surname = null;
        $this->platform = $platform;
        $this->firstname = $firstname;
        $this->surname = $surname;
    }

    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator, $request);
        }

        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
            return Platform::where('status_id', 1)->get();
        });
        $platform = $platforms
            ->where('authorization_key', $request->header('X-AUTH-KEY'))
            ->first();

        try {
            DB::beginTransaction();

            $user = $this->getUser($request);
            //dd($user);
            $packages = $this->createPackages($request, $user, $platform);

            if (!$packages){
                return response()->json([
                    'message' => 'package with given tracking number already exists'
                ]);
            }

            $send_sms = new SendSmsController();
            // dd($user);
            $send_sms->send_sms($user->id, $this->platform->id);
            DB::commit();

            return response()->json(['orders' => $packages], Response::HTTP_OK);
        } catch (PackageAlreadyExistException $exception) {
            DB::rollBack();
            return $this->packageAlreadyExistsErrorResponse($exception);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->orderCreateErrorResponse($exception);
        }
    }

    private function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
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
        ])->setCustomMessages([
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
    }

    private function validationErrorResponse($validator, $request)
    {
        Log::info('external_order_api_validation_fail', $validator->errors()->toArray());

        return response()->json([
            'message' => 'Validation failed',
            'request' => $request->all(),
            'errors' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getUser(Request $request)
    {
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
                $this->firstname = $splice[0];
                $this->surname = ' ';
            }else{
                $this->firstname = $splice[0];
                $this->surname = $splice[1];
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
                $this->firstname = $request->get('firstname');
                $this->surname = $request->get('surname');
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
                'name' => $this->firstname,
                'surname' => $this->surname,
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

        return $user;
    }

    private function createPackages(Request $request, $user, $platform)
    {
        $packages = [];

        foreach ($request->orders as $order) {
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

                }
                $internalId = $this->generateInternalId();

                //$calculate = new CalculateController();
                //$amount_response = $calculate->calculate_amount($user->id, $departure_id = $this->platform->country_id, $destination_control = 1, $category_id = $order['category_id'], $seller_id = $platform->seller_id, $order['gross_weight'], $volume_weight = 0, $request->length, $request->width, $request->height, $tariff_type_id = 1);

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
                    'approve_partner' => 0
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
                    $client = $request->fullname ? $request->fullname : $this->firstname . ' ' . $this->surname;
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
        }

        dd($packages);
        return $packages;
    }

    private function packageAlreadyExistsErrorResponse($exception)
    {
        Log::error('package_already_exists', [
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'package' => $exception->getPackage()
        ]);

        return response()->json([
            'message' => 'Package already exists by tracking id: ' . $exception->getPackage()->getAttribute('id')
        ], Response::HTTP_CONFLICT);
    }

    private function orderCreateErrorResponse($exception)
    {
        Log::error('order_create_fail', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        return response()->json([
            'message' => 'Order create fail',
        ], Response::HTTP_BAD_REQUEST);
    }

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

}
