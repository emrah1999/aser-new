<?php

namespace App\Http\Controllers;

use App\Faq;
use App\CorporativeLogistic;
use App\Faq2;
use App\TransportText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    public function show_transport(){
        $faqs = Faq2::query()
            ->select([
                'id',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->get();
        $deliveries =CorporativeLogistic::query()
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->get();

        $text=TransportText::query()
            ->select([
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->first();
        return view('web.transport.index',compact('faqs','deliveries','text'));
    }
    
    public function getTransportPage($locale, $id){
//        return $id;
        $delivery =CorporativeLogistic::query()
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->where('id',$id)
            ->first();
        $faqs = Faq2::query()
            ->select([
                'id',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->get();

        return view('web.transport.single',compact('delivery','faqs'));
    }
}
