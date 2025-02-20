<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Carousel;
use App\ContractDetail;
use App\Country;
use App\Faq;
use App\Faq2;
use App\HomePageText;
use App\HowWork;
use App\TariffType;
use App\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Instruction;
use App\Seller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\İnternationalDelivery;
use App\CorporativeLogistic;

class IndexController extends HomeController
{
    public function index()
    {
        try {
            $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
                ->get();

            $instructions = Instruction::all();
            $sellers = Seller::where('in_home', 1)->where('has_site', 1)->select('url', 'img', 'title')->take(12)->get();

            $countries = Country::where('url_permission', 1)->select('name_' . App::getLocale(), 'id', 'screen_image')->orderBy('id')->get();


            $countries =İnternationalDelivery::query()
                ->select([
                    'id','icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content"),
                    DB::raw("slug_" . App::getLocale() . " as slug")
                ])
                ->get();

            $types = TariffType::all();

            $faqs = Faq::query()
                ->select([
                    'id',
                    DB::raw("question_" . App::getLocale() . " as name"),
                    DB::raw("answer_" . App::getLocale() . " as content")
                ])
                ->get();

            $works = HowWork::query()
                ->select([
                    'id','icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])
                ->get();

            $deliveries =CorporativeLogistic::query()
                ->select([
                    'id','icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content"),
                    DB::raw("slug_" . App::getLocale() . " as slug")
                ])
                ->get();


            $text = HomePageText::query()
                ->select([
                    'id',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])->first();


            $carousels= Carousel::query()
                ->select([
                    'id','icon',"link",
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
            
            return view('web.home.index')->with([
                'instructions' => $instructions,
                'sellers' => $sellers,
                'countries' => $countries,
                'types' => $types,
                'faqs' => $faqs,
                'carousels' => $carousels,
                'works' => $works,
                'deliveries' => $deliveries,
                'text' => $text,
                'title' => $title,
                'blogs' => $blogs,
            ]);

            // return view('home')->with([
            //     //'instructions' => $instructions,
            //     //'sellers' => $sellers,
            //     //'countries' => $countries,
            //     //'types' => $types
            // ]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return view("front.error");
        }
    }

    public function promo_code()
    {
        return view('web.promo-code.index');
    }

    public function terms_and_conditions(){
        return view('web.terms-and-conditions.index');
    }

    public function show_transport(){
        return view('web.transport.index');
    }

    public function calculate_amount(Request $request) {
        $validator = Validator::make($request->all(), [
            'country' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'unit' => ['required', 'string', 'max:3'],
            'weight' => ['required'],
            'width' => ['nullable'],
            'height' => ['nullable'],
            'length' => ['nullable'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $country_id = $request->country;
            $type = $request->type;
            $unit = $request->unit;
            $weight = $request->weight;
            $width = $request->width;
            $height = $request->height;
            $length = $request->length;
            $volume_weight = ($width * $length * $height) / 6000;

            if ($unit == 'gm') {
                $weight = $weight / 1000;
            }

            $date = Carbon::today();
            $tariffs = ContractDetail::leftJoin('contract as c', 'contract_detail.contract_id', '=', 'c.id')
                ->leftJoin('currency', 'contract_detail.currency_id', '=', 'currency.id')
                ->where(['contract_detail.country_id'=>$country_id, 'c.default_option'=>1, 'c.is_active'=>1, 'contract_detail.is_active'=>1, 'contract_detail.type_id'=>$type])
                ->whereDate('c.start_date', '<=', $date)->whereDate('c.end_date', '>=', $date)
                ->whereDate('contract_detail.start_date', '<=', $date)->whereDate('contract_detail.end_date', '>=', $date)
                ->select('contract_detail.from_weight', 'contract_detail.to_weight', 'contract_detail.weight_control as volume_control', 'contract_detail.rate', 'contract_detail.charge', 'currency.icon')
                ->get();

            $chargeable_weight = $weight;
            foreach ($tariffs as $tariff) {
                if ($tariff->volume_control == 1) {
                    if ($length > 0 && $width > 0 && $height > 0) {
                        if ($volume_weight > $weight) {
                            $chargeable_weight = $volume_weight;
                        } else {
                            $chargeable_weight = $weight;
                        }
                    } else {
                        $chargeable_weight = $weight;
                    }
                } else {
                    $chargeable_weight = $weight;
                }
                if (($chargeable_weight >= $tariff->from_weight) && ($chargeable_weight <= $tariff->to_weight)) {
                    $amount = $tariff->charge + ($chargeable_weight * $tariff->rate);
                    $amount = sprintf('%0.2f', $amount);
                    $currency_icon = $tariff->icon;
                    return response(['case' => 'success', 'amount' => $currency_icon . $amount]);
                }
            }

            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Uyğun tarif tapılmadı!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'unit' => ['required', 'string', 'max:3'],
            'weight' => ['required'],
            'width' => ['nullable'],
            'height' => ['nullable'],
            'length' => ['nullable'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $country_id = $request->country;
            $type = $request->type;
            $unit = $request->unit;
            $weight = $request->weight;
            $width = $request->width;
            $height = $request->height;
            $length = $request->length;
            $volume_weight = ($width * $length * $height) / 6000;

            if ($unit == 'gr') {
                $weight = $weight / 1000;
            }

            $date = Carbon::today();
            $tariffs = ContractDetail::leftJoin('contract as c', 'contract_detail.contract_id', '=', 'c.id')
                ->leftJoin('currency', 'contract_detail.currency_id', '=', 'currency.id')
                ->where(['contract_detail.country_id'=>$country_id, 'c.default_option'=>1, 'c.is_active'=>1, 'contract_detail.is_active'=>1, 'contract_detail.type_id'=>$type])
                ->whereDate('c.start_date', '<=', $date)->whereDate('c.end_date', '>=', $date)
                ->whereDate('contract_detail.start_date', '<=', $date)->whereDate('contract_detail.end_date', '>=', $date)
                ->select('contract_detail.from_weight', 'contract_detail.to_weight', 'contract_detail.weight_control as volume_control', 'contract_detail.rate', 'contract_detail.charge', 'currency.icon')
                ->get();

            $chargeable_weight = $weight;
            foreach ($tariffs as $tariff) {
                if ($tariff->volume_control == 1) {
                    if ($length > 0 && $width > 0 && $height > 0) {
                        if ($volume_weight > $weight) {
                            $chargeable_weight = $volume_weight;
                        } else {
                            $chargeable_weight = $weight;
                        }
                    } else {
                        $chargeable_weight = $weight;
                    }
                } else {
                    $chargeable_weight = $weight;
                }
                if (($chargeable_weight >= $tariff->from_weight) && ($chargeable_weight <= $tariff->to_weight)) {
                    $amount = $tariff->charge + ($chargeable_weight * $tariff->rate);
                    $amount = sprintf('%0.2f', $amount);
                    $currency_icon = $tariff->icon;
                    return response(['case' => 'success', 'amount' => $currency_icon . $amount]);
                }
            }

            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Uyğun tarif tapılmadı!']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
