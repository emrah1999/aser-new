<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Faq2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OurServicesController extends Controller
{
    public function index() {
        try {
            $faqs = Faq2::all();
            return view("web.services.index", compact("faqs"));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
    
    public function branches(){
        try {
            $branches = DB::table('filial')->where('is_active', 1)->get();
            return view("web.services.branches", compact('branches'));
        }catch (\Exception $exception){
            return view("front.error");
        }
    }
    
    public function cargomat(){
        try {
            return view("web.services.cargomat");
        }catch (\Exception $exception){
            return view("front.error");
        }
    }
}
