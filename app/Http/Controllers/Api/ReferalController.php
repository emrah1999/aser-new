<?php

namespace App\Http\Controllers\Api;

use App\BalanceLog;
use App\Category;
use App\Country;
use App\CourierOrders;
use App\Currency;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\InvoiceLog;
use App\Item;
use App\Package;
use App\PackageStatus;
use App\PaymentLog;
use App\Seller;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ReferalController extends Controller
{

    public $general_settings;
    private $userID;
    private $api = false;
    public $lang;
    public $sub_accounts;

    public function __construct(Request $request)
    {
        //		$this->middleware(['auth', 'verified']);
        $this->middleware(function ($request, $next) {

            if ($request->get('api')) {
                App::setlocale($request->get('apiLang') ?? 'en');
                $this->userID = $request->get('user_id');

                if (Auth::guest()) {
                    $user = User::find($this->userID);
                    Auth::login($user);
                }
            } else {
                $this->userID = Auth::id();
            }

            $this->general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru', 'referral_secret')->first();
            $this->lang = $request->header('Accept-Language');
            $this->sub_accounts = User::where('parent_id', $this->userID)->select('id')->get();

            return $next($request);
        });
    }

    public function get_sub_accounts()
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

            return compact(
                'sub_accounts',
                'total_debt'
            );
        } catch (\Exception $exception) {
            dd($exception);
            return 'error';
        }
    }

    public function get_sent_referal(){


        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
            ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
            ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
            ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
            ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
            ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
            ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
            ->leftJoin('category', 'item.category_id', '=', 'category.id')
            ->leftJoin('users', 'package.client_id', '=', 'users.id')
            ->whereIn('package.client_id', $this->sub_accounts)
            ->where('package.is_warehouse', 2)
            ->whereNull('package.delivered_by')
            ->whereNull('package.deleted_by');

        $packages = $query
            ->select(
                DB::raw('CONCAT("C", users.id, " ", users.name, " ", users.surname) AS full_name'),
                'flight.name as flight',
                'package.id',
                'package.internal_id',
                'package.number as track',
                'item.price',
                'cur.name as currency',
                'package.gross_weight',
                'package.unit',
                'package.amount_usd',
                'package.last_status_date',
                'package.currency_id',
                'cur_package.icon as cur_icon',
                's.status_' . $this->lang . ' as status',
                's.color as status_color',
                'seller.title as seller',
                'category.name_' .$this->lang
            )
            ->orderBy('package.id', 'desc')
            ->paginate(30);


        return response([
            'packages' => $packages
        ]);
    }

    public function is_warehouse_referal(){

        try {
            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->leftJoin('category', 'item.category_id', '=', 'category.id')
                ->leftJoin('users', 'package.client_id', '=', 'users.id')
                ->whereIn('package.client_id', $this->sub_accounts)
                ->where('package.is_warehouse', 1)
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by');

            $packages = $query
                ->select(
                    DB::raw('CONCAT("C", users.id, " ", users.name, " ", users.surname) AS full_name'),
                    'flight.name as flight',
                    'package.id',
                    'package.internal_id',
                    'package.number as track',
                    'item.price',
                    'cur.name as currency',
                    'package.gross_weight',
                    'package.unit',
                    'package.amount_usd',
                    'package.last_status_date',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    's.status_' . $this->lang . ' as status',
                    's.color as status_color',
                    'seller.title as seller',
                    'category.name_' .$this->lang
                )
                ->orderBy('package.id', 'desc')
                ->paginate(30);

            return response([
                'packages' => $packages
            ]);

        }catch (\Exception $ex){
            return 'error';
            //dd($ex);
        }


    }

    public function in_baku_referal(){

        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
            ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
            ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
            ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
            ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
            ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
            ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
            ->leftJoin('category', 'item.category_id', '=', 'category.id')
            ->leftJoin('users', 'package.client_id', '=', 'users.id')
            ->whereIn('package.client_id', $this->sub_accounts)
            ->where('package.is_warehouse', 3)
            ->whereNull('package.delivered_by')
            ->whereNull('package.deleted_by');

        $packages = $query
            ->select(
                DB::raw('CONCAT("C", users.id, " ", users.name, " ", users.surname) AS full_name'),
                'flight.name as flight',
                'package.id',
                'package.internal_id',
                'package.number as track',
                'item.price',
                'cur.name as currency',
                'package.gross_weight',
                'package.unit',
                'package.amount_usd',
                'package.last_status_date',
                'package.currency_id',
                'cur_package.icon as cur_icon',
                's.status_' . $this->lang . ' as status',
                's.color as status_color',
                'seller.title as seller',
                'category.name_' .$this->lang
            )
            ->orderBy('package.id', 'desc')
            ->paginate(30);


        return response([
            'packages' => $packages
        ]);
    }

    public function delivered_referal(){

        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
            ->leftJoin('users', 'package.client_id', '=', 'users.id')
            ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
            ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
            ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
            ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
            ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
            ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
            ->leftJoin('category', 'item.category_id', '=', 'category.id')
            ->whereIn('package.client_id', $this->sub_accounts)
            ->where('package.is_warehouse', 3)
            ->whereNotNull('package.delivered_by')
            ->whereNull('package.deleted_by');

        $packages = $query
            ->select(
                DB::raw('CONCAT("C", users.id, " ", users.name, " ", users.surname) AS full_name'),
                'flight.name as flight',
                'package.id',
                'package.internal_id',
                'package.number as track',
                'item.price',
                'cur.name as currency',
                'package.gross_weight',
                'package.unit',
                'package.amount_usd',
                'package.last_status_date',
                'package.currency_id',
                'cur_package.icon as cur_icon',
                's.status_' . $this->lang . ' as status',
                's.color as status_color',
                'seller.title as seller',
                'category.name_' .$this->lang
            )
            ->orderBy('package.id', 'desc')
            ->paginate(30);

        return response([
            'packages' => $packages
        ]);
    }
}
