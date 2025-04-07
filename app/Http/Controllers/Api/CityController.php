<?php

namespace App\Http\Controllers\Api;

use App\Cities;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{

    public function get_cities(Request $request){

        $header = $request->header('Language');
        $cities = Cities::whereNull('deleted_at')
        ->select('id','name_' . $header.' as title' , 'created_at')
        ->get();
        
        return response($cities);
    }
}
