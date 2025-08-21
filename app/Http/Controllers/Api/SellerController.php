<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function getForwardSmsLog(Request $request){
        $messages=DB::table("phone_message")->orderBy('created_at','desc')->paginate(20);
        $array=array();
        foreach ($messages as $key=>$message){
            $array[]=array(
                'id'=>++$key,
                'message'=>$message->message,
                'created_at'=>date('d.m.Y H:i:s',strtotime($message->created_at)),
            );
        }
        return $array;
    }
}
