<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{

    public function get_countries(Request $request , $status=0){

        $header = $request->header('Language');
        $countries = Country::whereNull('deleted_at')
            ->leftJoin('international_deliveries', 'countries.id', '=', 'international_deliveries.country_id')
            ->where('url_permission', 1)->whereNotIn('countries.id', [1, 4, 10, 13])
            ->select('countries.id',
                'countries.name_' . $header.' as title',
                DB::raw("CONCAT('".env('APP_URL')."', countries.new_flag) as flag"),
                DB::raw("CONCAT('".env('APP_URL')."', countries.image) as image"),
                'countries.currency_id',
                'countries.local_currency',
                'countries.currency_for_declaration',
                'countries.url_permission',
                'countries.currency_type',
                'countries.goods_fr',
                'countries.goods_to',
                'international_deliveries.name_'.$header.' as country_title'
            )
            ->orderBy('sort', 'desc')
            ->orderBy('id')
            ->get();
//        $countries = Country::where('url_permission', 1)->select('id', 'name_' . $header, 'flag', 'new_flag', 'image')->orderBy('sort', 'desc')->orderBy('id')->get();
//return $status ;
        if ($status == 1) {
            $staticCountry = [
                'id' => 'special',
                'title' => 'New York',
                'flag' => 'https://asercargo.az/web/images/content/flag-usa.png',
                'image' => 'https://asercargo.az/web/images/content/flag-usa.png',
                'currency_id' => null,
                'local_currency' => 'AZN',
                'currency_for_declaration' => 'AZN',
                'currency_type' => null,
                'goods_fr' => null,
                'goods_to' => null,
            ];

            $countries->push($staticCountry);
        }
        
        return $countries;
    }
}
