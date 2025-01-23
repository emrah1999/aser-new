<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\DangerousGoodsSettings;
use App\Faq;
use App\Http\Controllers\Controller;
use App\Seller;
use App\SellerCategory;
use App\SellerLocation;
use App\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LayoutController extends Controller
{
    public function get_seller(Request $request){
        try {
            $header = $request->header('Accept-Language');
            $where_category_id = 0;
            $where_location_id = 0;
            $take = 30;

            $search_arr = array(
                'category' => '',
                'location' => ''
            );

            $query = Seller::orderBy('id');

            if (!empty($request->get('category')) && $request->get('category') !== '' && $request->get('category') !== null) {
                $take = 999999;
                $where_category_id = $request->get('category');
                $query->whereIn('id', function ($q) use ($where_category_id) {
                    $q->from(with(new SellerCategory())->getTable())
                        ->where('category_id', '=', $where_category_id)
                        ->whereNull('deleted_by')
                        ->select('seller_id');
                });
                $search_arr['category'] = $where_category_id;
            }

            if (!empty($request->get('location')) && $request->get('location') !== '' && $request->get('location') !== null) {
                $take = 999999;
                $where_location_id = $request->get('location');
                $query->whereIn('id', function ($q) use ($where_location_id) {
                    $q->from(with(new SellerLocation())->getTable())
                        ->where('location_id', '=', $where_location_id)
                        ->whereNull('deleted_by')
                        ->select('seller_id');
                });
                $search_arr['location'] = $where_location_id;
            }

            $sellers = $query->where('has_site', 1)
                ->select('id', 'title as name', 'url', 'img')
                ->take($take)
                ->get();

            $locations = Country::whereNull('deleted_by')->where('is_Active', 1)->select('id', 'name_' . $header)->orderBy('name_' . $header)->get();
            $categories = StoreCategory::whereNull('deleted_by')->select('id', 'name_' . $header)->orderBy('name_' . $header)->get();

            return compact(
                'sellers',
                'search_arr',
                'locations',
                'categories'
            );
        } catch (\Exception $exception) {
            return "Error";
        }
    }


    public function faq(Request $request)
    {
        try {
            $header = $request->header('Accept-Language');
            $faqs = Faq::select("question_$header", "answer_$header")->get();

            foreach ($faqs as $faq) {
                $faq->{"question_$header"} = strip_tags($faq->{"question_$header"});
                $faq->{"answer_$header"} = strip_tags($faq->{"answer_$header"});
                //$faq->{"question_$header"} = str_replace(["\r", "\n", "\t"], '', $faq->{"question_$header"});
                //$faq->{"answer_$header"} = str_replace(["\r", "\n", "\t"], '', $faq->{"answer_$header"});
                $faq->{"question_$header"} = html_entity_decode($faq->{"question_$header"});
                $faq->{"answer_$header"} = html_entity_decode($faq->{"answer_$header"});
            }


            return  $faqs;
        } catch (\Exception $exception) {
            return "error";
        }
    }


    public function dangerousGoods(Request $request)
    {
        try {
            $header = $request->header('Accept-Language');
            $settings = DangerousGoodsSettings::first();

            $dangerous_goods_text = strip_tags($settings->{"text_".$header});

            $text = html_entity_decode($dangerous_goods_text);

            return compact('text');
        } catch (\Exception $exception) {
            //dd($exception);
            return 'error';
        }
    }

}
