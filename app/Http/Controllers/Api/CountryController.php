<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{

    public function get_countries(Request $request){

        $header = $request->header('Accept-Language');
        $countries = Country::whereNull('deleted_at')
            ->where('is_active', 1)
        ->select('id', 'name_' . $header, 'flag', 'image', 'currency_id', 'local_currency', 'currency_for_declaration', 'url_permission', 'currency_type', 'goods_fr', 'goods_to')
        ->orderBy('id')
        ->get();
        
        return $countries;
    }
}
