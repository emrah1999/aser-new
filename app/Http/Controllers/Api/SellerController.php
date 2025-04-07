<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function get_sellers()
    {
        try {
            $sellers = Seller::whereNull('deleted_by')->select('id', 'title')->orderBy('name','asc')->get();
            return compact('sellers');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
