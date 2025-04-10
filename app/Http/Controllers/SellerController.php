<?php

namespace App\Http\Controllers;

use App\Country;
use App\Seller;
use App\SellerCategory;
use App\SellerLocation;
use App\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SellerController extends HomeController
{
    public function show_sellers(Request $request)
    {
        //    return $request;
        try {
            $take = 30;
            $search_arr = array(
                'category' => '',
                'location' => ''
            );

            $query = Seller::orderBy('title');


            if ($request->has('shop_categories') && is_array($request->get('shop_categories'))) {
                // return "aaa";
                $take = 999999;
                $where_category_id = $request->get('shop_categories');
                $query->whereIn('id', function ($q) use ($where_category_id) {
                    $q->from(with(new SellerCategory())->getTable())
                        ->whereIn('category_id', $where_category_id)
                        ->whereNull('deleted_by')
                        ->select('seller_id');
                });
                $search_arr['category'] = implode(',', $where_category_id);
            }

            if (!empty($request->get('location'))) {
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
            // return $search_arr;


            $sellers = $query->where('has_site', 1)
                ->select('id', 'title as name','title', 'url', 'img')
                ->orderBy('id', 'desc')
                ->paginate(50);
            // ->onEachSide(0)
            // ->appends($request->query());




            $locations = Country::whereNull('deleted_by')->whereNotIn('id', [1, 4, 13, 10])->select('id', 'name_' . App::getLocale())->orderBy('name_' . App::getLocale())->get();
            $categories = StoreCategory::whereNull('deleted_by')->select('id', 'name_' . App::getLocale())->orderBy('name_' . App::getLocale())->get();
            $countries = Country::where('url_permission', 1)->select('id', 'name_' . App::getLocale(), 'new_flag')->orderBy('sort', 'desc')->orderBy('id')->get();

            if ($request->is('api/*')) {
                // return $request;
                $sellers->getCollection()->transform(function ($seller) {
                    $seller->img = 'https://manager.asercargo.az/' . ltrim($seller->img, '/');
                    return $seller;
                });
                return response()->json([
                    'sellers' => $sellers,
                ]);
            }

            return view("web.sellers.index", compact(
                'sellers',
                'search_arr',
                'locations',
                'categories',
                'countries'
            ));
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return view("front.error");
        }
    }
}
