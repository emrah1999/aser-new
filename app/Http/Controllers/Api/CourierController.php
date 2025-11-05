<?php

namespace App\Http\Controllers\Api;

use App\CourierAreas;
use App\CourierMetroStations;
use App\CourierOrders;
use App\CourierRegion;
use App\CourierSettings;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Package;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CourierController extends Controller
{
    public $general_settings;
    private $userID;
    private $api = false;
    public $sub_accounts;

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
            $this->sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();
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

    public function getTexts()
    {
        $users = array();
        array_push($users, $this->userID);

        $sub_accounts = User::where('parent_id', $this->userID)->whereNull('deleted_by')
            ->select('id')->get();

        foreach ($sub_accounts as $sub_account) {
            array_push($users, $sub_account->id);
        }

        $packagesCount = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
            ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
            ->whereIn('package.client_id', $users)
            ->where([
                'package.in_baku' => 1,
                'package.is_warehouse' => 3,
                'has_courier' => 0,
                'package.branch_id' => 1
            ])
            ->whereNull('package.delivered_by')
            ->whereNull('package.deleted_by')->count();
        return response()->json([
           'package_text'=>__('static.order_info'),
           'courier_text'=>__('static.courier_message'),
           'packages_count' => $packagesCount>0?true:false,
        ]);
    }

    public function get_azerpost_courier_page(Request $request){
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
            ->leftJoin('courier_regions', 'courier_orders.region_id', '=', 'courier_regions.id')
            ->where(['courier_orders.client_id' => $this->userID])
            ->where('order_type', 2)
            ->whereRaw('(
                (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
                (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
                )');

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
            'courier_orders.is_send_azerpost',
            'courier_orders.post_zip',
            'courier_orders.phone',
            'courier_regions.name_' . App::getLocale() . ' as region'

        )
            ->orderBy('id', 'desc')
            ->paginate(15);


        return response()->json([
            'orders' => $orders,
            'min_date' => $min_date,
            'max_date' => $max_date,
        ]);

    }

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

    public function courier_settings()
    {
        $courier_settings = CourierSettings::first();


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

        return response([
            'amount_for_urgent' =>  $amount_for_urgent, 
            'min_date' => $min_date, 
            'max_date' => $max_date
        ]);

    }

    public function courier_area(Request $request)
    {
        $header = $request->header('Accept-Language');
        $areas = CourierAreas::where('active', 1)->select('id', 'name_' . $header . ' as name')->orderBy('name_' . $header)->get();

        return $areas;
    }

    public function metro_station(Request $request)
    {
        $header = $request->header('Accept-Language');
        $metro_stations = CourierMetroStations::select('id', 'name_' . $header . ' as name')->orderBy('name_' . $header)->get();

        return $metro_stations;
    }

    public function regions(Request $request)
    {
        $header = $request->header('Accept-Language');
        $regions = CourierRegion::whereNull('deleted_at')->select('id', 'name_' . $header . ' as name')->orderBy('row')->orderBy('name_' . $header)->get();

        return $regions;
    }

    public function courier_package(Request $request)
    {
        $header = $request->header('Accept-Language');

        $users = array();
        array_push($users, $this->userID);
        $packages = Package::leftJoin('courier_payment_types', 'package.payment_type_id', '=', 'courier_payment_types.id')
            ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
            ->whereIn('package.client_id', $users)
            ->where([
                'package.in_baku' => 1,
                'package.is_warehouse' => 3,
                'has_courier' => 0,
            ])
            ->whereIn('package.branch_id',[1,17])
            ->whereNull('package.delivered_by')
            ->whereNull('package.deleted_by')
            ->orderBy('package.client_id')
            ->orderBy('package.id')
            ->select(
                'package.id',
                'package.payment_type_id',
                'courier_payment_types.name_' . $header . ' as payment_type',
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
                'package.external_w_debt_azn',
                'package.internal_w_debt',
                'package.internal_w_debt_usd'

            )
            ->get();

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
//            $amount_azn = ($package->amount - $package->paid) * $rate_to_azn;
            $amount = $package->amount_azn;
            $external_debt = $package->external_w_debt_azn;
            $internal_debt = $package->internal_w_debt;
            $paid_azn = $package->paid_azn;

            if ($paid_azn > 0) {
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
                $package->payment_type = __('buttons.not_paid');
            }
        }

        return $packages;
    }

    public function orders(Request $request)
    {
        $header = $request->header('Accept-Language');
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
            'courier_areas.name_' . $header . ' as area',
            'courier_metro_stations.name_' . $header . ' as metro_station',
            'courier_orders.address',
            'courier_orders.date',
            'courier_payment_types.name_' . $header . ' as payment_type',
            'courier_orders.amount',
            'courier_orders.delivery_amount',
            'courier_orders.total_amount',
            'courier_orders.amount',
            'status.status_' . $header . ' as status',
            'courier_orders.last_status_id',
            'courier_orders.last_status_date',
            'courier_orders.courier_payment_type_id',
            'courier_orders.delivery_payment_type_id'
        )
        ->orderBy('id', 'desc')
        ->paginate(50);

        return $orders;
    }


    public function get_courier_orders_mobil(Request $request, $order_id)
    {
        $header = $request->header('Accept-Language');
        $query = CourierOrders::leftJoin('courier_areas', 'courier_orders.area_id', '=', 'courier_areas.id')
            ->leftJoin('courier_metro_stations', 'courier_orders.metro_station_id', '=', 'courier_metro_stations.id')
            ->leftJoin('courier_payment_types', 'courier_orders.courier_payment_type_id', '=', 'courier_payment_types.id')
            ->leftJoin('package', 'courier_orders.packages', '=', 'package.id')
            ->leftJoin('lb_status as status', 'courier_orders.last_status_id', '=', 'status.id')
            ->where(['courier_orders.id' => $order_id])
            ->whereRaw('(
            (courier_orders.courier_payment_type_id = 1 and courier_orders.is_paid = 1) or
            (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id <> 1) or
            (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_amount = 0) or
            (courier_orders.courier_payment_type_id <> 1 and courier_orders.delivery_payment_type_id = 1 and courier_orders.delivery_amount > 0 and courier_orders.is_paid = 1)
            )');

        $where_archive_status = $request->input("archive");
        if (!isset($where_archive_status) || $where_archive_status != 'yes') {
            $query->whereNull('courier_orders.delivered_at');
            $query->whereNull('courier_orders.canceled_at');
        } else {
            $query->whereRaw('(courier_orders.delivered_at is not null or courier_orders.canceled_at is not null)');
        }

        $orders = $query->select(
            'courier_orders.id',
            'courier_areas.name_' . $header . ' as area',
            'courier_orders.address',
            'courier_orders.date',
            'courier_payment_types.name_' . $header . ' as payment_type',
            'courier_orders.delivery_amount',
            'courier_orders.delivery_payment_type_id',
            'courier_orders.amount',
            'courier_orders.courier_payment_type_id',
            'courier_orders.total_amount',
            'status.status_' . $header . ' as status',
            'courier_orders.last_status_id',
            'courier_orders.phone',
            'courier_orders.packages'
        )
        ->orderBy('id', 'desc')
        ->first();
        
        $stringToArray = array_map('intval', explode(",", $orders->packages));

        $packages = Package::leftJoin('courier_orders', function($join){
            $join->on('package.id', '=', 'courier_orders.packages');
            })
            ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
            ->leftJoin('item', 'package.id', '=', 'item.package_id')
            ->whereIn('package.id', $stringToArray)
            ->whereNull('package.deleted_at')
            ->select(
                'package.id',
                'package.number as track',
                'seller.title as seller',
                'item.price'
            )
            ->get();

        $packages_arr_for_update = array();
        foreach ($packages as $package) {
            array_push($packages_arr_for_update, $package->id);
        }

        return response([
            'orders' => $orders,
            'packages' => $packages
        ]);
    }

    public function show_packages_referrals()
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

            return response($packages);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => __('courier.error_message')]);
        }
    }

    public function azerpostIndexByRegion(Request $request)
    {

        $region_id = $request->get('region');

        $azerpost_index = DB::table('azerpost_index')->where('region_id', $region_id)->get();

        return response()->json([
            'data' => $azerpost_index,
        ]);
    }

}
