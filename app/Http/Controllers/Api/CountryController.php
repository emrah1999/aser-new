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

    public function get_countries(Request $request){

        $header = $request->header('Language');
        $countries = Country::whereNull('deleted_at')
            ->where('is_active', 1)->whereNotIn('id', [1, 4, 10, 13])
        ->select('id', 'name_' . $header.' as title',DB::raw("CONCAT('".env('APP_URL')."', flag) as flag"), DB::raw("CONCAT('".env('APP_URL')."', image) as image"), 'currency_id', 'local_currency', 'currency_for_declaration', 'url_permission', 'currency_type', 'goods_fr', 'goods_to')
        ->orderBy('id')
        ->get();
        
        return $countries;
    }
}
