<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Settings;
use App\SpecialOrderGroups;
use App\SpecialOrderPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $date = Carbon::today();
        $rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
            ->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
            ->whereDate('exchange_rate.from_date', '<=', $date)
            ->whereDate('exchange_rate.to_date', '>=', $date)
            ->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
            ->orderBy('exchange_rate.id', 'desc')
            ->get();

        $general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru')->first();

        View::share(['exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

//    public function sahib() {
//        if (Auth::id() == 121514) {
//            $orders = SpecialOrderGroups::whereNotNull('pay_id')
//                ->select('id', 'pay_id', 'is_paid')
//                ->get();
//
//            $count = 0;
//            foreach ($orders as $order) {
//                if ($order->is_paid == 0) {
//                    SpecialOrderPayments::where('order_id', $order->id)
//                        ->update(['paid'=>0]);
//                    $count++;
//                }
//            }
//
//            return 'OK ' . $count;
//        } else {
//            return 'Access denied!';
//        }
//    }
}
