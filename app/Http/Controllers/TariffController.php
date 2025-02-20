<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Contract;
use App\ContractDetail;
use App\Country;
use App\ExchangeRate;
use App\Faq;
use App\Faq2;
use App\HomePageText;
use App\İnternationalDelivery;
use App\Seller;
use App\TariffText;
use App\TariffType;
use App\Title;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class TariffController extends HomeController
{
    public function index(){
//        $countries =İnternationalDelivery::query()
//            ->select([
//                'id','icon',
//                DB::raw("name_" . App::getLocale() . " as name"),
//                DB::raw("content_" . App::getLocale() . " as content")
//            ])
//            ->get();

        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
        ];
        $types = TariffType::all();


        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

        $sellers = Seller::where('in_home', 1)->where('has_site', 1)->select('url', 'img', 'title')->take(12)->get();

        $text=TariffText::query()
            ->select([
                DB::raw("name_1_" . App::getLocale() . " as name1"),
                DB::raw("content_2_" . App::getLocale() . " as content1"),

                DB::raw("name_2_" . App::getLocale() . " as name2"),
                DB::raw("content_2_" . App::getLocale() . " as content2"),

                DB::raw("name_3_" . App::getLocale() . " as name3"),
                DB::raw("content_3_" . App::getLocale() . " as content3")
            ])
            ->first();

        $faqs = Faq::query()->where('page',1)->select([
            'id',
            DB::raw("question_" . App::getLocale() . " as name"),
            DB::raw("answer_" . App::getLocale() . " as content")
        ])
            ->get();
        $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
            ->where('page',2)
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->get();

        $countries =İnternationalDelivery::query()
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
            ->get();

//        return $text;

        $breadcrumbs=1;

        return view('web.tariffs.index', compact(
            'countries',
            'title',
            'sellers',
            'text',
            'types',
            'faqs',
            'blogs',
            'breadcrumbs'
        ));
    }
    
    public function show_tariffs($locale, $country_id) {
        try {
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
                ->where('contract_detail.type_id', 1)
                ->where('country_id', $country_id)
                ->select(
                    'contract_detail.title_' . App::getLocale(),
                    'contract_detail.country_id',
                    'contract_detail.from_weight',
                    'contract_detail.to_weight',
                    'contract_detail.rate',
                    'contract_detail.sales_rate',
                    'contract_detail.charge',
                    'contract_detail.sales_charge',
                    'contract_detail.type_id',
                    'countries.flag',
                    'contract_detail.currency_id as currency',
                    'currency.icon',
                    'tariff_types.name_'. App::getLocale() . ' as tariff_type_name',
                    'contract_detail.description_' . App::getLocale() . ' as description',
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

            $country = İnternationalDelivery::query()
                    ->select(['id','icon',
                        DB::raw("name_" . App::getLocale() . " as name"),
                        DB::raw("content_" . App::getLocale() . " as content"),
                        DB::raw("sub_title_" . App::getLocale() . " as sub_title"),
                        DB::raw("sub_description_" . App::getLocale() . " as sub_description"),
                    ])
                ->where('id', $country_id)
                    ->first();

//            return $country;

            $countries = İnternationalDelivery::query()
                ->select([
                    'id',
                    DB::raw("name_" . App::getLocale() . " as name"),
                ])->get();
    
            $sellers = Seller::where('in_home', 1)->where('has_site', 1)->whereNotNull('img')->select('url', 'img', 'title')->take(6)->get();
            $faqs = Faq::query()->where('page',1)
                ->where('sub_category_id',$country_id)
                ->select([
                    'id',
                    DB::raw("question_" . App::getLocale() . " as name"),
                    DB::raw("answer_" . App::getLocale() . " as content")
                ])
                ->get();
            $types = TariffType::all();

            $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
                ->where('page',1)
                ->where('sub_category_id',$country_id)
                ->select([
                    'id','icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])
                ->get();

            $fields = [
                'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
                'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
            ];

            $title = Title::query()
                ->select(array_map(function($field) {
                    return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
                }, $fields))
                ->first();

            $breadcrumbs=1;
            
            return view('web.tariffs.single', compact(
                'tariffs',
                'country',
                'countries',
                'sellers',
                'faqs',
                'types',
                'blogs',
                'title',
                'breadcrumbs'
            ));
        } catch (\Exception $exception) {

            return view('front.error');
        }
    }
}
