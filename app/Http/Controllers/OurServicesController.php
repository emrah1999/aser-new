<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Faq2;
use App\ServiceText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class OurServicesController extends Controller
{
    public function index() {
        try {
            $faqs = Faq2::query()
                ->select([
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])->get();

            $text=ServiceText::query()
                ->select([
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])->first();

            return view("web.services.index", compact("faqs", "text"));
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
