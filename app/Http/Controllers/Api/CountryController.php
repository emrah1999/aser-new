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
            ->where('url_permission', 1)->whereNotIn('id', [1, 4, 10, 13])
            ->select('id', 'name_' . $header.' as title',DB::raw("CONCAT('".env('APP_URL')."', new_flag) as flag"), DB::raw("CONCAT('".env('APP_URL')."', image) as image"), 'currency_id', 'local_currency', 'currency_for_declaration', 'url_permission', 'currency_type', 'goods_fr', 'goods_to')
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
