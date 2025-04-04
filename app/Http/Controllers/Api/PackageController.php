<?php

namespace App\Http\Controllers\Api;

use App\BalanceLog;
use App\Country;
use App\CourierOrders;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Item;
use App\Package;
use App\PaymentLog;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PackageController extends Controller
{

    private $userID;

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
            return $next($request);
        });
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
    public function SearchTracking(Request $request){
        $validator = Validator::make($request->all(), [
            'track_number' => ['required'],
            'status' => ['required','in:1,2']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Tracking is reuqired'],422);
        }
        if($request->status==1){
            $url='http://parcelsapp.com/az/tracking/'.$request['track_number'];
            return response(['case' => 'success', 'title' => 'Oops!', 'url' => $url]);
        }else{
            $package = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->leftJoin('filial as f', 'package.branch_id', '=', 'f.id')
                ->whereNull('package.deleted_by')
                ->where('package.number',$request->input('track_number'))
                ->select(
                    'package.id',
                    'package.internal_id',
                    'package.number as track',
                    'package.last_status_date',
                    'package.last_status_id',
                    's.status_' . App::getLocale() . ' as status',
                    's.color as status_color'
                )
                ->orderBy('package.id', 'desc')
                ->first();
            if($package){
                return response(['case' => 'success', 'title' => 'Oops!', 'package' => $package]);
            }else{
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Tracking not found'],422);
            }
        }
    }
 
    public function get_sent(Request $request){
        $header = $request->header('Accept-Language');
        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 2)
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by');

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
                    'package.amount_usd',
                    'package.paid_status',
                    'package.paid',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    'flight.name as flight',
                    's.status_' . $header . ' as status',
                    's.color as status_color',
                    'package.issued_to_courier_date', // has courier (null -> false, not null -> true)
                    'package.amount_azn',
                    'package.paid_sum as paid_usd',
                    'package.paid_azn',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd',
                    'package.internal_w_debt_day',
                    'package.external_w_debt_day'
                )
                ->orderBy('package.id', 'desc')
                ->paginate(30);

            $clients = User::whereNull('deleted_at')->where('id', $this->userID)->select('id','is_legality')->first();

            return response([
               'packages' => $packages,
               'client' => $clients
            ]);
    }

    public function is_warehouse(Request $request){

        try {
            $header = $request->header('Accept-Language');
            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 1)
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by');

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
                    'package.amount_usd',
                    'package.paid_status',
                    'package.paid',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    'flight.name as flight',
                    's.status_' . $header . ' as status',
                    's.color as status_color',
                    'package.issued_to_courier_date', // has courier (null -> false, not null -> true)
                    'package.amount_azn',
                    'package.paid_sum as paid_usd',
                    'package.paid_azn',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd',
                    'package.internal_w_debt_day',
                    'package.external_w_debt_day'
                )
                ->orderBy('package.id', 'desc')
                ->paginate(30);

            $clients = User::whereNull('deleted_at')->where('id', $this->userID)->select('id','is_legality')->first();

            return response([
                'packages' => $packages,
                //'count' => $counts,
                'client' => $clients
            ]);

        }catch (\Exception $ex){
            //dd($ex);
            return response([
                'Message' => 'Please send Accept-Language'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function in_baku(Request $request){
        $header = $request->header('Accept-Language');
        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 3)
                ->whereNull('package.delivered_by')
                ->whereNull('package.deleted_by');

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
                    'package.amount_usd',
                    'package.paid_status',
                    'package.paid',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    'flight.name as flight',
                    's.status_' . $header . ' as status',
                    's.color as status_color',
                    'package.amount_azn',
                    'package.paid_sum as paid_usd',
                    'package.paid_azn',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd',
                    'package.internal_w_debt_day',
                    'package.external_w_debt_day',
                    'package.issued_to_courier_date' // has courier (null -> false, not null -> true)
                )
                ->orderBy('package.id', 'desc')
                ->paginate(30);

        $clients = User::whereNull('deleted_at')->where('id', $this->userID)->select('id','is_legality')->first();

        return response([
            'packages' => $packages,
            //'count' => $counts,
            'client' => $clients
        ]);
    }

    public function delivered(Request $request){
        $header = $request->header('Accept-Language');

        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->where('package.client_id', $this->userID)
                ->where('package.is_warehouse', 3)
                ->whereNotNull('package.delivered_by')
                ->whereNull('package.deleted_by');

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
                    'package.amount_usd',
                    'package.paid_status',
                    'package.paid',
                    'package.last_status_date',
                    'package.last_status_id',
                    'package.is_warehouse',
                    'package.currency_id',
                    'cur_package.icon as cur_icon',
                    'flight.name as flight',
                    's.status_' . $header . ' as status',
                    's.color as status_color',
                    'package.amount_azn',
                    'package.paid_sum as paid_usd',
                    'package.paid_azn',
                    'package.external_w_debt',
                    'package.internal_w_debt',
                    'package.internal_w_debt_usd',
                    'package.issued_to_courier_date', // has courier (null -> false, not null -> true)
                    'package.internal_w_debt_day',
                    'package.external_w_debt_day'
                )
                ->orderBy('package.id', 'desc')
                ->paginate(30);

        $clients = User::whereNull('deleted_at')->where('id', $this->userID)->select('id','is_legality')->first();

        return response([
            'packages' => $packages,
            //'count' => $counts,
            'client' => $clients
        ]);
    }

    public function package_mobile(Request $request, $package_id)
    {

        $date = Carbon::today();
        $header = $request->header('Accept-Language');
        
        $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
        ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
        ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
        ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
        ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
        ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
        ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
        ->leftJoin('category', 'item.category_id', '=', 'category.id')
        ->where('item.package_id', $package_id)
        ->whereNull('package.deleted_by');
       

        $packages = $query
            ->select(
                'package.id',
                'flight.name as flight',
                'package.number as track',
                'package.internal_id',
                'seller.title as seller',
                'category.name_' .$header . ' as category',
                'item.price',
                'cur.name as currency',
                'item.invoice_status',
                'item.invoice_doc',
                'package.volume_weight',
                'package.gross_weight',
                'package.paid_status',
                'package.paid',
                'package.last_status_id',
                'package.currency_id',
                'cur_package.icon as cur_icon',
                's.status_' . $header . ' as status',
                's.color as status_color',
                'package.amount_azn',
                'package.issued_to_courier_date' // has courier (null -> false, not null -> true)
            )
            ->orderBy('package.id', 'desc')
            ->paginate(30);

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

        return $packages;
    }

    public function bulk_pay(Request $request){
        $validator = Validator::make($request->all(), [
            'package_ids' => ['required']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'package id is reuqired']);
        }

        try {

           $packages = Package::where('paid_status', 0)
               ->whereIn('id', $request->package_ids)
               ->where('client_id', $this->userID)
               ->where('amount_usd', '>', 0)
               ->whereNull('delivered_by')
               ->whereNull('deleted_at')
               ->get();

            if ($packages->count() == 0) {
                return response(['case' => 'warning', 'title' => 'Xəbərdarlıq!', 'content' => 'Bağlama tapılmadı. Bağlamaların borcu ödənib!']);
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
                return response(['case' => 'error', 'title' => 'Xəbərdarlıq!', 'content' => 'Sizin sifariş et xidmətində borcunuz mövcuddur. Zəhmət olmasa öncə sifariş et xidmətinə keçid edərək borcu ödəyin.'], Response::HTTP_BAD_REQUEST);
            }
            if ($debt_formatted == 0) {
        
                return response([
                    'case' => 'warning',
                    'debt' => 0,
                    'amount_paid' => $total_amount,
                    'title' => 'Xəbərdarlıq!',
                    'content' => 'Balansınızda məbləğ yoxdur! Zəhmət olmasa balansınızı artırın'],Response::HTTP_BAD_REQUEST);
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
                ], Response::HTTP_BAD_REQUEST);
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

               return response(['case' => 'success', 'content' => 'Ödəniş uğurla başa çatdırıldı!'], Response::HTTP_OK);
           }

        }catch (Exception $exception){
            //dd($exception);
            return \response( 'Error');
        }
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

}
