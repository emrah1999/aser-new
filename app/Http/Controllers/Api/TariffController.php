<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\ContractDetail;
use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TariffController extends Controller
{
    // private $userID;
    // private $api = false;

    // public function __construct(Request $request)
    // {
    //     dd($request);

    //     //		$this->middleware(['auth', 'verified']);
    //     $this->middleware(function ($request, $next) {

    //         if ($request->get('api')) {
    //             App::setlocale($request->get('apiLang') ?? 'en');
    //             $this->userID = $request->get('user_id');
    //             $this->api = true;
    //             if (Auth::guest()) {
    //                 $user = User::find($this->userID);
    //                 Auth::login($user);
    //             }
    //         } else {
    //             $this->userID = Auth::id();
    //         }
    //         return $next($request);
    //     });
    // }

    public function tariffs(Request $request){
        try {
            $header = $request->header('Language');
            $contract = Contract::where('default_option', 1)->select('id')->first();

            if (!$contract) {
                return redirect()->route("home_page");
            }

            $default_contract = $contract->id;

            $tariffs = ContractDetail::leftJoin('countries', 'contract_detail.country_id', '=', 'countries.id')
                ->leftJoin('currency', 'contract_detail.currency_id', '=', 'currency.id')
                ->leftJoin('tariff_types', 'contract_detail.type_id', '=', 'tariff_types.id')
                ->leftJoin('exchange_rate', function($join) {
                    $join->on('exchange_rate.from_currency_id', '=', 'contract_detail.currency_id')
                        ->whereDate('exchange_rate.from_date', '<=', Carbon::today())
                        ->whereDate('exchange_rate.to_date', '>=', Carbon::today())
                        ->where('exchange_rate.to_currency_id', '=', 3); // to azn
                })
                ->where('contract_detail.contract_id', $default_contract)
                ->orderBy('countries.sort', 'desc')
                ->orderBy('contract_detail.country_id')
                ->orderBy('contract_detail.type_id')
                ->orderBy('contract_detail.from_weight')
                ->whereNotIn('contract_detail.departure_id', [14])
                ->whereNotIn('country_id', [1, 4, 10, 13])
                ->where('country_id',$request['country_id'])
                ->where('contract_detail.type_id', 1)
                ->select(
                    'contract_detail.title_' . $header,
                    'contract_detail.country_id',
                    'contract_detail.from_weight',
                    'contract_detail.to_weight',
                    DB::raw('FORMAT(contract_detail.to_weight, 3) AS to_weight'),
                    'contract_detail.rate',
                    'contract_detail.charge',
                    'contract_detail.sales_rate',
                    'contract_detail.sales_charge',
                    'contract_detail.type_id',
                    'countries.flag',
                    'contract_detail.currency_id as currency',
                    'currency.icon',
                    'tariff_types.name_'. $header . ' as tariff_type_name',
                    'contract_detail.description_' . $header . ' as description',
                    DB::raw('CASE 
                    WHEN exchange_rate.rate IS NOT NULL THEN 
                        CEIL((exchange_rate.rate * 
                        CASE WHEN contract_detail.rate = 0 THEN contract_detail.charge ELSE contract_detail.rate END) * 100) / 100
                    ELSE 0 
                 END AS amount_azn'),
                 DB::raw('CASE
                        WHEN exchange_rate.rate IS NOT NULL
                            AND (contract_detail.sales_rate > 0 OR contract_detail.sales_charge > 0) THEN
                            CEIL((exchange_rate.rate *
                            CASE
                                WHEN contract_detail.sales_rate > 0 THEN contract_detail.sales_rate
                                ELSE contract_detail.sales_charge
                            END) * 100) / 100
                        ELSE 0
                     END AS sales_amount_azn')
                )
                ->get();

   
            $countries = Country::whereNotIn('id', [1, 4, 10, 13])->select('id', 'name_' . $header.' as title', 'flag')->orderBy('sort', 'desc')->orderBy('id')->get();

  
            return response([
                'tariffs' => $tariffs,
                'countries' =>$countries
            ]);
            

        } catch (\Exception $exception) {
            return response($exception);
        }
    }
}
