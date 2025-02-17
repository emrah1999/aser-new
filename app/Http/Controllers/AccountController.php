<?php

namespace App\Http\Controllers;

use App\BalanceLog;
use App\Category;
use App\ClientsLog;
use App\Country;
use App\CountryDetails;
use App\CourierAreas;
use App\CourierDailyLimits;
use App\CourierMetroStations;
use App\CourierOrders;
use App\CourierOrderStatus;
use App\CourierRegion;
use App\CourierRegionTariff;
use App\CourierSettings;
use App\CourierZonePaymentTypes;
use App\Currency;
use App\EmailListContent;
use App\ExchangeRate;
use App\InvoiceLog;
use App\Item;
use App\LbStatus;
use App\Notifications\Emails;
use App\Package;
use App\PackageStatus;
use App\PartnerPaymentLog;
use App\PaymentLog;
use App\PaymentTask;
use App\Seller;
use App\Settings;
use App\SpecialOrder;
use App\SpecialOrderGroups;
use App\SpecialOrderPayments;
use App\SpecialOrdersSettings;
use App\SpecialOrderStatus;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Constraint\IsTrue;

use function GuzzleHttp\Promise\all;
use function PHPSTORM_META\map;

class AccountController extends Controller
{
    public $general_settings;
    private $userID;
    private $api = false;

    public function __construct(Request $request)
    {
        //		$this->middleware(['auth', 'verified']);
        $this->middleware(function ($request, $next) {

            if ($request->get('api')) {
                App::setlocale($request->get('apiLang') ?? 'en');
                $this->userID = $request->get('user_id');
                $this->api = true;
                if (Auth::guest()) {
                    $user = User::find($this->userID);
                    Auth::login($user);
                }
            } else {
                $this->userID = Auth::id();
            }
            return $next($request);
        });

        $date = Carbon::today();
        $rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
            ->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
            ->whereDate('exchange_rate.from_date', '<=', $date)
            ->whereDate('exchange_rate.to_date', '>=', $date)
            ->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
            ->orderBy('exchange_rate.id', 'desc')
            ->get();

        $general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru', 'referral_secret')->first();

        $this->general_settings = $general_settings;

        View::share(['exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]);
    }

    public function packages_price_for_last_month()
    {
        try {
            $date = Carbon::now();

            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 1) // to USD
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            //$last_month_date = Carbon::today()->subDays(30)->toDateString();

            $packages_price_for_last_month = Item::leftJoin('package as p', 'item.package_id', '=', 'p.id')
                ->whereNull('p.deleted_by')
                ->whereNotNull('p.on_the_way_date')
                ->where('p.client_id', $this->userID)
                ->whereMonth('p.on_the_way_date', date('m'))
		        ->whereYear('p.on_the_way_date', date('Y'))
                //->whereDate('p.on_the_way_date', '>=', $last_month_date)
                ->select('item.price', 'item.currency_id as price_currency', 'p.total_charge_value as amount', 'p.currency_id as amount_currency')
                ->get();

            $price_for_last_month = 0;
            $amounts_for_last_month = 0;
            foreach ($packages_price_for_last_month as $package) {
                $price_currency = $package->price_currency;
                $amount_currency = $package->amount_currency;

                if ($has_rate) {
                    $price_rate_to_usd = $this->calculate_exchange_rate($rates, $price_currency, 1);
                    $amount_rate_to_usd = $this->calculate_exchange_rate($rates, $amount_currency, 1);
                } else {
                    $price_rate_to_usd = 1;
                    $amount_rate_to_usd = 1;
                }

                $price_usd = $package->price * $price_rate_to_usd;
                $price_usd = sprintf('%0.2f', $price_usd);

                $price_for_last_month += $price_usd;

                $amount_usd = $package->amount * $amount_rate_to_usd;
                $amount_usd = sprintf('%0.2f', $amount_usd);

                $amounts_for_last_month += $amount_usd;
            }

            return sprintf('%0.2f', $price_for_last_month + $amounts_for_last_month);
        } catch (\Exception $exception) {
            return 0;
        }
    }

    public function get_account()
    {
        try {
            $countries = Country::where('url_permission', 1)->select('id', 'name_' . App::getLocale(), 'flag', 'new_flag', 'image')->orderBy('sort', 'desc')->orderBy('id')->get();

            $countr = Country::where('id', 2)->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            $not_paid_orders_count = SpecialOrderGroups::where(['is_paid' => 0, 'client_id' => $this->userID])
                ->whereNull('placed_by')
                ->whereNull('canceled_by')
                ->count();
        
 
            if ($this->api) {
                return compact(
                    'countries',
                    'countr'
                );
            }

            return view("web.account.index", compact(
                'countries',
                'countr',
                'packages_price_for_last_month',
                'not_paid_orders_count'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    // update user account details (edit)

    public function get_user_account()
    {
        return view("web.account.profile.index");
    }

    public function get_update_user_account()
    {
        try {
            $packages_price_for_last_month = $this->packages_price_for_last_month();
            $branchs = DB::table('filial')->where('is_active', 1)->get();
            return view("web.account.profile.profile_update", compact(
                'packages_price_for_last_month', 'branchs'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function post_update_user_account(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'language' => ['required', 'string', 'max:2'],
            'address' => ['required', 'string', 'max:255'],
            // 'passport_fin' => ['required', 'string', 'max:255'],
            'passport_prefix' => ['required', 'string', 'in:AZE,AA'],
            'passport_number' => ['sometimes', 'string', 'min:7'],
            /*'location_longitude' => ['required', 'string', 'max:255'],
            'location_latitude' => ['required', 'string', 'max:255'],*/
            // 'phone1' => ['required', 'string', 'max:30'],
            'phone2' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8'],
            'branch_id' => ['required', 'integer'],
            'birthday' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('get_update_user_account', ['locale' => App::getLocale()])->with([
                'case' => 'warning',
                'title' => __('static.attention'),
                'type' => 'validation',
                'content' => $validator->errors()->toArray()
            ]);
            //return response(['case' => 'warning', 'title' => __('static.attention') . '!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $id = $this->userID;
	        $currentUserData = User::where('id', $id)->first();
            $phone2 = $request->phone2;
            if ($phone2 !== null) {
                $phone2 = str_replace('(', '', $phone2);
                $phone2 = str_replace(')', '', $phone2);
                $phone2 = str_replace('-', '', $phone2);
                $phone2 = '994' . substr($phone2, 1);
                $request->phone2 = $phone2;

                if (User::whereNull('deleted_by')->where('id', '<>', $id)->whereRaw('(phone1 = ? or phone2 = ?)', [$phone2, $phone2])->select('id')->first()) {
                    return redirect()->route('get_update_user_account', ['locale' => App::getLocale()])->with([
                        'case' => 'warning',
                        'title' => __('static.attention'),
                        'type' => 'exist',
                         'input' => 'phone2',
                        'content' => __('static.phone_exists')
                    ]);
                    // return response(['case' => 'warning', 'type' => 'exist', 'input' => 'phone2', 'title' => __('static.attention') . '!', 'content' => __('register.phone_exists')]);
                }
            }

            $user_arr = array();
            $user_arr['language'] = $request->language;
            // $user_arr['phone1'] = $phone1;
            $user_arr['phone2'] = $phone2;
            $user_arr['address1'] = $request->address;
            $user_arr['location_latitude1'] = $request->location_latitude;
            $user_arr['location_longitude1'] = $request->location_longitude;
	        $user_arr['passport_series'] = $request->passport_prefix;
            $user_arr['passport_number'] = $request->get('passport_number');
             $user_arr['branch_id'] = $request->branch_id;
             $user_arr['birthday'] = $request->birthday;

            if (isset($request->password) && !empty($request->password)) {
                $user_arr['password'] = Hash::make($request->password);
            }

            User::where(['id' => $id, 'role_id' => 2])->update($user_arr);

            $request_string = json_encode($request->all());
	        $currentString = json_encode($currentUserData);

            ClientsLog::create([
                'type' => 'update',
                'client_id' => $id,
                'request' => $request_string,
	   	        'current' => $currentString,
                'role_id' => 2,
                'created_by' => $id
            ]);


            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => __('static.success'), 
                    'content' => __('static.success')
                ]);
            }

            return redirect()->route('get_update_user_account', ['locale' => App::getLocale()])->with([
                'case' => 'success',
                'title' => __('static.success'),
                'content' => __('static.success')
            ]);
            //return response(['case' => 'success', 'title' => __('static.success'), 'content' => __('static.success')]);
        } catch (\Exception $exception) {
            // dd($exception);
            return redirect()->route('get_update_user_account', ['locale' => App::getLocale()])->with([
                'case' => 'error',
                'title' => __('static.error'),
                'content' => __('static.error_text')
            ]);
            //return response(['case' => 'error', 'title' => __('static.error'), 'content' => __('static.error_text')]);
        }
    }

    public function get_update_user_password()
    {
        return view("web.account.profile.password");
    }
    public function post_update_user_password(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
            'user_re_new_password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('get_update_user_password', ['locale' => App::getLocale()])->with([
                'case' => 'warning',
                'title' => __('static.attention'),
                'type' => 'validation',
                'content' => $validator->errors()->toArray()
            ]);
        }
        try {

            if($request->password !== $request->user_re_new_password){
                return redirect()->route('get_update_user_password', ['locale' => App::getLocale()])->with([
                    'case' => 'warning',
                    'title' => __('static.attention'),
                    'type' => 'validation',
                    'content' => $validator->errors()->toArray()
                ]);
            }

            $id = $this->userID;
	        $currentUserData = User::where('id', $id)->first();
    

            $user_arr = array();
            $user_arr['passport_number'] = $request->get('passport_number');
            if (isset($request->password) && !empty($request->password)) {
                $user_arr['password'] = Hash::make($request->password);
            }

            User::where(['id' => $id, 'role_id' => 2])->update($user_arr);

            $request_string = json_encode($request->all());
	        $currentString = json_encode($currentUserData);

            ClientsLog::create([
                'type' => 'update',
                'client_id' => $id,
                'request' => $request_string,
	   	        'current' => $currentString,
                'role_id' => 2,
                'created_by' => $id
            ]);


            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => __('static.success'), 
                    'content' => __('static.success')
                ]);
            }

            return redirect()->route('get_update_user_password', ['locale' => App::getLocale()])->with([
                'case' => 'success',
                'title' => __('static.success'),
                'content' => __('static.success')
            ]);
            //return response(['case' => 'success', 'title' => __('static.success'), 'content' => __('static.success')]);
        } catch (\Exception $exception) {
            // dd($exception);
            return redirect()->route('get_update_user_password', ['locale' => App::getLocale()])->with([
                'case' => 'error',
                'title' => __('static.error'),
                'content' => __('static.error_text')
            ]);
            //return response(['case' => 'error', 'title' => __('static.error'), 'content' => __('static.error_text')]);
        }
    }

    public function update_user_profile_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'mimes:jpeg,png,jpg,jpeg,gif,svg'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => __('static.attention') . '!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $id = $this->userID;

            $image = $request->file('image');
            $image_name = 'user_' . $id . '_' . Str::random(4) . '_' . time();
            Storage::disk('uploads')->makeDirectory('account/profile');
            $cover = $image;
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('uploads')->put('account/profile/' . $image_name . '.' . $extension, File::get($cover));
            $url = '/uploads/account/profile/' . $image_name . '.' . $extension;

            User::where(['id' => $id, 'role_id' => 2])->update(['image' => $url]);

            $request_string = json_encode($request->all());

            ClientsLog::create([
                'type' => 'profile_image',
                'client_id' => $id,
                'request' => $request_string,
                'role_id' => 2,
                'created_by' => $id
            ]);

            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => __('static.success'), 
                    'content' => __('static.success'),
                    'url' => $url
                ]);
            }

            return response(['case' => 'success', 'title' => __('static.success'), 'content' => __('static.success')]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => __('static.error'), 'content' => __('static.error_text')]);
        }
    }

    // approve referral user account
    public function approve_referral_user($referral)
    {
        try {
            $referral_user = User::where(['id' => $referral, 'role_id' => 2, 'referral_unconfirm' => $this->userID])
                ->whereNull('deleted_by')
                ->select('id')
                ->first();

            if (!$referral_user) {
                $message = 'Referral account not found!';
                return redirect(route("get_account") . "?approve-referral=OK&case=warning&message=" . $message);
            }

            $contract_id = Auth::user()->contract_id();

            User::where('id', $referral_user->id)->update(['parent_id' => $this->userID, 'contract_id' => $contract_id, 'referral_unconfirm' => null]);

            $message = 'Referral account successfully approved!';

            return redirect(route("get_account") . "?approve-referral=OK&case=success&message=" . $message);
        } catch (\Exception $exception) {
            $message = 'Sorry, something went wrong!';
            return redirect(route("get_account") . "?approve-referral=OK&case=error&message=" . $message);
        }
    }

    public function get_country_details(Request $request, $locale, $country_id)
    {
        try {
            $countr = Country::whereIn('id', [2,9,12])->select('id', 'name_' . App::getLocale(), 'flag','image')->orderBy('sort', 'desc')->orderBy('id')->get();
            $not_paid_orders_count = SpecialOrderGroups::where(['is_paid' => 0, 'country_id' => $country_id, 'client_id' => $this->userID])
                    ->whereNull('placed_by')
                    ->whereNull('canceled_by')
                    ->count();
            if($country_id == 'special'){
                $countries = Country::where('url_permission', 1)->select('id', 'name_' . App::getLocale(), 'flag','image')->orderBy('sort', 'desc')->orderBy('id')->get();
               

    
                return view('front.account.country_details_special', compact(
                    'countries',
                    'countr'
                ));
            }
            $countries = Country::where('url_permission', 1)->select('id', 'name_' . App::getLocale(), 'flag', 'new_flag', 'image')->orderBy('sort', 'desc')->orderBy('id')->get();


            $selected_country = Country::where('id', $country_id)->select('id', 'name_' . App::getLocale(), 'name_en', 'new_flag')->first();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            $details = CountryDetails::where('country_id', $country_id)
                ->where('title', 'not like', $selected_country->name_en . '_%')
                ->select('title', 'information')
                ->get();
            
            $details_local = CountryDetails::where('country_id', $country_id)
                ->where('title', 'like', $selected_country->name_en . '_%')
                ->select('title', 'information')
                ->get();
            
            if ($this->api) {
                return compact(
                    'details',
                    'selected_country',
                    'details_local'
                );
            }
            return view('web.account.Warehouses.country_details', compact(
                'countries',
                'details',
                'packages_price_for_last_month',
                'selected_country',
                'details_local',
                'countr',
                'not_paid_orders_count'
            ));
        } catch (\Exception $exception) {
            //dd($exception);
            return view("front.error");
        }
    }

    // orders
    public function get_packages(Request $request)
    {
        try {

            $date = Carbon::today();
            $countries = Country::whereNotIn('id', [1, 4, 10, 13])->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('id')->get();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            //counts for status
            $counts = array();

            $counts['is_warehouse'] = DB::table('package')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 1)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
            // $counts['sent'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
            //     ->where('package.client_id', $this->userID)
            //     ->where('package.is_warehouse', 2)
            //     ->whereNull('package.deleted_by')
            //     ->whereNull('package.delivered_by')
            //     ->count();
            $counts['sent'] = DB::table('package')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 2)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
            $counts['in_office'] = DB::table('package')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 3)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();

            $counts['delivered'] = DB::table('package')
                ->where('package.client_id', $this->userID)
                ->whereNotNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->count();
            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->leftJoin('filial as f', 'package.branch_id', '=', 'f.id')
                ->where('package.client_id', $this->userID)
                ->whereNull('package.deleted_by');

            $search = array();
            $country = $request->input("country");
            $status = $request->input("status");
            $last30 = $request->input("last30"); // last 30 days
            $search['country'] = $country;

            if (isset($last30) && $last30 == 'active') {
                $last_month_date = Carbon::today()->subDays(30)->toDateString();
                $query->whereDate('package.created_at', '>=', $last_month_date);
            }
//                return $request;
//            $a=1;
//            if ($country == "null") {
//                $a++;
//            } elseif (isset($country) && !empty($country)) {
//                // search by country
//                $query->where('package.country_id', $country);
//            }

            $currentStatus=0;

            if (isset($status) && !empty($status)) {
                // search by status
                switch ($status) {

                    case 2: {
                        // incorrect_invoice (səhv invoys)
                        $query->whereNull('package.deleted_at');
                    }
                        break;
                    case 3:
                        {
                            $currentStatus = 3;
                            // is_warehouse (xarici anbardadir)
                            $query->where('package.is_warehouse', 1);
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 4:
                        {
                            $currentStatus = 4;

                            // sent (gonderilib)
                            $query->where('package.is_warehouse', 2); // flight closed
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 5:
                        {
                            $currentStatus = 5;

                            // in_office (baki ofisindedir)
                            $query->where('package.is_warehouse', 3);
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 6:
                        {
                            $currentStatus = 6;

                            // delivered (teslim edilib)
                            $query->whereNotNull('package.delivered_by');
                        }
                        break;
                    case 7:
                    {
                        $query->where('package.internal_id',$request->input("track_number"));
                        break;

                    }
                    default:
                    {
                        //default - in baku
                        $query->whereIn('package.is_warehouse',1);
                        $query->whereNull('package.delivered_by');
                        //$query->whereNull('package.delivered_by');
                        $status = 5;
                    }
                }
            } else {
                //default - in baku
                $query->whereIn('package.is_warehouse', [1,2,3]);
//                $query->whereNull('package.delivered_by');
                //$query->whereNull('package.delivered_by');
                $status = 5;
            }

            $search['status'] = $status;


            $packages = $query
                ->select(
                    'package.id',
                    'package.internal_id',
                    'item.invoice_doc',
                    'item.invoice_confirmed',
                    'item.invoice_status as invoice_status',
                    'item.id as item_id',
                    'item.price',
                    'cur.name as currency',
                    'package.number as track',
                    'package.seller_id',
                    'package.other_seller',
                    'seller.title as seller',
                    'package.volume_weight',
                    'package.gross_weight',
                    'package.chargeable_weight',
                    'package.unit',
                    'package.total_charge_value as amount',
                    //'package.amount_usd',
                    'package.paid_status',
                    'package.paid',
                    'package.paid_sum as paid_usd',
                    'package.paid_azn',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    'flight.name as flight',
                    's.status_' . App::getLocale() . ' as status',
                    's.color as status_color',
                    'package.issued_to_courier_date', // has courier (null -> false, not null -> true)
                    'package.amount_azn',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'f.name as branch_name'
                )
                ->orderBy('package.id', 'desc')
                ->get();

             
            $has_rate = true;
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 1) // to USD
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();
            if (!$rates) {
                // rate note found
                $has_rate = false;
            }

            foreach ($packages as $package) {
                $currency_id = $package->currency_id;
                if ($currency_id == 1) { // USD
                    $package->amount_usd = $package->amount;
                    continue;
                }
                $rate_to_usd = 0;
                if ($has_rate) {
                    $rate_to_usd = $this->calculate_exchange_rate($rates, $currency_id, 1);
                }
                $package->paid = $package->paid * $rate_to_usd;
                $package->amount_usd = $package->amount * $rate_to_usd;

                if ($package->issued_to_courier_date == null) {
                    $package->has_courier = 0;
                } else {
                    $package->has_courier = 1;
                }
            }

            if ($this->api) {
                return compact(
                    'packages',
                    'search',
                    'counts'
                );
            }

            $clients = User::whereNull('deleted_at')->where('id', $this->userID)->select('id','is_legality')->first();
      

            return view('web.account.packages.index', compact(
                'countries',
                'packages_price_for_last_month',
                'packages',
                'search',
                'counts',
                'last30',
                'clients',
                'currentStatus'
            ));
        } catch (\Exception $exception) {
            // dd($exception);
            return view("front.error");
        }
    }

    public function pay_package(Request $request, $package_id)
    {
        try {
            if (!is_numeric($package_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            $user_id = $this->userID;
            $user = User::where('id', $user_id)->select('balance', 'cargo_debt', 'common_debt', 'name', 'surname', 'language', 'email')->first();
            if (!$user) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Client not found!']);
            }

            $balance = $user->balance;
            
            if($this->api){
                if ($user->cargo_debt > 0 || $user->common_debt > 0) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'errorKey' => 'error.debt.package'], Response::HTTP_BAD_REQUEST);
                }

                if ($balance == 0) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'errorKey' => 'error.balance.notenough'], Response::HTTP_BAD_REQUEST);
                }
            }else{
                if ($user->cargo_debt > 0 || $user->common_debt > 0) {
                    return response(['case' => 'warning', 'title' => 'Xəbərdarlıq!', 'content' => 'Sizin sifariş et xidmətində borcunuz mövcuddur. Zəhmət olmasa ilk öncə sifariş et xidmətinə keçid edərək borcu ödəyin.']);
                }
                if ($balance == 0) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Balansınızda məbləğ yoxdur!']);
                }    
            }



            $package_exist = Package::where(['id' => $package_id, 'client_id' => $user_id, 'paid_status' => 0])
                ->where('total_charge_value', '>', 0)
                ->whereNull('delivered_by')
                ->first();
  

            if (!$package_exist) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
            }

            if ($package_exist->paid_status == 1) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package already paid!']);
            }

            if ($package_exist->issued_to_courier_date != null) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('static.packages_has_courier_message')]);
            }
    
            $amount_ceil = ceil($package_exist->amount_usd * 100) / 100;
            $external_w_debt = ceil($package_exist->external_w_debt * 100) / 100;
            $internal_w_debt = ceil($package_exist->internal_w_debt_usd * 100) / 100;
            $paid_usd = ceil($package_exist->paid_sum * 100) / 100;
    
            $total_amount_ceil = $amount_ceil + $external_w_debt + $internal_w_debt;
    
            $total_amount = number_format($total_amount_ceil, 2, '.', '');
            $total_amount = ceil(($total_amount - $paid_usd) * 100)/100;
    
   
            if ($balance < $total_amount) {
                
                if($this->api){
                    return response(['case' => 'warning', 'title' => 'Oops!', 'errorKey' => 'error.balance.notenough'], Response::HTTP_BAD_REQUEST);
                }else{
                    return response(['case' => 'warning', 'title' => 'Ooops!', 'content' => __('static.packages_balance_message')]);
                }
        
            }
            
            $residue = 0;
    
            $result = $this->CalculatePaid($package_exist);
            $pay = $result['pay_usd'];
            $pay_azn = $result['pay_azn'];
    
            $new_balance = $balance - $pay;
            User::where('id', $user_id)->update(['balance' => $new_balance]);

            $email = EmailListContent::where(['type' => 'paid_from_balance_cashier'])->first();

            if ($email) {
                $weight_type = $package_exist->chargeable_weight;
                if ($weight_type == 2) {
                    // volume
                    $weight = $package_exist->volume_weihght;
                } else {
                    // gross
                    $weight = $package_exist->gross_weight;
                }

                $client = $user->name . ' ' . $user->surname;
                $lang = strtolower($user->language);

                $email_title = $email->{'title_' . $lang}; //from
                $email_subject = $email->{'subject_' . $lang};
                $email_bottom = $email->{'content_bottom_' . $lang};
                $email_button = $email->{'button_name_' . $lang};
                $email_content = $email->{'content_' . $lang};
                $email_list_inside = $email->{'list_inside_' . $lang};

                $email_content = str_replace('{name_surname}', $client, $email_content);

                $email_list_inside = str_replace('{no}', 1, $email_list_inside);
                $email_list_inside = str_replace('{tracking_number}', $package_exist->number, $email_list_inside);
                $email_list_inside = str_replace('{weight}', $weight . ' kg', $email_list_inside);
                $email_list_inside = str_replace('{amount}', $pay_azn . ' AZN', $email_list_inside);

                $email_content = str_replace('{list_inside}', $email_list_inside, $email_content);

                $request->user()->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom, $email_button));
            }

            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => 'Paid!', 
                    'content' => 'Paid!', 
                    'residue' => $new_balance
                ]);
            }
            
            return response(['case' => 'success', 'title' => 'Paid!', 'content' => 'Paid!', 'residue' => $residue]);
        } catch (\Exception $exception) {
            //dd($exception);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!', 'errorKey' => 'error.http.500'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete_package($package_id)
    {
        try {
            if (!is_numeric($package_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            if (Package::where(['id' => $package_id, 'client_id' => $this->userID])->whereNull('internal_id')->count() > 0) {
                Package::where(['id' => $package_id])
                    ->update([
                        'deleted_by' => $this->userID,
                        'deleted_at' => Carbon::now()
                    ]);

                Item::where('package_id', $package_id)
                    ->update([
                        'deleted_by' => $this->userID,
                        'deleted_at' => Carbon::now()
                    ]);
            } else {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'id' => $package_id]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_preliminary_declaration()
    {
        try {
            $categoryArray = [];
            $countries = Country::whereNotIn('id', [1, 4, 10, 13])
                ->select('id', 'name_' . App::getLocale(), 'flag')
                ->orderBy('id')
                ->get();
            $sellers = Seller::orderBy('title')->select('id', 'title')->get();
            $categories = Category::orderBy('name_' . App::getLocale())->select(['id', 'name_' . App::getLocale(), 'country_id'])->get()->toArray();
            $fieldName = 'name_' . App::getLocale();
            foreach ($categories as $category) {
                $categoryArray[] = [
                    'id' => $category['id'],
                    'name' => $category[$fieldName],
                    'country_id' => $category['country_id']
                ];
            }
            $categories = collect($categoryArray);
            $currencies = Currency::orderBy('name')->select('id', 'name')->get();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            return view('front.account.add_order', compact(
                'countries',
                'sellers',
                'categories',
                'packages_price_for_last_month',
                'currencies'
            ));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return view("front.error");
        }
    }

    public function post_preliminary_declaration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => ['required', 'integer'],
            'currency_id' => ['required', 'integer'],
            'track' => ['required', 'string', 'max:255'],
            'seller_id' => ['nullable', 'integer'],
            'other_seller' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:500'],
            //'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'invoice' => ['required', 'mimes:pdf,docx,doc,png,jpg,jpeg'],
            'remark' => ['nullable', 'string', 'max:5000'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $currency_id = $request->currency_id;

            if (empty($request->seller_id) && empty($request->other_seller)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Seller cannot be empty!']);
            }

            $package_arr = array();
            $package_arr['country_id'] = $request->country_id;
            $package_arr['number'] = $request->track;
            $package_arr['remark'] = $request->remark;
            $package_arr['seller_id'] = $request->seller_id;
            if ($request->seller_id == 0) {
                $other_seller = $request->other_seller;
                $package_arr['other_seller'] = $other_seller;
            }

            $package_exist = Package::where(['number' => $request->track])->select('id', 'client_id')->orderBy('id', 'desc')->first();
            if ($package_exist) {
                if ($package_exist->client_id == 0) {
                    return response(['case' => 'warning', 'title' => 'Naməlum bağlama!', 'content' => $request->track . ' track nömrəli bağlama naməlum bağlamalar siyahısındadır. Əgər bağlama sizə aiddirsə müştəri xidmətləri ilə əlaqə saxlamağınızı xahiş edirik!']);
                }
                // update
                $client_id = $package_exist->client_id;
                if ($client_id != null && $client_id != $this->userID) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
                }
                $package_id = $package_exist->id;
                Package::where('id', $package_id)->update($package_arr);

                $status_id = 35; // invoice uploaded
            } else {
                // insert
                $package_arr['client_id'] = $this->userID;
                $package_arr['created_by'] = $this->userID;
                $package = Package::create($package_arr);
                $package_id = $package->id;

                $status_id = 11; // declared
            }

            PackageStatus::create([
                'package_id' => $package_id,
                'status_id' => $status_id,
                'created_by' => $this->userID
            ]);

            if ($currency_id == 1) {
                // USD
                $price_usd = $request->price;
            } else {
                $date = Carbon::today();
                $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date)
                    ->where(['from_currency_id' => 1, 'to_currency_id' => $currency_id]) //to USD
                    ->select('rate')
                    ->orderBy('id', 'desc')
                    ->first();

                $price_usd = 0;
                if ($rate) {
                    $price_usd = $request->price / $rate->rate;
                    $price_usd = sprintf('%0.2f', $price_usd);
                }
            }

            $item_arr = array();
            $item_arr['package_id'] = $package_id;
            $item_arr['category_id'] = $request->category_id;
            $item_arr['price'] = $request->price;
            $item_arr['price_usd'] = $price_usd;
            $item_arr['currency_id'] = $currency_id;
            //$item_arr['quantity'] = $request->quantity;
            $item_arr['title'] = $request->title;
            $file = $request->file('invoice');
            $file_name = $request->track . '_invoice_' . Str::random(4) . '_' . time();
            Storage::disk('uploads')->makeDirectory('files/packages/invoices');
            $cover = $file;
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('uploads')->put('files/packages/invoices/' . $file_name . '.' . $extension, File::get($cover));
            $url = '/uploads/files/packages/invoices/' . $file_name . '.' . $extension;
            $item_arr['invoice_doc'] = $url;
            $item_arr['invoice_uploaded_date'] = Carbon::now();
            $item_arr['invoice_confirmed'] = 2;
            $item_exist = Item::where('package_id', $package_id)->select('id')->orderBy('id', 'desc')->first();
            if ($item_exist) {
                // update
                Item::where('id', $item_exist->id)->update($item_arr);
            } else {
                // insert
                $item_arr['created_by'] = $request->created_by;
                Item::create($item_arr);
            }

            InvoiceLog::create([
                'package_id' => $package_id,
                'client_id' => $this->userID,
                'invoice' => $request->price,
                'currency_id' => $currency_id,
                'invoice_doc' => $url,
                'created_by' => $this->userID
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Success!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_package_update(Request $request, $locale,$package_id)
    {
        try {
            $package = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->where(['package.id' => $package_id, 'package.client_id' => $this->userID])
                //->where('package.is_warehouse', '<', 2)
                //->whereNull('package.internal_id')
                //->whereRaw('(package.internal_id is null or item.invoice_doc is null or item.invoice_confirmed <> 1)')
                ->whereNull('package.deleted_by')
                ->select(
                    'package.id',
                    'package.internal_id',
                    'item.currency_id',
                    'package.number as track',
                    'package.seller_id',
                    'package.other_seller',
                    'item.category_id',
                    'item.title',
                    //'item.quantity',
                    'item.price',
                    'item.invoice_doc',
                    'package.remark',
                    'package.last_status_id',
                    'package.country_id'
                )
                ->first();

            //dd($package);
            if($package->last_status_id == 7){
                return 'Qadağan olunan məhsullarda düzəliş edilə bilməz.';
            }

            if ($package) {
                $sellers = Seller::orderBy('title')->select('id', 'title')->get();
                $categories = Category::orderBy('name_' . App::getLocale())
                    ->select('id', 'name_' . App::getLocale(), 'country_id')
                    ->whereNull('country_id')
                    ->get();
                $currencies = Currency::orderBy('name')->select('id', 'name')->get();

                //$countries = Country::where('id', '<>', 1)->select('id', 'name', 'flag')->orderBy('id')->get();

                if ($this->api) {
                    return compact(
                        'package'
                    );
                }
                return view('web.account.packages.update_order', compact(
                    'package',
                    'sellers',
                    'categories',
                    'currencies'
                ));
            } else {
                if ($this->api) {
                    return compact(
                        'package'
                    );
                }
                return redirect()->route("get_orders");
            }
        } catch (\Exception $exception) {
            //dd($exception);
            if ($this->api) {
                return 'Something goes wrong!';
            }
            return view("front.error");
        }
    }

    public function post_package_update(Request $request, $locale, $package_id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'currency_id' => ['required', 'integer'],
            'seller_id' => ['nullable', 'integer'],
            'other_seller' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:500'],
            //'quantity' => ['nullable', 'integer'],
            'price' => ['required'],
            'invoice' => ['nullable', 'mimes:pdf,png,jpg,jpeg'],
            'remark' => ['nullable', 'string', 'max:5000'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                'case' => 'warning',
                'title' => 'Oops!',
                'type' => 'validation',
                'content' => $validator->errors()->toArray()
            ]);
            //return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        if ($request->get('price') < 1) {
            return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                'case' => 'warning',
                'title' => 'Warning!',
                'type' => 'validation',
                'content' => 'Invoice price cannot be 0'
            ]);
        }
        try {
            if (empty($request->seller_id) && empty($request->other_seller)) {
                return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'type' => 'validation',
                    'content' => 'Seller cannot be empty!'
                ]);
            }

            $item_exist = Item::where('package_id', $package_id)->select('id', 'invoice_doc', 'invoice_status')->orderBy('id', 'desc')->first();

            if (!$item_exist) {
                return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'type' => 'validation',
                    'content' => 'Item not found!'
                ]);
            }

            if ($item_exist->invoice_status == 3) {
                return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'type' => 'validation',
                    'content' => 'Cannot update on Invoice Available status'
                ]);
            }

            $old_invoice_doc = $item_exist->invoice_doc;

            if (!isset($request->invoice) && $old_invoice_doc == null) {
        //                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('static.invoice_file_cannot_be_null')]);
            }

            $package_arr = array();
            $package_arr['seller_id'] = $request->seller_id;
            $package_arr['remark'] = $request->remark;
            if ($request->seller_id == 0) {
                $other_seller = $request->other_seller;
                $package_arr['other_seller'] = $other_seller;
            }

            $package_exist = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->where(['package.id' => $package_id])
                ->whereRaw('(package.internal_id is null or item.invoice_doc is null or item.invoice_confirmed <> 1)')
                ->whereNotIn('package.carrier_status_id', [7, 8])
                ->select('package.client_id', 'package.country_id', 'package.internal_id', 'last_status_id', 'carrier_status_id')->first();
            if (!$package_exist) {
                return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'type' => 'validation',
                    'content' => 'Package not found or package cannot be updated by customs reason!'
                ]);
                //return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found or package cannot be updated by customs reason!']);
            }

            $client_id = $package_exist->client_id;
            if ($client_id != null && $client_id != $this->userID) {
                return redirect()->route('get_package_update', ['locale' => App::getLocale(), $package_id])->with([
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'type' => 'validation',
                    'content' => 'Access denied!'
                ]);
            }

            $user = User::where('id', $client_id)->select('is_legality')->first();

            $currency_id = $request->currency_id;
  

            Package::where('id', $package_id)->update($package_arr);

            $date = Carbon::today();
            $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where(['from_currency_id' => 1, 'to_currency_id' => $currency_id]) //to USD
                ->select('rate')
                ->orderBy('id', 'desc')
                ->first();

            $price_usd = 0;
            if ($rate) {
                $price_usd = $request->price / $rate->rate;
                $price_usd = sprintf('%0.2f', $price_usd);
            }

            $item_arr = array();
            $item_arr['package_id'] = $package_id;
            $item_arr['price'] = $request->price;
            $item_arr['currency_id'] = $currency_id;
            $item_arr['price_usd'] = $price_usd;
	        $item_arr['title'] = $request->title;

            if (isset($request->invoice)) {
                $file = $request->file('invoice');
                $file_name = $request->track . '_invoice_' . Str::random(4) . '_' . time();
                Storage::disk('uploads')->makeDirectory('files/packages/invoices');
                $cover = $file;
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('uploads')->put('files/packages/invoices/' . $file_name . '.' . $extension, File::get($cover));
                $url = '/uploads/files/packages/invoices/' . $file_name . '.' . $extension;
                $item_arr['invoice_doc'] = $url;
                $item_arr['invoice_uploaded_date'] = Carbon::now();
                $item_arr['invoice_confirmed'] = 2;
                $item_arr['invoice_status'] = 4;
            } else {
                $url = null;
            }

            $item_arr['category_id'] = $request->category_id;
            $item_arr['title'] = $request->title;
            if($user->is_legality != 1){
                if (
                    $package_exist->title != $item_arr['title'] or
                    $package_exist->price != $item_arr['price'] or
                    $package_exist->currency_id != $item_arr['currency_id'] or
                    $package_exist->price_usd != $item_arr['price_usd'] or
                    $package_exist->category_id != $item_arr['category_id']
                ) {
                    Package::where('id', $package_id)
                        ->whereNotIn('carrier_status_id', [1, 2, 3, 7, 8])
                        ->update([
                            'carrier_status_id' => 9,
                        ]);
                }
            }
            
            Item::where('id', $item_exist->id)->update($item_arr);

            InvoiceLog::create([
                'package_id' => $package_id,
                'client_id' => $this->userID,
                'invoice' => $request->price,
                'currency_id' => $currency_id,
                'invoice_doc' => $url,
                'created_by' => $this->userID,
                'status_id' => 35
            ]);

            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => 'Success!', 
                    'content' => 'Success!',
                    'item_arr' => $item_arr
                ]);
            }

            return redirect()->route('get_orders', ['locale' => App::getLocale()])->with([
                'case' => 'success',
                'title' => 'Success!',
                'content' => 'Success'
            ]);
        }
        catch (\Exception $exception) {
            dd($exception);
            return redirect()->route('get_orders', ['locale' => App::getLocale()])->with([
                'case' => 'error',
                'title' => 'Error!',
                'content' => 'Sorry, something went wrong!'
            ]);
            //return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!', 'errorKey' => 'error.http.500'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_package_items(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => 'Package not found!']);
        }
        try {
            $package_id = $request->id;

            $items = Item::leftJoin('category as cat', 'item.category_id', '=', 'cat.id')
                ->leftJoin('package as p', 'p.id', '=', 'item.package_id')
                ->leftJoin('seller as s', 's.id', '=', 'p.seller_id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->where('item.package_id', $package_id)
                ->select(
                    'item.id',
                    'item.title',
                    'cat.name_' . App::getLocale() . ' as category',
                    'item.price',
                    'cur.name as currency',
                    's.name as seller_name'
                )
                ->get();


            if($this->api){
                return response([
                    'case' => 'success', 
                    'title' => 'Success!', 
                    'content' => 'Successful!', 
                    'items' => $items]);
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'items' => $items]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    // special orders

    public function get_special_orders_select(Request $request)
    {
        try 
        {
            $countries = Country::whereIn('id', [2,9,12])->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();
            $countr = Country::whereIn('id', [2,9,12])->select('id', 'name_' . App::getLocale(), 'flag','image')->orderBy('sort', 'desc')->orderBy('id')->get();
            $not_paid_orders_count = SpecialOrderGroups::where(['is_paid' => 0, 'client_id' => $this->userID])
                    ->whereNull('placed_by')
                    ->whereNull('canceled_by')
                    ->count();


            $query = SpecialOrderGroups::leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->leftJoin('lb_status as s', 'special_order_groups.last_status_id', '=', 's.id')
                ->where(['special_order_groups.client_id' => $this->userID]);

            $orders = $query->orderBy('special_order_groups.id', 'desc')
                ->select(
                    'special_order_groups.id',
                    'special_order_groups.group_code',
                    'special_order_groups.urls',
                    'special_order_groups.price',
                    'cur.name as currency',
                    's.status_' . App::getLocale() . ' as status',
                    'special_order_groups.is_paid',
                    'special_order_groups.paid',
                    'special_order_groups.disable',
                    'special_order_groups.cargo_debt',
                    'special_order_groups.common_debt',
                    'special_order_groups.waiting_for_payment'
                )
                ->get();

            foreach ($orders as $order) {
                //$order->price_azn = sprintf('%0.2f', $order->price * $rate_azn);
                //$order->cargo_debt_azn = sprintf('%0.2f', $order->cargo_debt * $rate_azn);
                //$order->common_debt_azn = sprintf('%0.2f', $order->common_debt * $rate_azn);
                $total_amount = ($order->price - $order->paid) + $order->cargo_debt + $order->common_debt;
                $order->total_amount = sprintf('%0.2f', $total_amount);
                //$order->total_amount_azn = sprintf('%0.2f', $total_amount * $rate_azn);
            }

            $country_id=2;
            return view("front.account.special_order_country", compact(
                'countries',
                'countr',
                'not_paid_orders_count',
                'orders',
                'country_id'
            ));

        } catch (\Exception $exception) {
            return $exception->getMessage();
            if ($this->api) {
                return 'Something goes wrong!';
            }
            return view("front.error");
        }
    }
    public function get_special_orders(Request $request,$a, $country_id)
    {
        try {
            $countr = Country::whereIn('id', [2,9,12])->select('id', 'name_' . App::getLocale(), 'flag','image')->orderBy('sort', 'desc')->orderBy('id')->get();

            //return redirect()->route("get_account");

            $settings = SpecialOrdersSettings::first();
    
            if (!$settings || $settings->active == 0) {
                Session::flash('message', $settings->message);
                Session::flash('special_orders_active', 'false');
                if ($this->api) {
                    return $settings->message;
                }
                return redirect()->route("get_account");
            }


            $percent = $settings->percent;

            $has_campaign = $settings->has_campaign;
            $campaign_text = $settings->campaign;

            if (Country::where(['id' => $country_id])->count() == 0) {
                if ($this->api) {
                    return 'Country not found!';
                }
                return redirect()->route("get_account",['locale' => App::getLocale()]);
            }

            $currency = Country::leftJoin('currency as cur', 'countries.local_currency', '=', 'cur.id')
                ->where('countries.id', $country_id)
                ->select('cur.name', 'countries.local_currency as currency_id')
                ->first();

            if ($currency) {
                $currency_name = $currency->name;
                $currency_id = $currency->currency_id;
            } else {
                if ($this->api) {
                    return 'Currency not found!';
                }
                return redirect()->route("get_account");
                //$currency_name = 'Currency not found!';
            }

            $date = Carbon::today();
            $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where(['from_currency_id' => $currency_id, 'to_currency_id' => 3]) //to AZN
                ->select('rate')
                ->orderBy('id', 'desc')
                ->first();

            if (!$rate) {
                if ($this->api) {
                    return 'Rate not found!';
                }
                return redirect()->route("get_account");
            }
            $rate_azn = $rate->rate;

            $countr = Country::whereIn('id', [2,9,12])->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();
            $countrFlag = Country::where('id', $country_id)->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->first();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            $query = SpecialOrderGroups::leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->leftJoin('lb_status as s', 'special_order_groups.last_status_id', '=', 's.id')
                ->where(['special_order_groups.client_id' => $this->userID, 'special_order_groups.country_id' => $country_id]);

            $where_paid_status = $request->input("paid");
            if (isset($where_paid_status) && $where_paid_status == 'no') {
                $query->where('special_order_groups.is_paid', 0);
            }

            $where_archive_status = $request->input("archive");
            if (!isset($where_archive_status) || $where_archive_status != 'yes') {
                $query->whereNull('special_order_groups.placed_by');
                $query->whereNull('special_order_groups.canceled_by');
            }

            $not_paid_orders_count = SpecialOrderGroups::where(['is_paid' => 0, 'country_id' => $country_id, 'client_id' => $this->userID])
                ->whereNull('placed_by')
                ->whereNull('canceled_by')
                ->count();

            $orders = $query->orderBy('special_order_groups.id', 'desc')
                ->select(
                    'special_order_groups.id',
                    'special_order_groups.group_code',
                    'special_order_groups.urls',
                    'special_order_groups.price',
                    'cur.name as currency',
                    's.status_' . App::getLocale() . ' as status',
                    'special_order_groups.is_paid',
                    'special_order_groups.paid',
                    'special_order_groups.disable',
                    'special_order_groups.cargo_debt',
                    'special_order_groups.common_debt',
                    'special_order_groups.waiting_for_payment'
                )
                ->get();

            foreach ($orders as $order) {
                //$order->price_azn = sprintf('%0.2f', $order->price * $rate_azn);
                //$order->cargo_debt_azn = sprintf('%0.2f', $order->cargo_debt * $rate_azn);
                //$order->common_debt_azn = sprintf('%0.2f', $order->common_debt * $rate_azn);
                $total_amount = ($order->price - $order->paid) + $order->cargo_debt + $order->common_debt;
                $order->total_amount = sprintf('%0.2f', $total_amount);
                //$order->total_amount_azn = sprintf('%0.2f', $total_amount * $rate_azn);
            }
            if ($this->api) {
                return compact(
                    'orders'
                );
            }
//            return $countr;
            return view("front.account.special_order", compact(
                'countr',
                'packages_price_for_last_month',
                'country_id',
                'orders',
                'currency_name',
                'not_paid_orders_count',
                'percent',
                'campaign_text',
                'has_campaign',
                'countrFlag'
            ));
            // if($country_id == 7 || $country_id == 2){
               

            // }else{
            //     return redirect()->back();
            // }
        } catch (\Exception $exception) {
            if ($this->api) {
                return 'Something goes wrong!';
            }
            return $exception;
        }
    }

    public function show_orders_for_group_special_orders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
        }
        try {
            $group_code = $request->group_id;

            $orders = SpecialOrder::leftJoin('lb_status as status', 'special_orders.last_status_id', '=', 'status.id')
                ->where('special_orders.group_code', $group_code)
                ->select(
                    'special_orders.url',
                    'special_orders.price',
                    'special_orders.quantity',
                    'special_orders.description',
                    'status.status_' . App::getLocale() . ' as status'
                )
                ->get();

            if (count($orders) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Orders not found!']);
            }

            if($this->api){
                return response([
                    'case' => 'Success',
                    'orders' => $orders
                ]);
            }

            return response(['case' => 'success', 'orders' => $orders]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
    
    public function pay_to_special_order($country_id, $order_id)
    {
        try {
            if (!is_numeric($order_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }
            
            $order = SpecialOrderGroups::where('id', $order_id)->select('id', 'price', 'paid', 'cargo_debt', 'common_debt', 'group_code')->first();
            
            if (!$order) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Order not found!']);
            }
            
            $amount = ($order->price - $order->paid) + $order->cargo_debt + $order->common_debt;
            
            $special_orders = SpecialOrder::where('group_code', $order->group_code)
                ->select('id', 'price', 'quantity')
                ->get();
            
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_basket_arr = array();
            $orders_id_arr = array();
            $total_single_price = 0;
            $total_price = 0;
            $urls = '';
            
            $user_basket_arr = array();
            foreach ($special_orders as $special_order) {
                $order_arr = array();
                array($order_arr, $special_order->id);
                array($order_arr, $special_order->price);
                array($order_arr, $special_order->quantity);
                
                array_push($user_basket_arr, $order_arr);
            }
            
            $user_basket = base64_encode(json_encode($user_basket_arr));
            //$paytr = $this->amount_send_to_paytr($country_id, $user_basket, $amount);
            $pay = $this->pay_to_pashaBank_special($amount, Auth::user()->id, $ip_address);
            
            $url = $pay[2];
            $merchant_oid =  urldecode($pay[3]);
            
            
            SpecialOrderPayments::create([
                'order_id' => $order_id,
                'payment_key' => $merchant_oid,
                'created_by' => $this->userID
            ]);
            
            SpecialOrderStatus::create([
                'order_id' => $order_id,
                'status_id' => 32,
                'created_by' => $this->userID
            ]);
            
            
            if($this->api){
                return response(['case' => 'success', 'url' => $url]);
            }
            
            return response(['case' => 'success', $url]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
    
    
    private function pay_to_pashaBank_special($get_amount, $user_id, $ip_address, $payment_type = 'specialOrder', $order_id = 0, $packages_str = null)
    {
        try {
            $date = Carbon::today();
            $rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
            ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->select('rate')
                ->first();
            
            $amount = sprintf('%0.2f', ($get_amount * $rate->rate)) * 100;
            
            $client_url = "";
            $currency = 944;
            $description = "c_" . $user_id;
            $language = "az";
            
            $ca = "/var/www/sites/certificates_special/PSroot.pem";
            $key = "/var/www/sites/certificates_special/rsa_key_pair.pem";
            $cert = "/var/www/sites/certificates_special/certificate.0032188.pem";
            
            $merchant_handler = "https://ecomm.pashabank.az:18443/ecomm2/MerchantHandler";
            $client_handler = "https://ecomm.pashabank.az:8463/ecomm2/ClientHandler";
            
            $params['command'] = "V";
            $params['amount'] = $amount;
            $params['currency'] = $currency;
            $params['description'] = $description;
            $params['language'] = $language;
            $params['msg_type'] = "SMS";
            $params['client_ip_addr'] = $ip_address;
            $params['terminal_id'] = "EC101948";
            
            
            $qstring = http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $merchant_handler);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);
            curl_setopt($ch, CURLOPT_SSLCERT, $cert);
            curl_setopt($ch, CURLOPT_SSLKEY, $key);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");
            //curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $password);
            curl_setopt($ch, CURLOPT_CAPATH, $ca);
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            $result = curl_exec($ch);
            
            if(empty($result)) $errors[] = 'Ödəniş sistemində xəta baş verdi. Bir az sonra yenidən cəhd edin';
            
            if(!empty($result)){
                
                if (curl_error($ch)) array_push($errors, 'Payment error!');
                
                curl_close($ch);
                
                $trans_ref = explode(' ', $result)[1];
                $payment_task = $this->generate_payment_task_pasha("pasha", $ip_address, $payment_type, $order_id, $packages_str, $trans_ref, $amount, $this->api);
                
                $trans_ref = urlencode($trans_ref);
                $client_url = $client_handler . "?trans_id=" . $trans_ref;
            }
            
            return ['success', 'Uğurlu', $client_url, $trans_ref];
        } catch (\Exception $exception) {
            Session::flash('message', "Səhv baş verdi!");
            Session::flash('class', "page-failed");
            Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
            Session::flash('display', 'block');
            if ($this->api) {
                return 'Səhv baş verdi!';
            }
            return redirect()->route("get_balance_page");
            
        }
    }
    
    private function amount_send_to_paytr($country_id, $user_basket, $price)
    {
        $merchant_id = '122743';
        $merchant_key = '1XFsb51gWB4sCAq3';
        $merchant_salt = 'xBfZx49J8TnYx9Zt';

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $email = Auth::user()->email;
        $payment_amount = sprintf('%0.2f', $price) * 100;

        //payment task
        $merchant_oid = $this->generate_payment_task("paytr", $ip, 'special_order');

        $user_name = Auth::user()->name . Auth::user()->surname;
        $user_address = Auth::user()->address1;
        $user_phone = Auth::user()->phone1;
        $merchant_ok_url = route("special_order", $country_id) . "?pay=success";
        $merchant_fail_url = route("special_order", $country_id) . "?pay=error";

        $user_ip = $ip;
        $timeout_limit = "30";
        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 1;
        $test_mode = 0;

        $no_installment = 1; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın
        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;

        $currency = "TL";

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
        $post_vals = array(
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket,
            'debug_on' => $debug_on,
            'no_installment' => $no_installment,
            'max_installment' => $max_installment,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit' => $timeout_limit,
            'currency' => $currency,
            'test_mode' => $test_mode
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            return [false, "PAYTR IFRAME connection error. err:" . curl_error($ch)];
        }

        curl_close($ch);

        $result = json_decode($result, 1);

        if ($result['status'] == 'success') {
            $token = $result['token'];
            return [true, $token, $merchant_oid];
        } else {
            return [false, "PAYTR IFRAME failed. reason:" . $result['reason']];
        }
    }

    public function add_special_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url.*' => ['required', 'string', 'max:1000'],
            'url' => ['required', 'array'],
            'quantity.*' => ['required', 'integer'],
            'quantity' => ['required', 'array'],
            'price.*' => ['required', 'between:0,99.99'],
            'price' => ['required', 'array'],
            'color.*' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'array'],
            'size.*' => ['nullable', 'string', 'max:100'],
            'description.*' => ['nullable', 'string', 'max:1000'],
            'country_id' => ['required', 'int'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $settings = SpecialOrdersSettings::where('id', 1)->select('percent')->first();
        
            if (!$settings) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Settings not found!']);
            }
            $country_id = $request->country_id;
            $group_code = Str::random(200) . time() . $this->userID;
        
            $lang = strtolower(Auth::user()->language());
        
            $percent = $settings->percent;
        
            $country = Country::where('id', $country_id)->select('local_currency as currency_id', 'countries.name_' . $lang . ' as name')->first();
            if ($country) {
                $currency_id = $country->currency_id;
            } else {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Country not found!']);
            }
            $ip_address = $request->ip();
            $user_basket_arr = array();
            $orders_id_arr = array();
            $total_single_price = 0;
            $total_price = 0;
            $urls = '';
            for ($i = 0; $i < count($request->url); $i++) {
                $url = $request->url[$i];
                $urls .= $url . ',';
                $quantity = $request->quantity[$i];
                $single_price = $request->price[$i];
                $color = $request->color[$i];
                $size = $request->size[$i];
                $description = $request->description[$i];
            
                if ($quantity < 1) {
                    SpecialOrder::where('group_code', $group_code)->update(['deleted_by' => 1907, 'deleted_at' => Carbon::now()]);
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Say 1-dən kiçik ola bilməz!']);
                }
            
                if ($single_price < 0.01) {
                    SpecialOrder::where('group_code', $group_code)->update(['deleted_by' => 1907, 'deleted_at' => Carbon::now()]);
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Qiymət 0.01-dən kiçik ola bilməz!']);
                }
            
                $single_price = str_replace(',', '.', $single_price);
            
                $multi_price = $single_price * $quantity;
                $price = $multi_price + ($multi_price * $percent) / 100;
            
                $price = sprintf('%0.2f', $price);
            
                $total_price += $price;
                $total_single_price += $multi_price;
            
                $special_order = SpecialOrder::create([
                    'url' => $url,
                    'quantity' => $quantity,
                    'single_price' => $single_price,
                    'price' => $price,
                    'color' => $color,
                    'size' => $size,
                    'description' => $description,
                    'group_code' => $group_code,
                    'created_by' => $this->userID,
                    'last_status_id' => 10, //special order created
                ]);
            
                $order_arr = array();
                array($order_arr, $special_order->id);
                array($order_arr, $price);
                array($order_arr, $quantity);
            
                array_push($user_basket_arr, $order_arr);
            
                array_push($orders_id_arr, $special_order->id);
            }
        
            $urls = substr($urls, 0, -1);
        
            $group = SpecialOrderGroups::create([
                'client_id' => $this->userID,
                'country_id' => $country_id,
                'urls' => $urls,
                'single_price' => $total_single_price,
                'price' => $total_price,
                'currency_id' => $currency_id,
                'is_paid' => 0,
                'group_code' => $group_code,
                'created_by' => $this->userID
            ]);
        
            SpecialOrderStatus::create([
                'order_id' => $group->id,
                'status_id' => 10, //not paid
                'created_by' => $this->userID
            ]);
        
            $user_basket = base64_encode(json_encode($user_basket_arr));
        
            $pay = $this->pay_to_pashaBank_special($total_price, Auth::user()->id, $ip_address);
        
        
            $merchant_oid =  urldecode($pay[3]);
            $url = $pay[2];
            //SpecialOrderGroups::where('id', $group->id)->update(['pay_id' => $merchant_oid]);
        
            SpecialOrderPayments::create([
                'order_id' => $group->id,
                'payment_key' => $merchant_oid,
                'created_by' => $this->userID
            ]);
        
            SpecialOrderStatus::create([
                'order_id' => $group->id,
                'status_id' => 32,
                'created_by' => $this->userID
            ]);
    
            return response(['case' => 'success', $url]);
    
        } catch (\Exception $exception) {
            //dd($exception);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!', 'errorKey' => 'error.http.500'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete_special_order($country_id, $order_id)
    {
        try {
            if (!is_numeric($order_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            $group = SpecialOrderGroups::where(['id' => $order_id, 'client_id' => $this->userID, 'disable' => 0, 'is_paid' => 0, 'waiting_for_payment' => 0])
                ->select('group_code')->first();

            if (!$group) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Order not found!']);
            }

            SpecialOrderGroups::where(['id' => $order_id])
                ->update([
                    'deleted_by' => $this->userID,
                    'deleted_at' => Carbon::now()
                ]);

            SpecialOrder::where(['group_code' => $group->group_code, 'created_by' => $this->userID])
                ->update([
                    'deleted_by' => $this->userID,
                    'deleted_at' => Carbon::now()
                ]);

            if ($this->api) {
                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'id' => $order_id]);
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'id' => $order_id]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_special_order_update($country_id, $order_id)
    {
        try {
            $settings = SpecialOrdersSettings::first();
            if ($settings->active == 0) {
                if ($this->api) {
                    return $settings->message;
                }
                Session::flash('message', $settings->message);
                Session::flash('special_orders_active', 'false');
                return redirect()->route("get_account");
            }

            if (!is_numeric($order_id)) {
                if ($this->api) {
                    return 'Order Id must be numeric';
                }
                return redirect()->route("special_order", $country_id);
            }

            if (Country::where(['id' => $country_id, 'url_permission' => 1])->count() === 0) {
                if ($this->api) {
                    return 'Country not found';
                }
                return redirect()->route("get_account");
            }

            $not_paid_orders_count = SpecialOrderGroups::where(['is_paid' => 0, 'country_id' => $country_id, 'client_id' => $this->userID])
                ->whereNull('placed_by')
                ->whereNull('canceled_by')
                ->count();

            $group = SpecialOrderGroups::leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->where(['special_order_groups.id' => $order_id, 'special_order_groups.client_id' => $this->userID])
                ->select('special_order_groups.id', 'special_order_groups.group_code', 'cur.name as currency', 'special_order_groups.disable')
                ->first();

            if (!$group || $group->disable == 1) {
                if ($this->api) {
                    return 'Group not found';
                }
                return redirect()->route("special_order", $country_id);
            }

            $orders = SpecialOrder::where(['group_code' => $group->group_code, 'created_by' => $this->userID])
                ->select('id', 'url', 'quantity', 'single_price as price', 'color', 'size', 'description')
                ->get();

            if (count($orders) == 0) {
                if ($this->api) {
                    return compact(
                        'orders'
                    );
                }
                return redirect()->route("special_order", $country_id);
            }

            $countr = Country::whereNotIn('id', [7])->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            if ($this->api) {
                return compact(
                    'orders'
                );
            }

            return view("front.account.special_order_update", compact(
                'group',
                'orders',
                'countr',
                'packages_price_for_last_month',
                'country_id',
                'not_paid_orders_count'
            ));
        } catch (\Exception $exception) {
            if ($this->api) {
                return 'Something goes wrong!';
            }
            return view("front.error");
        }
    }

    public function update_special_order(Request $request, $country_id, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'order_id.*' => ['required', 'integer'],
            'order_id' => ['required', 'array'],
            'color.*' => ['nullable', 'string', 'max:100'],
            'color' => ['required', 'array'],
            'size.*' => ['nullable', 'string', 'max:100'],
            'size' => ['required', 'array'],
            'description.*' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'array'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            if (!is_numeric($order_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            $color = $request->color;
            $size = $request->size;
            $description = $request->description;

            $group = SpecialOrderGroups::where(['id' => $order_id, 'client_id' => $this->userID, 'disable' => 0, 'is_paid' => 0, 'waiting_for_payment' => 0])
                ->select('group_code')
                ->first();

            if (!$group) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Order not found!']);
            }

            for ($i = 0; $i < count($request->order_id); $i++) {
                SpecialOrder::where(['group_code' => $group->group_code, 'id' => $request->order_id[$i], 'created_by' => $this->userID])->update([
                    'color' => $color[$i],
                    'size' => $size[$i],
                    'description' => $description[$i]
                ]);
            }

            if ($this->api) {
                return response([
                    'case' => 'success', 
                    'title' => 'Uğurlu!', 
                    'content' => 'Sifariş bilgiləri uğurla dəyişdirildi!',
                    'group' => $group
                ]);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş bilgiləri uğurla dəyişdirildi!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    // sub accounts
    public function get_sub_accounts()
    {
        try {
            $packages_price_for_last_month = $this->packages_price_for_last_month();

            $date = Carbon::now();

            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 1) // to USD
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            $sub_accounts = User::where('parent_id', $this->userID)
                ->select(
                    'id',
                    'name',
                    'surname',
                    'balance'
                )
                ->get();

            $i = 0;
            $total_debt = 0;

            foreach ($sub_accounts as $account) {
                $total_amount = 0;

                if ($this->general_settings->referral_secret == 1) {
                    $packages = Item::leftJoin('package as p', 'item.package_id', '=', 'p.id')
                        ->whereNull('p.deleted_by')
                        ->where('p.client_id', $account->id)
                        ->where('p.paid_status', 0)
                        ->where('p.total_charge_value', '>', 0)
                        ->select('p.total_charge_value as amount', 'p.paid', 'p.currency_id as amount_currency')
                        ->get();

                    foreach ($packages as $package) {
                        $currency_id = $package->amount_currency;

                        if ($has_rate) {
                            $rate_to_usd = $this->calculate_exchange_rate($rates, $currency_id, 1);
                        } else {
                            $rate_to_usd = 1;
                        }

                        $amount = $package->amount;
                        $paid = $package->paid;

                        $debt = $amount - $paid;
                        $debt_usd = $debt * $rate_to_usd;

                        $debt_usd = sprintf('%0.2f', $debt_usd);

                        $total_amount += $debt_usd;
                    }

                    $total_amount = sprintf('%0.2f', $total_amount);
                }

                $sub_accounts[$i]['debt'] = $total_amount;
                $i++;

                $total_debt += $total_amount;
            }

            $total_debt = sprintf('%0.2f', $total_debt);

            return view('front.account.sub_accounts', compact(
                'packages_price_for_last_month',
                'sub_accounts',
                'total_debt'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function pay_all_referral_debt()
    {
        try {
            if ($this->general_settings->referral_secret != 1) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            $my_balance = Auth::user()->balance();
            $balance = $my_balance;

            $date = Carbon::now();

            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 1) // to USD
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            if (count($rates) == 0) {
                return response(['case' => 'error', 'title' => 'Oops', 'content' => 'Rates not found!']);
            }

            $sub_accounts = User::where('parent_id', $this->userID)
                ->where('cargo_debt', 0)
                ->where('common_debt', 0)
                ->select('id')
                ->get();

            $total_paid = 0;

            foreach ($sub_accounts as $account) {
                $client_id = $account->id;

                $packages = Item::leftJoin('package as p', 'item.package_id', '=', 'p.id')
                    ->whereNull('p.issued_to_courier_date')
                    ->whereNull('p.deleted_by')
                    ->whereNull('p.delivered_by')
                    ->where('p.client_id', $client_id)
                    ->where('p.paid_status', 0)
                    ->where('p.total_charge_value', '>', 0)
                    ->select('p.id', 'p.total_charge_value as amount', 'p.paid', 'p.currency_id as amount_currency', 'p.courier_order_id')
                    ->get();

                foreach ($packages as $package) {
                    $package_id = $package->id;
                    $currency_id = $package->amount_currency;

                    $rate_to_usd = $this->calculate_exchange_rate($rates, $currency_id, 1);

                    $amount = $package->amount;
                    $paid = $package->paid;

                    $debt = $amount - $paid;
                    $debt_usd = $debt * $rate_to_usd;

                    $debt_usd = sprintf('%0.2f', $debt_usd);

                    if ($debt_usd > $balance) {
                        return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('static.referral_pay_all_debt_message')]);
                    }

                    Package::where('id', $package_id)
                        ->update([
                            'paid' => $amount,
                            'paid_status' => 1,
                            'payment_type_id' => 1 // online
                        ]);

                    PaymentLog::create([
                        'payment' => $debt_usd,
                        'currency_id' => 1, // usd
                        'client_id' => $client_id,
                        'package_id' => $package_id,
                        'type' => 3, // balance
                        'created_by' => $this->userID
                    ]);

                    $total_paid += $debt_usd;

                    $balance = $balance - $debt_usd;

                    // courier order control
                    if ($package->courier_order_id != null) {
                        $courier_order_id = $package->courier_order_id;

                        $courier_order = CourierOrders::where('id', $courier_order_id)
                            ->select('delivery_amount', 'total_amount')
                            ->first();

                        if ($courier_order) {
                            $old_delivery_amount = $courier_order->delivery_amount;
                            $old_total_amount = $courier_order->total_amount;

                            $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                            $pay_azn = $debt * $rate_to_azn;
                            $pay_azn = sprintf('%0.2f', $pay_azn);

                            $new_delivery_amount = $old_delivery_amount - $pay_azn;
                            if ($new_delivery_amount < 0) {
                                $new_delivery_amount = 0;
                            }

                            $new_total_amount = $old_total_amount - $pay_azn;
                            if ($new_total_amount < 0) {
                                $new_total_amount = 0;
                            }

                            $courier_order_update_arr = array();
                            $courier_order_update_arr['delivery_amount'] = $new_delivery_amount;
                            $courier_order_update_arr['total_amount'] = $new_total_amount;

                            if ($new_delivery_amount == 0) {
                                $courier_order_update_arr['delivery_payment_type_id'] = 1; // online
                            }

                            CourierOrders::where('id', $courier_order_id)->update($courier_order_update_arr);
                        }
                    }
                }

                $balance = sprintf('%0.2f', $balance);
                if ($balance < 0) {
                    $balance = 0;
                }

                User::where('id', $this->userID)->update(['balance' => $balance]);

                $rate_usd_to_azn = $this->calculate_exchange_rate($rates, 1, 3);
                $total_paid_azn = $total_paid * $rate_usd_to_azn;
                $total_paid_azn = sprintf('%0.2f', $total_paid_azn);

                $payment_code = Str::random(20);
                BalanceLog::create([
                    'payment_code' => $payment_code,
                    'amount' => $total_paid,
                    'amount_azn' => $total_paid_azn,
                    'client_id' => $this->userID,
                    'status' => 'out',
                    'type' => 'balance',
                    'created_by' => $this->userID
                ]);
            }

            return response(['case' => 'success', 'title' => __('static.success'), 'content' => __('static.success')]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => __('static.error'), 'content' => __('static.error_text')]);
        }
    }

    

    public function login_referal_account(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referal_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Referal tapılmadı.']);
        }
        try {
            if ($this->general_settings->referral_secret != 1) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            $referal_id = $request->referal_id;

            if (User::where(['id' => $referal_id, 'parent_id' => $this->userID, 'role_id' => 2])->count() == 0) {
                return response(['case' => 'error', 'title' => 'Oops!', 'content' => 'Referal hesab düzgün deyil!']);
            }

            if (Auth::loginUsingId($referal_id)) {
                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Giriş edilir...', 'redirect_url' => route("get_account")]);
            } else {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Giriş edilərkən xəta baş verdi!']);
            }
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function add_referal_balance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referal_id' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'amount' => ['required'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Referal tapılmadı.']);
        }
        try {
            if ($this->general_settings->referral_secret != 1) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            $amount = sprintf('%0.2f', $request->amount);
            $referal_id = $request->referal_id;
            $type = $request->type; // 1 - from my balance, 2 - from cart

            if ($type == 1) {
                //from my balance
                $response = $this->add_referal_balance_from_my_balance($referal_id, $amount);
                $payment_type = 'from_balance';
            } else {
                //from cart
                $return_type = 2;
                $ip_address = $request->ip();
                //$response = $this->pay_to_millikart($amount, $referal_id, $return_type, $ip_address);
                $response = $this->pay_to_pashaBank($amount, $referal_id, $return_type, $ip_address);
                $payment_type = 'from_cart';
            }

            return response(['case' => $response[0], 'title' => $response[1], 'content' => $response[2], 'payment_type' => $payment_type]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    private function add_referal_balance_from_my_balance($referal_id, $amount)
    {
        try {
            $my_balance = Auth::user()->balance();

            if ($my_balance < $amount) {
                return ['warning', 'Oops!', 'Bu əməliyyat üçün yeterli balansınız yoxdur.'];
            }

            $user = User::where(['id' => $referal_id, 'parent_id' => $this->userID])->select('balance')->first();

            if (!$user) {
                return ['warning', 'Oops!', 'Referal düzgün deyil!'];
            }

            $referal_old_balance = $user->balance;
            $referal_new_balance = $referal_old_balance + $amount;
            $my_new_balance = $my_balance - $amount;

            User::where('id', $referal_id)->update(['balance' => $referal_new_balance]);
            User::where('id', $this->userID)->update(['balance' => $my_new_balance]);

            return ['success', 'Uğurlu!', 'Balans uğurla artırıldı.'];
        } catch (\Exception $exception) {
            return ['error', 'Error!', 'Something went wrong!'];
        }
    }

    public function get_packages_by_sub_accounts(Request $request)
    {
        try {
            $countries = Country::whereNotIn('id', [1, 4, 10, 13])->select('id', 'name_' . App::getLocale(), 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();

            $packages_price_for_last_month = $this->packages_price_for_last_month();

            $sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();

            //counts for status
            $counts = array();
            $counts['not_declared'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->whereNotNull('item.invoice_doc')
                ->where('package.is_warehouse', 0)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
        //            $counts['incorrect_invoice'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
        //                ->whereIn('package.client_id', $sub_accounts)
        //                ->whereNotNull('item.invoice_doc')
        //                ->where('item.invoice_confirmed', 0)
        //                ->whereNull('package.deleted_by')
        //                ->count();
            $counts['is_warehouse'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->where('package.is_warehouse', 1)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
            $counts['sent'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->where('package.is_warehouse', 2)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
            $counts['in_office'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->where('package.is_warehouse', 3)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->count();
            $counts['delivered'] = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->whereNotNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->count();

            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->whereIn('package.client_id', $sub_accounts)
                ->whereNull('package.deleted_by');

            $search = array();
            $country = $request->input("country");
            $status = $request->input("status");
            $search['country'] = $country;

            if (isset($country) && !empty($country)) {
                // search by country
                //$query->leftJoin('locations', 'package.departure_id', '=', 'locations.id');
                $query->where('package.country_id', $country);
            }

            if (isset($status) && !empty($status)) {
                // search by status
                switch ($status) {
        //                    case 1:
        //                        {
        //                            // declared (beyan olunanlar)
        //                            $query->whereNotNull('item.invoice_doc');
        //                            $query->where('package.is_warehouse', 0);
        //                            $query->whereNull('package.delivered_by');
        //                        }
        //                        break;
        //                    case 2: {
        //                        // incorrect_invoice (səhv invoys)
        //                        $query->whereNotNull('item.invoice_doc');
        //                        $query->where('item.invoice_confirmed', 0);
        //                    }
        //                        break;
                    case 3:
                        {
                            // is_warehouse (xarici anbardadir)
                            $query->where('package.is_warehouse', 1);
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 4:
                        {
                            // sent (gonderilib)
                            $query->where('package.is_warehouse', 2); // flight closed
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 5:
                        {
                            // in_office (baki ofisindedir)
                            $query->where('package.is_warehouse', 3);
                            $query->whereNull('package.delivered_by');
                        }
                        break;
                    case 6:
                        {
                            // delivered (catdirilib)
                            $query->whereNotNull('package.delivered_by');
                        }
                        break;
                    default:
                    {
                        //default - in baku
                        $query->where('package.is_warehouse', 3);
                        $query->whereNull('package.delivered_by');
                        //$query->whereNull('package.delivered_by');
                        $status = 5;
                    }
                }
            } else {
                //default - in baku
                $query->where('package.is_warehouse', 3);
                $query->whereNull('package.delivered_by');
                //$query->whereNull('package.delivered_by');
                $status = 5;
            }

            $search['status'] = $status;

            $packages = $query
                ->select(
                    'package.id',
                    'package.internal_id',
                    'item.invoice_doc',
                    'item.invoice_confirmed',
                    'item.price',
                    'item.invoice_status as invoice_status',
                    'cur.name as currency',
                    'package.number as track',
                    'seller.title as seller',
                    'package.volume_weight',
                    'package.gross_weight',
                    'package.chargeable_weight',
                    'package.unit',
                    'package.total_charge_value as amount',
                    'package.amount_usd',
                    'package.paid_status',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    's.status_' . App::getLocale() . ' as status',
                    's.color as status_color',
                    'flight.name as flight',
                    'client.id as suite',
                    'client.name as client_name',
                    'client.surname as client_surname',
                    'package.issued_to_courier_date' // has courier (null -> false, not null -> true)
                )
                ->orderBy('package.id', 'desc')
                ->limit(30)
                ->get();

            $date = Carbon::today();
            $has_rate = true;
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 1) // to USD
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();
            if (!$rates) {
                // rate note found
                $has_rate = false;
            }

            foreach ($packages as $package) {
                $currency_id = $package->currency_id;
                if ($currency_id == 1) { // USD
                    $package->amount_usd = $package->amount;
                    continue;
                }
                $rate_to_usd = 0;
                if ($has_rate) {
                    $rate_to_usd = $this->calculate_exchange_rate($rates, $currency_id, 1);
                }
                $package->paid = $package->paid * $rate_to_usd;
                $package->amount_usd = $package->amount * $rate_to_usd;

                if ($package->issued_to_courier_date == null) {
                    $package->has_courier = 0;
                } else {
                    $package->has_courier = 1;
                }
            }

            return view('front.account.orders_by_sub_accounts', compact(
                'countries',
                'packages_price_for_last_month',
                'packages',
                'search',
                'counts'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function delete_package_by_sub_accounts($package_id)
    {
        try {
            if (!is_numeric($package_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            $sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();

            if (Package::where(['id' => $package_id])->whereIn('client_id', $sub_accounts)->whereNull('internal_id')->count() > 0) {
                Package::where(['id' => $package_id])
                    ->update([
                        'deleted_by' => $this->userID,
                        'deleted_at' => Carbon::now()
                    ]);

                Item::where('package_id', $package_id)
                    ->update([
                        'deleted_by' => $this->userID,
                        'deleted_at' => Carbon::now()
                    ]);
            } else {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'id' => $package_id]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_package_update_by_sub_accounts($package_id)
    {
        try {
            $sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();

            $package = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->where(['package.id' => $package_id])
                ->whereIn('package.client_id', $sub_accounts)
        //                ->whereNull('package.internal_id')
                ->whereRaw('(package.internal_id is null or item.invoice_doc is null or item.invoice_confirmed <> 1)')
                ->whereNull('package.deleted_by')
                ->select(
                    'package.id',
                    'package.internal_id',
                    'item.currency_id',
                    'package.number as track',
                    'package.seller_id',
                    'package.other_seller',
                    'item.category_id',
                    'item.title',
                    //'item.quantity',
                    'item.price',
                    'item.invoice_doc',
                    'package.remark',
                    'package.last_status_id'
                )
                ->first();

            if ($package) {
                $sellers = Seller::orderBy('title')->select('id', 'title')->get();
                $categories = Category::orderBy('name_' . App::getLocale())->select('id', 'name_' . App::getLocale())->get();
                $currencies = Currency::orderBy('name')->select('id', 'name')->get();

                //$countries = Country::where('id', '<>', 1)->select('id', 'name', 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();

                $packages_price_for_last_month = $this->packages_price_for_last_month();

                return view('front.account.update_order_by_sub_accounts', compact(
                    'package',
                    'sellers',
                    'categories',
                    'currencies',
                    'packages_price_for_last_month'
                ));
            } else {
                return redirect()->route("get_orders");
            }
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function post_package_update_by_sub_accounts(Request $request, $package_id)
    {
        $validator = Validator::make($request->all(), [
            'currency_id' => ['required', 'integer'],
            'seller_id' => ['nullable', 'integer'],
            'other_seller' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:500'],
            //'quantity' => ['nullable', 'integer'],
            'price' => ['required'],
            'invoice' => ['nullable', 'mimes:pdf,docx,doc,png,jpg,jpeg'],
            'remark' => ['nullable', 'string', 'max:5000'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            if (empty($request->seller_id) && empty($request->other_seller)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Seller cannot be empty!']);
            }

            $package_arr = array();
            $package_arr['seller_id'] = $request->seller_id;
            $package_arr['remark'] = $request->remark;
            if ($request->seller_id == 0) {
                $other_seller = $request->other_seller;
                $package_arr['other_seller'] = $other_seller;
            }

            $package_exist = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->where(['package.id' => $package_id])
                ->whereRaw('(package.internal_id is null or item.invoice_doc is null or item.invoice_confirmed <> 1)')
                ->select('package.client_id', 'package.country_id', 'package.internal_id', 'package.last_status_id')->first();
            if (!$package_exist) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
            }

            $sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();
            $sub_accounts_arr = array();
            foreach ($sub_accounts as $sub_account) {
                array_push($sub_accounts_arr, $sub_account->id);
            }
            $client_id = $package_exist->client_id;
            if ($client_id != null && !in_array($client_id, $sub_accounts_arr)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!']);
            }

            $currency_id = $request->currency_id;
            if ($package_exist->internal_id == null || $package_exist->last_status_id == 6 || $package_exist->last_status_id == 9) {
                Package::where('id', $package_id)->update($package_arr);

                if ($package_exist->last_status_id != 11) {
                    PackageStatus::create([
                        'package_id' => $package_id,
                        'status_id' => 11, //declared
                        'created_by' => $this->userID
                    ]);
                }
            }

            $date = Carbon::today();
            $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where(['from_currency_id' => 1, 'to_currency_id' => $currency_id]) //to USD
                ->select('rate')
                ->orderBy('id', 'desc')
                ->first();

            $price_usd = 0;
            if ($rate) {
                $price_usd = $request->price / $rate->rate;
                $price_usd = sprintf('%0.2f', $price_usd);
            }

            $item_arr = array();
            $item_arr['package_id'] = $package_id;
            $item_arr['price'] = $request->price;
            $item_arr['currency_id'] = $currency_id;
            $item_arr['price_usd'] = $price_usd;
            if (isset($request->invoice)) {
                $file = $request->file('invoice');
                $file_name = $request->track . '_invoice_' . Str::random(4) . '_' . time();
                Storage::disk('uploads')->makeDirectory('files/packages/invoices');
                $cover = $file;
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('uploads')->put('files/packages/invoices/' . $file_name . '.' . $extension, File::get($cover));
                $url = '/uploads/files/packages/invoices/' . $file_name . '.' . $extension;
                $item_arr['invoice_doc'] = $url;
                $item_arr['invoice_confirmed'] = 2;
            } else {
                $url = null;
            }

            if ($package_exist->internal_id == null || $package_exist->last_status_id == 6 || $package_exist->last_status_id == 9) {
                $item_arr['category_id'] = $request->category_id;
                //$item_arr['quantity'] = $request->quantity;
                $item_arr['title'] = $request->title;
            }

            $item_exist = Item::where('package_id', $package_id)->select('id')->orderBy('id', 'desc')->first();
            if ($item_exist) {
                // update
                Item::where('id', $item_exist->id)->update($item_arr);
            } else {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Item not found!']);
                // insert
                //$item_arr['created_by'] = $request->created_by;
                //Item::create($item_arr);
            }

            InvoiceLog::create([
                'package_id' => $package_id,
                'client_id' => $this->userID,
                'invoice' => $request->price,
                'currency_id' => $currency_id,
                'invoice_doc' => $url,
                'created_by' => $this->userID
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Success!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    // balance
    public function get_balance_page(Request $request)
    {
        try {
            $logs = BalanceLog::where('client_id', $this->userID)
                ->select(
                    'id',
                    'amount',
                    'amount_azn',
                    'type',
                    'status',
                    'created_at'
                )
                ->orderBy('id', 'desc')
                ->take(100)
                ->get();
            
            $amount = 0;

            if ($request->amount){
                $amount = $request->amount;
            }

            return view('web.account.balance.index', compact(
                'amount',
                'logs'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function amount_send_to_millikart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required'],
        ]);
        if ($validator->fails()) {
            // amount is required
            Session::flash('message', "Məbləğ daxil edilməlidir!");
            Session::flash('class', "page-failed");
            Session::flash('description', "Yenidən cəhd edin!");
            Session::flash('display', 'block');
            if ($this->api) {
                return 'Məbləğ daxil edilməlidir!';
            }
            return redirect()->route("get_balance_page");
        }
        try {
            $return_type = 1;
            $ip_address = $request->ip();
            $response = $this->pay_to_pashaBank($request->amount, $this->userID, $return_type, $ip_address);
            //$response = $this->pay_to_millikart($request->amount, $this->userID, $return_type, $ip_address);

            if($this->api){
                return response([
                    'url' => $response
                ]);
            }

            return $response;
        } catch (\Exception $exception) {
            Session::flash('message', "Səhv baş verdi!");
            Session::flash('class', "page-failed");
            Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
            Session::flash('display', 'block');
            return redirect()->route("get_balance_page");
        }
    }

    private function pay_to_millikart($input_amount, $user_id, $return_type, $ip_address, $payment_type = 'balance', $order_id = 0, $packages_str = null)
    {
        try {
            $payment_task = $this->generate_payment_task("millikart", $ip_address, $payment_type, $order_id, $packages_str);

            if (!$payment_task) {
                // error when create payment task
                if ($return_type == 1) {
                    Session::flash('message', "Ödənişə hazırlanarkən səhv baş verdi!");
                    Session::flash('class', "page-failed");
                    Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                    Session::flash('display', 'block');
                    return redirect()->route("get_balance_page");
                } else {
                    return ['error', 'Oops!', 'Ödənişə hazırlanarkən səhv baş verdi!'];
                }
            }

            if ($payment_type == 'balance') {
                // usd
                $date = Carbon::today();
                $rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
                ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                    ->select('rate')
                    ->first();

                if (!$rate) {
                    // rate note found
                    if ($return_type == 1) {
                        Session::flash('message', "Məbləğ hesablanarkən səhv baş verdi!");
                        Session::flash('class', "page-failed");
                        Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                        Session::flash('display', 'block');
                        return redirect()->route("get_balance_page");
                    } else {
                        return ['error', 'Oops!', 'Məbləğ hesablanarkən səhv baş verdi!'];
                    }
                }
                $amount = sprintf('%0.2f', ($input_amount * $rate->rate)) * 100;
            } 
            else if ($payment_type == 'payment') {
                // usd
                $date = Carbon::today();
                $rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
                ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                    ->select('rate')
                    ->first();

                if (!$rate) {
                    // rate note found
                    if ($return_type == 4) {
                        Session::flash('message', "Məbləğ hesablanarkən səhv baş verdi!");
                        Session::flash('class', "page-failed");
                        Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                        Session::flash('display', 'block');
                        return redirect()->route("get_balance_page");
                    } else {
                        return ['error', 'Oops!', 'Məbləğ hesablanarkən səhv baş verdi!'];
                    }
                }
                $amount = sprintf('%0.2f', ($input_amount * $rate->rate)) * 100;
            }            
            else {
                // courier
                // azn
                $amount = $input_amount * 100;
            }
            $mid = "aser";
            $key = "SGSO588VGIN9WBDE6BHOAN5BICW8E5RX";
            $currency = 944;
            $description = "c_" . $user_id;
            $reference = $payment_task;
            $language = "az";

            $signature = strtoupper(md5(strlen($mid) . $mid . strlen($amount) . $amount . strlen($currency) . $currency . (!empty($description) ? strlen($description) . $description : "0") . strlen($reference) . $reference . strlen($language) . $language . $key));

            $url = "https://pay.millikart.az/gateway/payment/register?";
            $url .= "mid=" . $mid . "&amount=" . $amount . "&currency=" . $currency . "&description=" . $description . "&reference=" . $reference . "&language=" . $language . "&signature=" . $signature . "&redirect=1";
            // dd($return_type);
            if ($return_type == 1) {
                if ($this->api) {
                    return $url;
                }
                return redirect($url);
            }else if($return_type == 4){
                if($this->api){
                    return $url;
                }
                return redirect($url);
            }
            else {
                return ['success', 'Uğurlu', $url];
            }
        } catch (\Exception $exception) {
            if ($return_type == 1) {
                Session::flash('message', "Səhv baş verdi!");
                Session::flash('class', "page-failed");
                Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                Session::flash('display', 'block');
                if ($this->api) {
                    return 'Səhv baş verdi!';
                }
                return redirect()->route("get_balance_page");
            } else {
                return ['error', 'Oops!', 'Something went wrong!'];
            }
        }
    }

    private function generate_payment_task($type, $ip_address, $payment_type, $order_id = 0, $packages_str = null, $trans_ref = null)
    {
        try {
            $key = $trans_ref ?? Str::random(10) . $this->userID . Str::random(4); // unique

            PaymentTask::create([
                'payment_key' => $key,
                'status' => 0,
                'type' => $type,
                'payment_type' => $payment_type,
                'order_id' => $order_id, // for courier
                'packages' => $packages_str, // for courier
                'ip_address' => $ip_address,
                'created_by' => $this->userID
            ]);

            return $key;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function get_balance_logs()
    {
        try {
            $packages_price_for_last_month = $this->packages_price_for_last_month();
            $logs = BalanceLog::where('client_id', $this->userID)
                ->select(
                    'id',
                    'amount',
                    'amount_azn',
                    'type',
                    'status',
                    'created_at'
                )
                ->orderBy('id', 'desc')
                ->take(100)
                ->get();

            if($this->api){
                return response([
                    'logs' => $logs
                ]);
            }

            return view('front.account.balance_logs', compact(
                'packages_price_for_last_month',
                'logs'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    // courier
    public function get_courier_page(Request $request)
    {
        try {
            $courier_settings = CourierSettings::first();

            if (!$courier_settings) {
                return redirect()->route("get_account");
            }

            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());

            $diff_time = $now->diffInSeconds($closing_time, false);

            if ($diff_time < 0) {
                // not today
                $min_date = date("Y-m-d", strtotime(date("Y-m-d") . "+1 day"));
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+3 day"));
            } else {
                $min_date = date('Y-m-d');
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+2 day"));
            }
            
            $query = CourierOrders::leftJoin('courier_areas', 'courier_orders.area_id', '=', 'courier_areas.id')
                ->leftJoin('courier_metro_stations', 'courier_orders.metro_station_id', '=', 'courier_metro_stations.id')
                ->leftJoin('courier_payment_types', 'courier_orders.courier_payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('lb_status as status', 'courier_orders.last_status_id', '=', 'status.id')
                ->where(['courier_orders.client_id' => $this->userID])
                ->where('order_type', 1)
                ->whereRaw('(
                (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
                )');
            //->whereRaw('(((courier_orders.courier_payment_type_id = 1 or courier_orders.delivery_payment_type_id = 1) and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 0))');
            
            $where_archive_status = $request->input("archive");
            if (!isset($where_archive_status) || $where_archive_status != 'yes') {
                $query->whereNull('courier_orders.delivered_at');
                $query->whereNull('courier_orders.canceled_at');
            } else {
                $query->whereRaw('(courier_orders.delivered_at is not null or courier_orders.canceled_at is not null)');
            }

            $orders = $query->select(
                'courier_orders.id',
                'courier_areas.name_' . App::getLocale() . ' as area',
                'courier_metro_stations.name_' . App::getLocale() . ' as metro_station',
                'courier_orders.address',
                'courier_orders.date',
                'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                'courier_orders.amount',
                'courier_orders.delivery_amount',
                'courier_orders.total_amount',
                'courier_orders.amount',
                'status.status_' . App::getLocale() . ' as status',
                'courier_orders.last_status_id',
                'courier_orders.last_status_date',
                'courier_orders.azerpost_track',
                'courier_orders.is_send_azerpost'
            )
                ->orderBy('id', 'desc')
                ->paginate(15);

            if($this->api){
                return response([
                    'orders' => $orders
                ]);
            }

            return view("web.account.courier.index", compact(
                //'areas',
                //'regions',
                //'metro_stations',
                'orders',
                'min_date',
                'max_date'
                //'amount_for_urgent',
                //'packages',
                //'has_sub_accounts'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function get_create_courier_page(Request $request)
    {
        try {
            $courier_settings = CourierSettings::first();

            if (!$courier_settings) {
                return redirect()->route("get_account");
            }

            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());

            $diff_time = $now->diffInSeconds($closing_time, false);

            if ($diff_time < 0) {
                // not today
                $min_date = date("Y-m-d", strtotime(date("Y-m-d") . "+1 day"));
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+3 day"));
            } else {
                $min_date = date('Y-m-d');
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+2 day"));
            }

            $amount_for_urgent = $courier_settings->amount_for_urgent;

            //$packages_price_for_last_month = $this->packages_price_for_last_month();

            $areas = CourierAreas::where('active', 1)->select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();
            $metro_stations = CourierMetroStations::select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();

            $regions = CourierRegion::whereNull('deleted_at')->select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();

            //$azerpost_index = DB::table('azerpost_index')->get();
            // show packages
            $users = array();
            array_push($users, $this->userID);

            $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
                ->select('id')->get();

            $has_sub_accounts = 'yes';

            if (count($sub_accounts) == 0) {
                $has_sub_accounts = 'no';
            }

            foreach ($sub_accounts as $sub_account) {
                array_push($users, $sub_account->id);
            }

            $packages = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->whereIn('package.client_id', $users)
                ->where([
                    'package.in_baku' => 1,
                    'package.is_warehouse' => 3,
                    'has_courier' => 0
                ])
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->orderBy('package.client_id')
                ->orderBy('package.id')
                ->select(
                    'package.id',
                    'package.payment_type_id',
                    'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                    'package.number as track',
                    'package.gross_weight',
                    'package.total_charge_value as amount',
                    'package.amount_usd',
                    'package.amount_azn',
                    'package.paid',
                    'package.paid_sum',
                    'package.paid_azn',
                    'package.currency_id',
                    'package.paid_status',
                    'package.client_id',
                    'client.name as client_name',
                    'client.surname as client_surname',
                    'package.external_w_debt',
                    'package.external_w_debt_azn',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd'
                )
                ->get();

                //if (count($packages) == 0) {
                //    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.no_referral_packages')]);
                //}

            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            foreach ($packages as $package) {
                $currency_id = $package->currency_id;

                if ($has_rate) {
                    $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                } else {
                    $rate_to_azn = 1;
                }

                $amount = $package->amount_azn;
                $external_debt = $package->external_w_debt_azn;
                $internal_debt = $package->internal_w_debt;
                $paid_azn = $package->paid_azn;
    
                if($paid_azn > 0){
                    $amount = $paid_azn - $amount;
    
                    if ($amount > 0) {
                        $external_debt -= $amount;
                    }
    
                    if ($amount != 0 && $external_debt != 0) {
                        $internal_debt_collect = $external_debt + $internal_debt;
                        $external_debt = $external_debt > 0 ? $external_debt : 0;
                        $internal_debt = $external_debt > 0 ? $internal_debt : $internal_debt_collect;
                        $amount = 0;
                    } else {
                        $internal_debt = $internal_debt;
                        $amount = 0;
                    }
    
                    
                }
                
                
                //$amount_azn = ($package->amount - $package->paid) * $rate_to_azn;
                $amount_azn = sprintf('%0.2f', $amount);
                $external_amount_azn = sprintf('%0.2f', $external_debt);
                $internal_amount_azn = sprintf('%0.2f', $internal_debt);

                $package->amount = $amount_azn;
                $package->external_w_debt = $external_amount_azn;
                $package->internal_w_debt = $internal_amount_azn;
               
                if (strlen($package->track) > 7) {
                    $package->track = substr($package->track, strlen($package->track) - 7);
                }

                if ($package->paid_status == 0) {
                    $package->payment_type = 'Not paid';
                }
            }

            //dd($packages);
            // show orders
            $query = CourierOrders::leftJoin('courier_areas', 'courier_orders.area_id', '=', 'courier_areas.id')
                ->leftJoin('courier_metro_stations', 'courier_orders.metro_station_id', '=', 'courier_metro_stations.id')
                ->leftJoin('courier_payment_types', 'courier_orders.courier_payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('lb_status as status', 'courier_orders.last_status_id', '=', 'status.id')
                ->where(['courier_orders.client_id' => $this->userID])
                ->whereRaw('(
                (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
                )');
            //->whereRaw('(((courier_orders.courier_payment_type_id = 1 or courier_orders.delivery_payment_type_id = 1) and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 0))');
            
            $where_archive_status = $request->input("archive");
            if (!isset($where_archive_status) || $where_archive_status != 'yes') {
                $query->whereNull('courier_orders.delivered_at');
                $query->whereNull('courier_orders.canceled_at');
            } else {
                $query->whereRaw('(courier_orders.delivered_at is not null or courier_orders.canceled_at is not null)');
            }

            $orders = $query->select(
                'courier_orders.id',
                'courier_areas.name_' . App::getLocale() . ' as area',
                'courier_metro_stations.name_' . App::getLocale() . ' as metro_station',
                'courier_orders.address',
                'courier_orders.date',
                'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                'courier_orders.amount',
                'courier_orders.delivery_amount',
                'courier_orders.total_amount',
                'courier_orders.amount',
                'status.status_' . App::getLocale() . ' as status',
                'courier_orders.last_status_id',
                'courier_orders.last_status_date',
                'courier_orders.azerpost_track',
                'courier_orders.is_send_azerpost'
            )
                ->orderBy('id', 'desc')
                ->paginate(15);

            if($this->api){
                return response([
                    'packages' => $packages,
                    'orders' => $orders
                ]);
            }

            return view("web.account.courier.create", compact(
                'areas',
                'regions',
                'metro_stations',
                'orders',
                'min_date',
                'max_date',
                'amount_for_urgent',
                'packages',
                'has_sub_accounts'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function show_packages_of_referrals()
    {
        try {
            $user_id = $this->userID;

            $users = array();

            $sub_accounts = User::where('parent_id', $user_id)->whereNull('deleted_by')
                ->select('id')->get();

            if (count($sub_accounts) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.no_referrals')]);
            }

            foreach ($sub_accounts as $sub_account) {
                array_push($users, $sub_account->id);
            }

            $packages = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->whereIn('package.client_id', $users)
                ->where([
                    'package.in_baku' => 1,
                    'package.is_warehouse' => 3,
                    'has_courier' => 0
                ])
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->select(
                    'package.id',
                    'package.payment_type_id',
                    'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                    'package.number as track',
                    'package.gross_weight',
                    'package.total_charge_value as amount',
                    'package.paid',
                    'package.currency_id',
                    'package.paid_status',
                    'client.name as client_name',
                    'client.surname as client_surname'
                )
                ->get();

            if (count($packages) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.no_referral_packages')]);
            }

            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            foreach ($packages as $package) {
                $currency_id = $package->currency_id;

                if ($has_rate) {
                    $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                } else {
                    $rate_to_azn = 1;
                }
                $amount_azn = ($package->amount - $package->paid) * $rate_to_azn;
                $amount_azn = sprintf('%0.2f', $amount_azn);

                $package->amount = $amount_azn;

                if (strlen($package->track) > 7) {
                    $package->track = substr($package->track, strlen($package->track) - 7);
                }

                if ($package->paid_status == 0) {
                    $package->payment_type = 'Not paid';
                }
            }

            return response(['case' => 'success', 'packages' => $packages]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function courier_show_packages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.order_not_selected')]);
        }
        try {
            $order_id = $request->order_id;

            $courier_order = CourierOrders::where('id', $order_id)
                ->select('packages')
                ->first();

            if (!$courier_order) {
                $packages = array();
            } else {
                $packages_str = $courier_order->packages;
                $packages_arr = explode(',', $packages_str);

                $users = array();
                array_push($users, $this->userID);

                $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
                    ->select('id')->get();

                foreach ($sub_accounts as $sub_account) {
                    array_push($users, $sub_account->id);
                }

                $packages = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
                    ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                    ->leftJoin('lb_status as status', 'package.last_status_id', '=', 'status.id')
                    ->whereIn('package.id', $packages_arr)
                    ->whereIn('package.client_id', $users)
                    ->whereNull('package.deleted_by')
                    ->select(
                        'package.id',
                        'package.payment_type_id',
                        'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                        'status.status_' . App::getLocale() . ' as status',
                        'package.number',
                        'package.gross_weight',
                        'package.total_charge_value as amount',
                        'package.currency_id',
                        'package.paid_status',
                        'client.name as client_name',
                        'client.surname as client_surname'
                    )
                    ->get();
            }

            if (count($packages) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.package_not_found')]);
            }

            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            foreach ($packages as $package) {
                $currency_id = $package->currency_id;

                if ($has_rate) {
                    $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                } else {
                    $rate_to_azn = 1;
                }
                $amount_azn = $package->amount * $rate_to_azn;
                $amount_azn = sprintf('%0.2f', $amount_azn);

                $package->amount = $amount_azn;

                if ($package->paid_status == 0) {
                    $package->payment_type = 'Not paid';
                }
            }

            return response(['case' => 'success', 'packages' => $packages]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function courier_get_courier_payment_types(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_selected')]);
        }
        try {
            $area_id = $request->area_id;
            $area = CourierAreas::where('id', $area_id)->select('zone_id', 'tariff')->first();

            if (!$area) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_correct')]);
            }

            $zone_id = $area->zone_id;

            $payment_types = CourierZonePaymentTypes::where('courier_zone_payment_type.zone_id', $zone_id)
                ->select('courier_zone_payment_type.courier_payment_type_id as id')
                ->distinct()
                ->get();

            if($this->api){
                return response([
                    'case' => 'success', 
                    'payment_types' => $payment_types, 
                    'tariff' => $area->tariff
                ]);
            }

            return response(['case' => 'success', 'payment_types' => $payment_types, 'tariff' => $area->tariff]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function courier_get_delivery_payment_types(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_id' => ['required', 'integer'],
            'courier_payment_type' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_selected')]);
        }
        try {
            $area_id = $request->area_id;
            $courier_payment_type = $request->courier_payment_type;

            $area = CourierAreas::where('id', $area_id)->select('zone_id')->first();

            if (!$area) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_correct')]);
            }

            $zone_id = $area->zone_id;

            $payment_types = CourierZonePaymentTypes::where('courier_zone_payment_type.zone_id', $zone_id)
                ->where('courier_zone_payment_type.courier_payment_type_id', $courier_payment_type)
                ->select('courier_zone_payment_type.delivery_payment_type_id as id')
                ->distinct()
                ->get();
                
            if($this->api){
                return response([
                    'case' => 'success', 
                    'payment_types' => $payment_types]);
            }

            return response(['case' => 'success', 'payment_types' => $payment_types]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function courier_show_statuses_history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.order_not_selected')]);
        }
        try {
            $order_id = $request->order_id;

            $statuses = CourierOrderStatus::leftJoin('lb_status as status', 'courier_order_status.status_id', '=', 'status.id')
                ->where('courier_order_status.order_id', $order_id)
                ->select(
                    'status.status_' . App::getLocale() . ' as status',
                    'courier_order_status.created_at as date'
                )
                ->get();

            foreach ($statuses as $status) {
                $date = date('d.m.Y', strtotime($status->date));
                $status->date = $date;
            }

            return response(['case' => 'success', 'statuses' => $statuses]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function courier_create_order(Request $request)
    {

//        $lastChar = substr($request->courier_payment_type_id, -1);
//        return $lastChar;  // '2'
//
//        return $request;
        $validator = Validator::make($request->all(), [
            'packages_list' => ['required', 'string', 'max:1000'],
            'area_id' => ['required', 'integer'],
            'metro_station_id' => ['nullable', 'integer'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:30'],
            'date' => ['required', 'date'],
            'courier_payment_type_id' => ['required', 'string'],
            'delivery_payment_type_id' => ['required', 'string'],
            'urgent_order' => ['required', 'integer'],
        ], [
            // Özel hata mesajlarını buraya ekleyebilirsiniz
            'packages_list.required' => 'Bağlama seçmek mütləqdir.',

            'area_id.required' => 'Metro stansiya seçmək mütləqdir.',

            'address.required' => 'Adres mütləq olmalıdır',

            'phone.required' => 'Telefon mütləqdir.',
            'courier_payment_type_id.required' => 'Kuryer çatdırılma növü mütləq seçilməlidir .',
            'delivery_payment_type_id.required' => 'Xaricdən çatdırılma növü mütləq seçilməlidir .',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.incomplete_information')]);

        }

        try {
            DB::beginTransaction();
            
            $courier_settings = CourierSettings::first();

            if (!$courier_settings) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
            }

            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());

            $diff_time = $now->diffInSeconds($closing_time, false);

            if ($diff_time < 0) {
                // not today
                $min_date = 1;
                $max_date = 3;
            } else {
                $min_date = 0;
                $max_date = 2;
            }

            $today = Carbon::parse(Carbon::today()->toDateString());
            $selected_date = Carbon::parse($request->date);
            $diff_date = $today->diffInDays($selected_date, false);

            if ($diff_date < $min_date || $diff_date > $max_date) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.date_message')]);
            }

            $courier_daily_limits = CourierDailyLimits::whereDate('date', $selected_date)->orderBy('id', 'desc')->select('id', 'count', 'used')->first();
            if (!$courier_daily_limits) {
                $limit_residue = 1;
                $limit_id = 0;
                $limit_used = 0;
                $has_limit = false;
            } else {
                $limit_id = $courier_daily_limits->id;
                $limit_count = $courier_daily_limits->count;
                $limit_used = $courier_daily_limits->used;
                $limit_residue = $limit_count - $limit_used;
                $has_limit = true;
            }

            if ($limit_residue <= 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Seçdiyiniz gün üçün kuryer sifarişi bitmişdir. Zəhmət olmasa başqa tarix seçin.']);
            }

            $area_id = $request->area_id;
            $area = CourierAreas::where('id', $area_id)->select('zone_id', 'tariff')->first();
            if (!$area) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_correct')]);
            }
            $zone_id = $area->zone_id;
            $courier_payment_type_id = substr($request->courier_payment_type_id, -1);
            $delivery_payment_type_id = substr($request->delivery_payment_type_id, -1);
            $old_packages_str = $request->packages_list;
            $old_packages_arr = explode(',', $old_packages_str);
            unset($request['packages_list']);

            $tariff = $area->tariff;
            $amount = $tariff;

            if ($request->urgent_order == 1) {
                $amount_for_urgent = $courier_settings->amount_for_urgent;
                $amount += $amount_for_urgent;
                $request->merge(['urgent' => 1]);
            }

            $type_control = CourierZonePaymentTypes::where([
                'zone_id' => $zone_id,
                'courier_payment_type_id' => $courier_payment_type_id,
                'delivery_payment_type_id' => $delivery_payment_type_id
            ])->select('id')->first();

            if (!$type_control) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Seçdiyiniz bölgədə seçdiyiniz ödəniş növləri üzrə çatdırılma yoxdur!']);
            }

            $users = array();
            array_push($users, $this->userID);

            $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
                ->select('id')->get();

            foreach ($sub_accounts as $sub_account) {
                array_push($users, $sub_account->id);
            }

            $packages = Package::whereNull('package.deleted_by')
                ->leftJoin('item', 'package.id', '=', 'item.package_id')
                ->whereIn('package.client_id', $users)
                ->where([
                    'package.in_baku' => 1,
                    'package.is_warehouse' => 3,
                    'has_courier' => 0
                ])
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->whereIn('package.id', $old_packages_arr)
                ->select(
                    'package.id',
                    'package.total_charge_value as amount',
                    'package.amount_usd',
                    'package.amount_azn',
                    'package.paid',
                    'package.paid_sum',
                    'package.paid_azn',
                    'package.currency_id',
                    'package.paid_status',
                    'package.internal_id',
                    'package.height',
                    'package.width',
                    'package.gross_weight',
                    'package.country_id',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'package.external_w_debt_azn',
                    'item.title'
                )
                ->get();

            if (count($packages) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.packages_not_conditions')]);
            }

            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            $new_packages_str = '';
            $delivery_amount = 0;
            $packages_arr_for_update = array();

            foreach ($packages as $package) {
    
                $result = $this->CourierCalculatePaid($package);
                $pay = $result['paid_azn'];
                
         
                $new_packages_str .= $package->id . ',';

                $currency_id = $package->currency_id;

           
                $delivery_amount += $pay;

                if (($delivery_payment_type_id != 1 || $package->paid_status == 1) && $courier_payment_type_id != 1) {
                    array_push($packages_arr_for_update, $package->id);
                }
            }
            //dd($delivery_amount);
            $summary_amount = 0;
            if ($courier_payment_type_id != 1) {
                // not online
                $summary_amount += $amount;
            }

            if ($delivery_payment_type_id != 1) {
                // not online
                $summary_amount += $delivery_amount;
            }

            $new_packages_str = substr($new_packages_str, 0, -1);
            //dd($courier_payment_type_id);
            $request->merge([
                'packages' => $new_packages_str,
                'created_by' => $this->userID,
                'client_id' => $this->userID,
                'amount' => $amount,
                'delivery_amount' => $delivery_amount,
                'total_amount' => $summary_amount,
                'order_type' => 1
            ]);
            

            //dd($request->all());
            $order = CourierOrders::create($request->all());
           
            Package::whereIn('id', $packages_arr_for_update)->update([
                'courier_order_id' => $order->id,
                'has_courier' => 1,
                'has_courier_by' => $this->userID,
                'has_courier_at' => Carbon::now(),
                'has_courier_type' => 'user_create_order_' . $order->id
            ]);

            CourierOrderStatus::create([
                'order_id' => $order->id,
                'status_id' => 13,
                'created_by' => $this->userID
            ]);

            if ($has_limit) {
                $new_used = $limit_used + 1;
                CourierDailyLimits::where('id', $limit_id)->update(['used' => $new_used]);
            }
            // dd($new_packages_str);
            $online_pay_amount = 0;
           
            if ($courier_payment_type_id == 1) {
                // online
                $online_pay_amount += $amount;
            }

            if ($delivery_payment_type_id == 1) {
                // online
                $online_pay_amount += $delivery_amount;
            }

            if ($online_pay_amount > 0) {
                // online
                $return_type = 2;
                $ip_address = $request->ip();
                //$response = $this->pay_to_millikart($online_pay_amount, $this->userID, $return_type, $ip_address, 'courier', $order->id, $new_packages_str);
                $response = $this->pay_to_pashaBank($online_pay_amount, $this->userID, $return_type, $ip_address, 'courier', $order->id, $new_packages_str);
                $payResponse = response(['case' => $response[0], 'title' => $response[1], 'content' => $response[2], 'pay' => true]);
            }

            //dd($payResponse);


            DB::commit();

            if($this->api){
                if (isset($payResponse)) {
                    return $payResponse;
                } else {
                    return redirect()->route('get_courier_page', ['locale' => App::getLocale()]);
                }
            }

            if (isset($payResponse)) {
                // Success mesajını session'a ekle
                return back()->with('success', 'Success')->withInput();
                return $payResponse;
            }
            else {
                return redirect()->route('get_courier_page', ['locale' => App::getLocale()]);
    
            }
            return redirect()->route('get_courier_page', ['locale' => App::getLocale()]);
        } catch (\Exception $exception) {
             //dd($exception);
            DB::rollback();
            Log::error('courier_error', [
                'error' =>$exception
                ]);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    // private functions
    private function calculate_exchange_rate($rates, $from, $to)
    {
        try {
            if ($from == $to) {
                return 1;
            }

            foreach ($rates as $rate) {
                if ($rate->from_currency_id == $from && $rate->to_currency_id == $to) {
                    return $rate->rate;
                }
            }

            return 0;
        } catch (\Exception $exception) {
            return 0;
        }
    }


    ////////////// for api
    public function get_user_data()
    {
        try {
            $user = User::where('id', $this->userID)->get();
            return $user;
        } catch (\Exception $e) {
            return response('Something goes wrong', 404);
        }
    }

    public function get_statuses()
    {
        try {
            $statuses = LbStatus::whereNull('deleted_by')->select('id', 'status_' . App::getLocale())->get();
            return compact('statuses');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_currencies()
    {
        try {
            $currencies = Currency::whereNull('deleted_by')->select('id', 'name', 'icon')->get();
            return compact('currencies');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_categories()
    {
        try {
            $categories = Category::whereNull('deleted_by')->select('id', 'name_' . App::getLocale())->get();
            return compact('categories');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_sellers()
    {
        try {
            $sellers = Seller::whereNull('deleted_by')->select('id', 'name', 'title', 'url', 'img')->get();
            return compact('sellers');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function invoiceUpload($id, Request $request)
    {
        $item = Item::with('package')
            ->where('id', $id)
            ->first();
        $item_arr = [];
        
        if (($request->file('image'))) {
            $file = $request->file('image');
            $file_name = $item->package->getAttribute('internal_id') . '_invoice_' . Str::random(4) . '_' . time();
            Storage::disk('uploads')->makeDirectory('files/packages/invoices');
            $cover = $file;
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('uploads')->put('files/packages/invoices/' . $file_name . '.' . $extension, File::get($cover));
            $url = '/uploads/files/packages/invoices/' . $file_name . '.' . $extension;
            $item_arr['invoice_doc'] = $url;
            $item_arr['invoice_uploaded_date'] = Carbon::now();
            $item_arr['invoice_confirmed'] = 2;
            $item_arr['invoice_status'] = 4;
        } else {
            $url = null;
        }

        Item::where('id', $item->id)->update($item_arr);

        InvoiceLog::create([
            'package_id' => $item->package->getAttribute('id'),
            'client_id' => $this->userID,
            'invoice' => $item->price,
            'currency_id' => $item->currency_id,
            'invoice_doc' => $url,
            'created_by' => $this->userID
        ]);

        return response([
            'case' => 'success',
            'type' => 'success',
            'content' => 'Invoice uploaded successfully'
        ]);
    }

   
    //deleted end

    public function courier_update_packages(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.incomplete_information')]);
        }
        try{

            $courier_order = CourierOrders::where('id', $request->id)
                ->whereNull('deleted_by')
                ->select(
                    'packages',
                    'id',
                    'courier_id'
                )
                ->first();
           
                if($courier_order->courier_id != null){
                    return response([
                        'title'=> 'Oops',
                        'content'=> 'Tarix yenilənmədi! Kuriyer təyin olunub'
                    ]);
                }else{  
                    $date = $request->date;
                    $status = CourierOrders::where(['id'=>$request->id])->whereNull('deleted_by')->update(['date'=>$date]);

                    if($this->api){
                        return response([
                            'title'=> 'Success',
                            'case' => 'success',
                            'content'=> 'Tarix uğurla yeniləndi',
                            'status' => $status
                        ]);
                    }
                
                    return response([
                        'title'=> 'Success',
                        'case' => 'success',
                        'content'=> 'Tarix uğurla yeniləndi'
                    ]);
                    // return redirect()->route('get_courier_page');
                }
            
        }catch (\Exception $e) {
            DB::rollBack();
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'An error occurred!']);
        }

    }

    public function getData(Request $request){
        $courier=CourierOrders::find($request->id);
        return response()->json($courier);
    }

    public function courier_get_region_payment_tariff(){
        // dd('tst');
        try {
            $tariff = CourierRegionTariff::whereNull('deleted_at')
                ->select('static_price', 'dynamic_price', 'from_weight', 'to_weight')
                ->get();

            
                
            return response(['case' => 'success', 'tariff' => $tariff]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }

    }
    
    public function get_azerpost_courier_page(Request $request)
    {
        try {
            $courier_settings = CourierSettings::first();
            
            if (!$courier_settings) {
                return redirect()->route("get_account");
            }
            
            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());
            
            $diff_time = $now->diffInSeconds($closing_time, false);
            
            if ($diff_time < 0) {
                // not today
                $min_date = date("Y-m-d", strtotime(date("Y-m-d") . "+1 day"));
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+3 day"));
            } else {
                $min_date = date('Y-m-d');
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+2 day"));
            }
            
            
            //dd($packages);
            // show orders
            $query = CourierOrders::leftJoin('courier_areas', 'courier_orders.area_id', '=', 'courier_areas.id')
                ->leftJoin('courier_metro_stations', 'courier_orders.metro_station_id', '=', 'courier_metro_stations.id')
                ->leftJoin('courier_payment_types', 'courier_orders.courier_payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('lb_status as status', 'courier_orders.last_status_id', '=', 'status.id')
                ->where(['courier_orders.client_id' => $this->userID])
                ->where('order_type', 2)
                ->whereRaw('(
                (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
                )');
            //->whereRaw('(((courier_orders.courier_payment_type_id = 1 or courier_orders.delivery_payment_type_id = 1) and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 0))');
            
            $where_archive_status = $request->input("archive");
            if (!isset($where_archive_status) || $where_archive_status != 'yes') {
                $query->whereNull('courier_orders.delivered_at');
                $query->whereNull('courier_orders.canceled_at');
            } else {
                $query->whereRaw('(courier_orders.delivered_at is not null or courier_orders.canceled_at is not null)');
            }
            
            $orders = $query->select(
                'courier_orders.id',
                'courier_areas.name_' . App::getLocale() . ' as area',
                'courier_metro_stations.name_' . App::getLocale() . ' as metro_station',
                'courier_orders.address',
                'courier_orders.date',
                'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                'courier_orders.amount',
                'courier_orders.delivery_amount',
                'courier_orders.total_amount',
                'courier_orders.amount',
                'status.status_' . App::getLocale() . ' as status',
                'courier_orders.last_status_id',
                'courier_orders.last_status_date',
                'courier_orders.azerpost_track',
                'courier_orders.is_send_azerpost'
            )
                ->orderBy('id', 'desc')
                ->paginate(15);
            
            return view("web.account.azerpost.index", compact(
                'orders',
                'min_date',
                'max_date'
            ));
        } catch (\Exception $exception) {
            //dd($exception);
            return view("front.error");
        }
    }
    
    public function get_create_azerpost_page(Request $request)
    {
        try {
            $courier_settings = CourierSettings::first();
            
            if (!$courier_settings) {
                return redirect()->route("get_account");
            }
            
            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());
            
            $diff_time = $now->diffInSeconds($closing_time, false);
            
            if ($diff_time < 0) {
                // not today
                $min_date = date("Y-m-d", strtotime(date("Y-m-d") . "+1 day"));
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+3 day"));
            } else {
                $min_date = date('Y-m-d');
                $max_date = date("Y-m-d", strtotime(date("Y-m-d") . "+2 day"));
            }
            
            $amount_for_urgent = $courier_settings->amount_for_urgent;
            
            //$packages_price_for_last_month = $this->packages_price_for_last_month();
            
            $areas = CourierAreas::where('active', 1)->select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();
            $metro_stations = CourierMetroStations::select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();
            
            $regions = CourierRegion::whereNull('deleted_at')->select('id', 'name_' . App::getLocale() . ' as name')->orderBy('name_' . App::getLocale())->get();
            
            //$azerpost_index = DB::table('azerpost_index')->get();
            // show packages
            $users = array();
            array_push($users, $this->userID);
            
            $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
                ->select('id')->get();
            
            $has_sub_accounts = 'yes';
            
            if (count($sub_accounts) == 0) {
                $has_sub_accounts = 'no';
            }
            
            foreach ($sub_accounts as $sub_account) {
                array_push($users, $sub_account->id);
            }
            
            $packages = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->whereIn('package.client_id', $users)
                ->where([
                    'package.in_baku' => 1,
                    'package.is_warehouse' => 3,
                    'has_courier' => 0
                ])
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->orderBy('package.client_id')
                ->orderBy('package.id')
                ->select(
                    'package.id',
                    'package.payment_type_id',
                    'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                    'package.number as track',
                    'package.gross_weight',
                    'package.total_charge_value as amount',
                    'package.amount_usd',
                    'package.amount_azn',
                    'package.paid',
                    'package.paid_sum',
                    'package.paid_azn',
                    'package.currency_id',
                    'package.paid_status',
                    'package.client_id',
                    'client.name as client_name',
                    'client.surname as client_surname',
                    'package.external_w_debt',
                    'package.external_w_debt_azn',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd'
                )
                ->get();
            
            //if (count($packages) == 0) {
            //    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.no_referral_packages')]);
            //}
            
            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();
            
            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }
            
            foreach ($packages as $package) {
                $currency_id = $package->currency_id;
                
                if ($has_rate) {
                    $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                } else {
                    $rate_to_azn = 1;
                }
                
                $amount = $package->amount_azn;
                $external_debt = $package->external_w_debt_azn;
                $internal_debt = $package->internal_w_debt;
                $paid_azn = $package->paid_azn;
                
                if($paid_azn > 0){
                    $amount = $paid_azn - $amount;
                    
                    if ($amount > 0) {
                        $external_debt -= $amount;
                    }
                    
                    if ($amount != 0 && $external_debt != 0) {
                        $internal_debt_collect = $external_debt + $internal_debt;
                        $external_debt = $external_debt > 0 ? $external_debt : 0;
                        $internal_debt = $external_debt > 0 ? $internal_debt : $internal_debt_collect;
                        $amount = 0;
                    } else {
                        $internal_debt = $internal_debt;
                        $amount = 0;
                    }
                    
                    
                }
                
                
                //$amount_azn = ($package->amount - $package->paid) * $rate_to_azn;
                $amount_azn = sprintf('%0.2f', $amount);
                $external_amount_azn = sprintf('%0.2f', $external_debt);
                $internal_amount_azn = sprintf('%0.2f', $internal_debt);
                
                $package->amount = $amount_azn;
                $package->external_w_debt = $external_amount_azn;
                $package->internal_w_debt = $internal_amount_azn;
                
                if (strlen($package->track) > 7) {
                    $package->track = substr($package->track, strlen($package->track) - 7);
                }
                
                if ($package->paid_status == 0) {
                    $package->payment_type = 'Not paid';
                }
            }
            
            //dd($packages);
            // show orders
            $query = CourierOrders::leftJoin('courier_areas', 'courier_orders.area_id', '=', 'courier_areas.id')
                ->leftJoin('courier_metro_stations', 'courier_orders.metro_station_id', '=', 'courier_metro_stations.id')
                ->leftJoin('courier_payment_types', 'courier_orders.courier_payment_type_id', '=', 'courier_payment_types.id')
                ->leftJoin('lb_status as status', 'courier_orders.last_status_id', '=', 'status.id')
                ->where(['courier_orders.client_id' => $this->userID])
                ->whereRaw('(
                (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
                )');
            //->whereRaw('(((courier_orders.courier_payment_type_id = 1 or courier_orders.delivery_payment_type_id = 1) and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 1) or (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1 and courier_orders.is_paid = 0))');
            
            $where_archive_status = $request->input("archive");
            if (!isset($where_archive_status) || $where_archive_status != 'yes') {
                $query->whereNull('courier_orders.delivered_at');
                $query->whereNull('courier_orders.canceled_at');
            } else {
                $query->whereRaw('(courier_orders.delivered_at is not null or courier_orders.canceled_at is not null)');
            }
            
            $orders = $query->select(
                'courier_orders.id',
                'courier_areas.name_' . App::getLocale() . ' as area',
                'courier_metro_stations.name_' . App::getLocale() . ' as metro_station',
                'courier_orders.address',
                'courier_orders.date',
                'courier_payment_types.name_' . App::getLocale() . ' as payment_type',
                'courier_orders.amount',
                'courier_orders.delivery_amount',
                'courier_orders.total_amount',
                'courier_orders.amount',
                'status.status_' . App::getLocale() . ' as status',
                'courier_orders.last_status_id',
                'courier_orders.last_status_date',
                'courier_orders.azerpost_track',
                'courier_orders.is_send_azerpost'
            )
                ->orderBy('id', 'desc')
                ->paginate(15);
            
            if($this->api){
                return response([
                    'packages' => $packages,
                    'orders' => $orders
                ]);
            }
            
            return view("web.account.azerpost.create", compact(
                'areas',
                'regions',
                'metro_stations',
                'orders',
                'min_date',
                'max_date',
                'amount_for_urgent',
                'packages',
                'has_sub_accounts'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function courier_create_order_region(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'packages_list' => ['required', 'string', 'max:1000'],
            'region_id' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:30'],
            'date' => ['required', 'date'],
            'courier_payment_type_id' => ['integer'],
            'delivery_payment_type_id' => ['integer'],
            'post_zip' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.incomplete_information')]);
        }

        try {
            DB::beginTransaction();

            $courier_settings = CourierSettings::first();

            if (!$courier_settings) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
            }

            $closing_time = Carbon::parse($courier_settings->closing_time);
            $now = Carbon::parse(Carbon::now()->toTimeString());

            $diff_time = $now->diffInSeconds($closing_time, false);
            // dd($closing_time);

            if ($diff_time < 0) {
                // not today
                $min_date = 1;
                $max_date = 3;
            } else {
                $min_date = 0;
                $max_date = 2;
            }

            $today = Carbon::parse(Carbon::today()->toDateString());
            $selected_date = Carbon::parse($request->date);
            $diff_date = $today->diffInDays($selected_date, false);

            if ($diff_date < $min_date || $diff_date > $max_date) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.date_message')]);
            }

            $courier_daily_limits = CourierDailyLimits::whereDate('date', $selected_date)->orderBy('id', 'desc')->select('id', 'count', 'used')->first();
            if (!$courier_daily_limits) {
                $limit_residue = 1;
                $limit_id = 0;
                $limit_used = 0;
                $has_limit = false;
            } else {
                $limit_id = $courier_daily_limits->id;
                $limit_count = $courier_daily_limits->count;
                $limit_used = $courier_daily_limits->used;
                $limit_residue = $limit_count - $limit_used;
                $has_limit = true;
            }

            if ($limit_residue <= 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Seçdiyiniz gün üçün kuryer sifarişi bitmişdir. Zəhmət olmasa başqa tarix seçin.']);
            }


            $area_id = $request->region_id;
            $area = CourierRegion::where('id', $area_id)->first();
            if (!$area) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.area_not_correct')]);
            }
   
            $old_packages_str = $request->packages_list;
            $old_packages_arr = explode(',', $old_packages_str);
            unset($request['packages_list']);

            $post_index = DB::table('azerpost_index')->where('id', $request->post_zip)->first();
            //dd($post_index->index_code);

            $users = array();
            array_push($users, $this->userID);

            $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
                ->select('id')->get();

            foreach ($sub_accounts as $sub_account) {
                array_push($users, $sub_account->id);
            }

            $packages = Package::whereNull('deleted_by')
                ->whereIn('package.client_id', $users)
                ->where([
                    'package.in_baku' => 1,
                    'package.is_warehouse' => 3,
                    'has_courier' => 0
                ])
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by')
                ->whereIn('id', $old_packages_arr)
                ->get();

            if (count($packages) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => __('courier.packages_not_conditions')]);
            }

            $date = Carbon::now();
            $rates = ExchangeRate::whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->where('to_currency_id', 3) // to AZN
                ->select('rate', 'from_currency_id', 'to_currency_id')
                ->get();

            $has_rate = true;
            if (count($rates) == 0) {
                $has_rate = false;
            }

            $delivery_payment_type_id = 1;
            $courier_payment_type_id = 1;
            
            $new_packages_str = '';
            $amount = 0;
            $delivery_amount = 0;
            $packages_arr_for_update = array();
            $total_weight = 0;
            $azerpost_weight = 0;

            foreach ($packages as $package) {
                $new_packages_str .= $package->id . ',';
                $currency_id = $package->currency_id;

                /*$package_external_w_debt = $package->external_w_debt;
                $package_internal_w_debt = $package->internal_w_debt;

                $rate = $this->GetExchangeRate(1, 3);
                $package_external_w_debt_to_azn = $package_external_w_debt * $rate;

                if ($has_rate) {
                    $rate_to_azn = $this->calculate_exchange_rate($rates, $currency_id, 3);
                } else {
                    $rate_to_azn = 1;
                }

                $package_amount_azn = $package->amount * $rate_to_azn;
                $package_amount_azn = sprintf('%0.2f', $package_amount_azn);

                $package_paid_azn = $package->paid * $rate_to_azn;
                $package_paid_azn = sprintf('%0.2f', $package_paid_azn);

                $package_amount_sum = ($package_amount_azn  + $package_external_w_debt_to_azn + $package_internal_w_debt) - $package_paid_azn;

                $delivery_amount += $package_amount_sum;*/
    
                $result = $this->CourierCalculatePaid($package);
                $pay = $result['paid_azn'];
    
                $delivery_amount += $pay;

                $total_gross_weight = $package->gross_weight;
                $total_weight += $total_gross_weight;

                $azerpost_weight = bcadd($azerpost_weight, $total_gross_weight, 3);
           
                if (($delivery_payment_type_id != 1 || $package->paid_status == 1) && $courier_payment_type_id != 1) {
                    array_push($packages_arr_for_update, $package->id);
                }
                
                // array_push($packages_arr_for_update, $package->id);
              
            }
            //dd($delivery_amount);
            //$azerpost_weight = $total_weight;
            $total_weight = ceil($total_weight);
            $total_weight = $total_weight * 1000;

            $tariff = CourierRegionTariff::whereNull('deleted_at')
                ->where('from_weight', '<=', $total_weight)
                ->where('to_weight', '>=', $total_weight)
                ->select('static_price', 'dynamic_price', 'from_weight', 'to_weight')
                ->first();
          
            $total_weight = $total_weight / 1000;
            
            $amount = $tariff->static_price + ($total_weight * $tariff->dynamic_price);
           
            // dd($amount);
            $online_pay_amount = 0;
      
            $online_pay_amount += $amount;

         
            $online_pay_amount += $delivery_amount;
           

            $new_packages_str = substr($new_packages_str, 0, -1);

            $azerpost_track = $this->generateUniqueId();

            //dd($uniqueId);
            $request->merge([
                'packages' => $new_packages_str,
                'created_by' => $this->userID,
                'client_id' => $this->userID,
                'amount' => $amount,
                'delivery_amount' => $delivery_amount,
                'total_amount' => $online_pay_amount,
                'courier_payment_type_id' => $courier_payment_type_id,
                'delivery_payment_type_id' => $delivery_payment_type_id,
                'post_zip' => $post_index->index_code,
                'order_weight' => $azerpost_weight,
                'azerpost_track' => $azerpost_track,
                'order_type' => 2
            ]);

            // dd($packages_arr_for_update);
            $order = CourierOrders::create($request->all());

            Package::whereIn('id', $packages_arr_for_update)->update([
                'courier_order_id' => $order->id,
                'has_courier' => 1,
                'has_courier_by' => $this->userID,
                'has_courier_at' => Carbon::now(),
                'has_courier_type' => 'user_create_order_' . $order->id
            ]);

            CourierOrderStatus::create([
                'order_id' => $order->id,
                'status_id' => 13,
                'created_by' => $this->userID
            ]);

            if ($has_limit) {
                $new_used = $limit_used + 1;
                CourierDailyLimits::where('id', $limit_id)->update(['used' => $new_used]);
            }

            // payment
            $return_type = 2;
            $ip_address = $request->ip();
            //$response = $this->pay_to_millikart($online_pay_amount, $this->userID, $return_type, $ip_address, 'courier', $order->id, $new_packages_str);
            $response = $this->pay_to_pashaBank($online_pay_amount, $this->userID, $return_type, $ip_address, 'courier', $order->id, $new_packages_str);
            $payResponse = response(['case' => $response[0], 'title' => $response[1], 'content' => $response[2], 'pay' => true]);
       

            DB::commit();
            
            if($this->api){
                if (isset($payResponse)) {
                    return response([
                        'paying_info' => $payResponse,
                        'orders' => $order
                    ]);
                } else {
                    return response(['case' => 'success', 'title' => 'Uğurlu!', 'pay' => false]);
                }
            }

            if (isset($payResponse)) {
                return $payResponse;
            } else {
                return response(['case' => 'success', 'title' => 'Uğurlu!', 'pay' => false]);
            }

        } catch (\Exception $exception) {
            //dd($exception);
            DB::rollback();
            Log::error('courier_error', [
                'error' =>$exception
                ]);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }


    // send legality
    public function send_legality(){

        Package::whereNull('deleted_at')
            ->whereNull('send_legality')
            ->where('is_warehouse', 1)
            ->where('client_id', $this->userID)
            ->update([
                'send_legality' => 1
            ]);

        return redirect()->back();
    }


    // balance
    public function get_payment_page()
    {
        try {
            $packages_price_for_last_month = $this->packages_price_for_last_month();

            return view('front.account.payment', compact(
                'packages_price_for_last_month'
            ));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function payment_send_to_millikart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required'],
        ]);
        if ($validator->fails()) {
            // amount is required
            Session::flash('message', "Məbləğ daxil edilməlidir!");
            Session::flash('class', "page-failed");
            Session::flash('description', "Yenidən cəhd edin!");
            Session::flash('display', 'block');
            if ($this->api) {
                return 'Məbləğ daxil edilməlidir!';
            }
            return redirect()->route("get_payment_page");
        }
        try {
            
            $is_partner = User::where('id', $this->userID)->where('is_partner', 1)->first();
     
            if($is_partner){
                $return_type = 4;
                $ip_address = $request->ip();
    
                //$response = $this->pay_to_millikart($request->amount, $this->userID, $return_type, $ip_address, 'payment');
                $response = $this->pay_to_pashaBank($request->amount, $this->userID, $return_type, $ip_address, 'payment');

                if($this->api){
                    return response([
                        'url' => $response
                    ]);
                }
    
                return $response;
            }else{
                return response([
                    'case' => 'warning', 
                    'title' => 'Oops!',
                    'content' => 'Siz partner deyilsiniz'
                ], 404);
            }

        } catch (\Exception $exception) {
            Session::flash('message', "Səhv baş verdi!");
            Session::flash('class', "page-failed");
            Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
            Session::flash('display', 'block');
            return redirect()->route("get_payment_page");
        }
    }

    public function get_payment_logs()
    {
        try {

            $is_partner = User::where('id', $this->userID)->where('is_partner', 1)->first();
            if($is_partner){
                $packages_price_for_last_month = $this->packages_price_for_last_month();
                $logs = PartnerPaymentLog::where('client_id', $this->userID)
                    ->select(
                        'amount',
                        'amount_azn',
                        'client_id',
                        'created_at'
                    )
                    ->orderBy('id', 'desc')
                    ->take(100)
                    ->get();
    
                if($this->api){
                    return response([
                        'logs' => $logs
                    ]);
                }
    
                return view('front.account.partner_payment_log', compact(
                    'packages_price_for_last_month',
                    'logs'
                ));
            }else{
                return response([
                    'case' => 'warning', 
                    'title' => 'Oops!',
                    'content' => 'Siz partner deyilsiniz'
                ], 404);
            }
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }


    public function api_show_orders_for_group_special_orders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
        }
        try {
            $group_code = $request->group_id;

            $orders = SpecialOrder::leftJoin('lb_status as status', 'special_orders.last_status_id', '=', 'status.id')
                ->where('special_orders.group_code', $group_code)
                ->select(
                    'special_orders.id',
                    'special_orders.url',
                    'special_orders.price',
                    'special_orders.quantity',
                    'special_orders.description',
                    'special_orders.color',
                    'special_orders.size',
                    'status.status_' . App::getLocale() . ' as status'
                )
                ->get();

            if (count($orders) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Orders not found!']);
            }

            // if($this->api){
            //     return response([
            //         'case' => 'Success',
            //         'orders' => $orders
            //     ]);
            // }

            return response(['case' => 'success', 'orders' => $orders]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_special_orders_mobil(Request $request, $country_id, $order_id)
    {

        try{
            
            $header = $request->header('Accept-Language');
            
    
            $special_order_group = SpecialOrderGroups::leftJoin('lb_status as status', 'special_order_groups.last_status_id', '=', 'status.id')
                ->leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->where('special_order_groups.id', $order_id)
                ->whereNull('special_order_groups.deleted_at')
                ->select(
                    'special_order_groups.group_code', 
                    'special_order_groups.urls', 'price',  
                    'special_order_groups.is_paid', 'paid', 
                    'special_order_groups.common_debt', 
                    'special_order_groups.cargo_debt',
                    'cur.name as currency',
                    'status.status_' . $header . ' as status'
                )
                ->get();
            
            foreach($special_order_group as $order){
                $total_amount = ($order->price - $order->paid) + $order->cargo_debt + $order->common_debt;
                $order->total_amount = sprintf('%0.2f', $total_amount);
            }
    
            $special_order = SpecialOrder::where('group_code', $order->group_code)
                ->select(
                    'url',
                    'size',
                    'color',
                    'quantity',
                    'price',
                    'description'
                )
                ->get();
    
            return response([
                'order_group' => $special_order_group,
                'orders' => $special_order
            ], Response::HTTP_OK);

        }catch(Exception $exception){
            //dd($exception);
            return response(['title' => 'Error', 'content' => 'something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function pay_to_pashaBank($input_amount, $user_id, $return_type, $ip_address, $payment_type = 'balance', $order_id = 0, $packages_str = null)
    {
        try {

            if ($payment_type == 'balance') {
                // usd
                $date = Carbon::today();
                $rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
                ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                    ->select('rate')
                    ->first();

                if (!$rate) {
                    // rate note found
                    if ($return_type == 1) {
                        Session::flash('message', "Məbləğ hesablanarkən səhv baş verdi!");
                        Session::flash('class', "page-failed");
                        Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                        Session::flash('display', 'block');
                        return redirect()->route("get_balance_page");
                    } else {
                        return ['error', 'Oops!', 'Məbləğ hesablanarkən səhv baş verdi!'];
                    }
                }
                $amount = sprintf('%0.2f', ($input_amount * $rate->rate)) * 100;
            }
            else if ($payment_type == 'payment') {
                // usd
                $date = Carbon::today();
                $rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
                ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                    ->select('rate')
                    ->first();

                if (!$rate) {
                    // rate note found
                    if ($return_type == 4) {
                        Session::flash('message', "Məbləğ hesablanarkən səhv baş verdi!");
                        Session::flash('class', "page-failed");
                        Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                        Session::flash('display', 'block');
                        return redirect()->route("get_balance_page");
                    } else {
                        return ['error', 'Oops!', 'Məbləğ hesablanarkən səhv baş verdi!'];
                    }
                }
                $amount = sprintf('%0.2f', ($input_amount * $rate->rate)) * 100;
            }
            else {
                // courier
                // azn
                $amount = $input_amount * 100;
            }

            $client_url = "";
            $currency = 944;
            $description = "c_" . $user_id;
            $language = "az";

            $ca = "/var/www/sites/certificates/PSroot.pem";
            $key = "/var/www/sites/certificates/rsa_key_pair.pem";
            $cert = "/var/www/sites/certificates/certificate.0031686.pem";

            $merchant_handler = "https://ecomm.pashabank.az:18443/ecomm2/MerchantHandler";
            $client_handler = "https://ecomm.pashabank.az:8463/ecomm2/ClientHandler";

            $params['command'] = "V";
            $params['amount'] = $amount;
            $params['currency'] = $currency;
            $params['description'] = $description;
            $params['language'] = $language;
            $params['msg_type'] = "SMS";
            $params['client_ip_addr'] = $ip_address;
            $params['terminal_id'] = "ECY00271";


            $qstring = http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $merchant_handler);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);
            curl_setopt($ch, CURLOPT_SSLCERT, $cert);
            curl_setopt($ch, CURLOPT_SSLKEY, $key);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");
            //curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $password);
            curl_setopt($ch, CURLOPT_CAPATH, $ca);
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            $result = curl_exec($ch);

            if(empty($result)) $errors[] = 'Ödəniş sistemində xəta baş verdi. Bir az sonra yenidən cəhd edin';

            if(!empty($result)){

                if (curl_error($ch)) array_push($errors, 'Payment error!');

                curl_close($ch);

                $trans_ref = explode(' ', $result)[1];
                $payment_task = $this->generate_payment_task_pasha("pasha", $ip_address, $payment_type, $order_id, $packages_str, $trans_ref, $amount, $this->api);

                $trans_ref = urlencode($trans_ref);
                $client_url = $client_handler . "?trans_id=" . $trans_ref;
            }

            if ($return_type == 1) {
                if ($this->api) {
                    return $client_url;
                }
                return redirect($client_url);
            }else if($return_type == 4){
                if($this->api){
                    return $client_url;
                }
                return redirect($client_url);
            }
            else {
                return ['success', 'Uğurlu', $client_url];
            }
        } catch (\Exception $exception) {
            if ($return_type == 1) {
                Session::flash('message', "Səhv baş verdi!");
                Session::flash('class', "page-failed");
                Session::flash('description', "Zəhmət olmasa yenidən cəhd edin!");
                Session::flash('display', 'block');
                if ($this->api) {
                    return 'Səhv baş verdi!';
                }
                return redirect()->route("get_balance_page");
            } else {
                return ['error', 'Oops!', 'Something went wrong!'];
            }
        }
    }

    private function generate_payment_task_pasha($type, $ip_address, $payment_type, $order_id = 0, $packages_str = null, $trans_ref = null, $amount, $is_api)
    {
        try {
            $key = $trans_ref ?? Str::random(10) . $this->userID . Str::random(4); // unique

            PaymentTask::create([
                'payment_key' => $key,
                'status' => 0,
                'type' => $type,
                'amount' => sprintf('%0.0f', $amount),
                'payment_type' => $payment_type,
                'order_id' => $order_id, // for courier
                'packages' => $packages_str, // for courier
                'ip_address' => $ip_address,
                'created_by' => $this->userID,
                'is_api' => $is_api
            ]);

            return $key;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function bulk_pay(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'package_ids' => ['required']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Oops!', 'content' => 'Paket seçilməyib!!!']);
        }

        try {

            $packages = Package::where('paid_status', 0)
                ->whereIn('id', $request->package_ids)
                ->where('client_id', $this->userID)
                ->where('amount_usd', '>', 0)
                ->whereNull('delivered_by')
                ->whereNull('deleted_at')
                ->distinct()
                ->get();
           // dd($packages);
            if ($packages->count() == 0) {
                return response(['case' => 'error', 'title' => 'Xəbərdarlıq!', 'content' => 'Bağlama tapılmadı. Bağlamaların borcu ödənib!']);
            }



            $amount_ceil = ceil($packages->sum('amount_usd') * 100) / 100;
            $external_w_debt = ceil($packages->sum('external_w_debt') * 100) / 100;
            $internal_w_debt = ceil($packages->sum('internal_w_debt_usd') * 100) / 100;
            $paid_usd = ceil($packages->sum('paid_sum') * 100) / 100;
            //$internal_w_debt_to_usd = $this->ExchangeRate(3, 1, $internal_w_debt);

            $total_amount_ceil = $amount_ceil + $external_w_debt + $internal_w_debt;

            $total_amount = number_format($total_amount_ceil, 2, '.', '');
            $total_amount = ceil(($total_amount - $paid_usd) * 100)/100;
            
            $user = User::where('id', $this->userID)->first();
            $user_balance_ceil = ceil($user->balance * 100) / 100;
            $debt_formatted = number_format($user_balance_ceil, 2, '.', '');

            if ($user->cargo_debt > 0 || $user->common_debt > 0) {
                return response(['case' => 'error', 'title' => 'Xəbərdarlıq!', 'content' => 'Sizin sifariş et xidmətində borcunuz mövcuddur. Zəhmət olmasa öncə sifariş et xidmətinə keçid edərək borcu ödəyin.']);
            }
            if ($debt_formatted == 0) {

                return response([
                    'case' => 'warning',
                    'debt' => 0,
                    'amount_paid' => $total_amount,
                    'title' => 'Xəbərdarlıq!',
                    'content' => 'Balansınızda məbləğ yoxdur! Zəhmət olmasa balansınızı artırın']);
            }

            if ($total_amount > $debt_formatted)
            {
                $missing_amount = $total_amount - $user->balance;
                $rounded_amount = ceil($missing_amount * 100) / 100;
                $formatted_amount = number_format($rounded_amount, 2, '.', '');
                //dd($formatted_amount, $missing_amount, $total_amount, $user->balance);
                return response([
                    //'url' => '',
                    'case' => 'warning',
                    'title' => 'Oops!',
                    'amount_paid' => 'Ümumi məbləğ '. $total_amount .' ',
                    'balance' => 'Balans '. $debt_formatted.' ',
                    'debt' => $formatted_amount,
                    'currency' => 'USD',
                    'content' => 'Hesabda yetərli qədər balans yoxdur. Zəhmət olmasa balansınızı artırın'
                ]);
            }
            else
            {
                $total_pay = 0;
                foreach ($packages as $package) {
    
                    $result = $this->CalculatePaid($package);
                    $pay = $result['pay_usd'];
                    $total_pay += $pay;
                   
                }
     
                $new_balance = $debt_formatted - $total_pay;
                User::where('id', $user->id)->update(['balance' => $new_balance]);
                return response(['case' => 'success', 'title' => 'Paid!', 'content' => 'Ödəniş uğurla başa çatdırıldı!']);
            }

        }catch (Exception $exception){
            //dd($exception);
            return \response( 'Error');
        }
    }

    public function azerpostIndexByRegion(Request $request)
    {
        $region_id = $request->input('region_id');

        $azerpost_index = DB::table('azerpost_index')->where('region_id', $region_id)->get();

        return response()->json([
            'data' => $azerpost_index,
        ]);
    }

    function generateUniqueId() {
        $uniqueId = 'CB'. substr(microtime(true) * 10000, -7) . rand(111, 999) . 'P';
        return $uniqueId;
    }

    private function ExchangeRate($from, $to, $amount)
    {
        $date = Carbon::today();
        $rate = ExchangeRate::where(['from_currency_id' => $from, 'to_currency_id' => $to])
            ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
            ->select('rate')
            ->first();

        if (!$rate) {
            $pay = 0;
        } else {
            $pay = $amount * $rate->rate;
        }
        $pay = sprintf('%0.2f', $pay);

        return $pay;
    }

    private function GetExchangeRate($from_currency_id, $to_currency_id = 1){
        $date = Carbon::today();
        $rate = ExchangeRate::whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->where(['from_currency_id' => $from_currency_id, 'to_currency_id' => $to_currency_id]) //to USD
            ->select('rate')
            ->orderBy('id', 'desc')
            ->first();

        if (!$rate) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Rate not found!']);
        }
        return $rate->rate;
    }

    private function CalculatePaid($package){

        $user_id = $package->client_id;
        $package_id = $package->id;
        
        $amount = $package->total_charge_value;
        $amount_usd = $package->amount_usd;
        $amount_azn = $package->amount_azn;
        
        $paid = $package->paid;
        $paid_usd = $package->paid_sum;
        $paid_azn = $package->paid_azn;
        
        $currency_id = $package->currency_id;

        $external_w_debt_azn = $package->external_w_debt_azn;
        $external_w_debt_usd = $package->external_w_debt;
        $internal_w_debt_azn = $package->internal_w_debt;
        $internal_w_debt_usd = $package->internal_w_debt_usd;
    
        $allDebtUsd = $amount_usd + $internal_w_debt_usd + $external_w_debt_usd;
        $allDebtAzn = $amount_azn + $internal_w_debt_azn + $external_w_debt_azn;

        $pay_azn = $allDebtAzn - $paid_azn;
        $pay_azn = sprintf('%0.2f', $pay_azn);
    
        $pay_usd = $allDebtUsd - $paid_usd;
        $pay_usd = sprintf('%0.2f', $pay_usd);

        $calculate_rate = 1;
        $pay = 0;
        if ($currency_id != 1) { // currency != USD
            $rate = $this->GetExchangeRate(1, $currency_id);
            $calculate_rate = $rate;
            $pay = (($internal_w_debt_usd + $external_w_debt_usd) * $calculate_rate) + $amount;
            $pay = $pay - $paid;
            $pay = sprintf('%0.2f', $pay);
        }else{
            $pay = $pay_usd;
        }
        
        $paid_status = 1;
        $total_paid = $paid + $pay;
        $total_paid_usd = $paid_usd + $pay_usd;
        $total_paid_azn = $paid_azn + $pay_azn;
        
        PaymentLog::create([
            'payment' => $pay,
            'currency_id' => $currency_id,
            'client_id' => $package->client_id,
            'package_id' => $package->id,
            'type' => 3, // balance
            'created_by' => $user_id
        ]);
        
        
        $total_paid = sprintf('%0.2f', $total_paid);
        //dd($total_paid, $no_paid, $paid, $pay);
        Package::where('id', $package_id)
            ->update([
                'paid' => $total_paid,
                'paid_sum' => $total_paid_usd,
                'paid_azn' => $total_paid_azn,
                'paid_status' => $paid_status,
                'payment_type_id' => 1 // online
            ]);

        $payment_code = Str::random(20);
        BalanceLog::create([
            'payment_code' => $payment_code,
            'amount' => $pay_usd,
            'amount_azn' => $pay_azn,
            'client_id' => $user_id,
            'status' => 'out',
            'type' => 'balance'
        ]);

        if ($package->courier_order_id != null) {
            $courier_order_id = $package->courier_order_id;
            $courier_order = CourierOrders::where('id', $courier_order_id)
                ->select('delivery_amount', 'total_amount')
                ->first();

            if ($courier_order) {
                $old_delivery_amount = $courier_order->delivery_amount;
                $old_total_amount = $courier_order->total_amount;

                $new_delivery_amount = $old_delivery_amount - $pay_azn;
                $new_delivery_amount = sprintf('%0.2f', $new_delivery_amount);
                if ($new_delivery_amount < 0) {
                    $new_delivery_amount = 0;
                }

                $new_total_amount = $old_total_amount - $pay_azn;
                $new_total_amount = ceil($new_total_amount *100)/100;
                if ($new_total_amount < 0) {
                    $new_total_amount = 0;
                }

                $courier_order_update_arr = array();
                $courier_order_update_arr['delivery_amount'] = $new_delivery_amount;
                $courier_order_update_arr['total_amount'] = $new_total_amount;

                if ($new_delivery_amount == 0) {
                    $courier_order_update_arr['delivery_payment_type_id'] = 1; // online
                }

                CourierOrders::where('id', $courier_order_id)->update($courier_order_update_arr);
            }
        }
    
        $response = [
            'pay_azn' => $pay_azn,
            'pay_usd' => $pay_usd,
        ];
        
        return $response;
    }
    
    private function CourierCalculatePaid($package){
        
        $amount = $package->amount;
        $amount_usd = $package->amount_usd;
        $amount_azn = $package->amount_azn;
        
        $paid = $package->paid;
        $paid_usd = $package->paid_sum;
        $paid_azn = $package->paid_azn;
        
        $currency_id = $package->currency_id;
        
        $external_w_debt_azn = $package->external_w_debt_azn;
        $external_w_debt_usd = $package->external_w_debt;
        $internal_w_debt_azn = $package->internal_w_debt;
        $internal_w_debt_usd = $package->internal_w_debt_usd;
        
        $allDebtUsd = $amount_usd + $internal_w_debt_usd + $external_w_debt_usd;
        $allDebtAzn = $amount_azn + $internal_w_debt_azn + $external_w_debt_azn;

        if (($paid_usd <= 0 || $paid_azn <= 0) && $paid > 0) {
            $rate_usd_to_azn = $this->ExchangeRate($currency_id, 3, $paid);
           
            $rate_azn_to_usd = $currency_id != 1 ? $this->ExchangeRate($currency_id, 1, $paid) : $paid;
          
            $paid_azn += $rate_usd_to_azn;
            $paid_usd += $rate_azn_to_usd;
        }
    
        $pay_azn = $allDebtAzn - $paid_azn;
        $pay_azn = sprintf('%0.2f', $pay_azn);
        
        
        $response = [
            'paid_azn' => $pay_azn,
        ];

        return $response;
    }
    
    
    public function set_incoming_otp(Request $request)
    {
        $validatedData = $request->validate([
            'platform' => 'required|string|max:255',
        ]);
    
        $clientId = Auth::user()->id;
        $createdBy = Auth::user()->id;
        $text = null;
        $expiredTime = now()->addMinutes(3)->timestamp * 1000000;
    
        DB::table('incoming_otp')->insert([
            'client_id' => $clientId,
            'created_by' => $createdBy,
            'message_txt' => $text,
            'platform' => $validatedData['platform'],
            'is_wait' => true,
            'expired_time' => $expiredTime,
            'created_at' => Carbon::now(),
        ]);
    
        return response()->json([
            'case' => 'success',
            'title' => 'Success!',
        ]);
    }


    public function get_notification_page()
    {
        try{
            $notifications = DB::table('user_devices')
            ->join('user_notification_details', 'user_devices.user_id', '=', 'user_notification_details.client_id')
            ->where('user_notification_details.client_id', Auth::user()->id)
            ->select(
                'user_notification_details.id',
                'user_notification_details.client_id',
                'user_notification_details.subject_header',
                'user_notification_details.is_read',
                'user_notification_details.created_at'
            )->orderByDesc('user_notification_details.id')
            ->paginate(15);

            return view('web.account.notification.index', compact(
                'notifications'
            ));

        }catch(Exception $e){
            return 'error';
        }
    }

    public function change_notification()
    {
        $notification=User::query()
            ->select('sms_notification','email_notification')
            ->where('id',Auth::id())
            ->first();
//        return  $notification;
        return  view('web.account.profile.notification',compact('notification'));
    }

    public function edit_notification(Request $request)
    {
        if($request->type=='sms'){
            User::find(Auth::id())->update(['sms_notification'=>$request->enabled]);
            return response()->json([
                'message'=>'Success'
            ]);
        }
        elseif($request->type='email'){
            User::find(Auth::id())->update(['email_notification'=>$request->enabled]);
            return response()->json([
                'message'=>'Success'
            ]);
        }
        else{
            return response()->json([
                'message'=>'Something went wrong'
            ]);
        }
    }
}