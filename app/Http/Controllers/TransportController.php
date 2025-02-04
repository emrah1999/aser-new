<?php

namespace App\Http\Controllers;

use App\Faq;
use App\CorporativeLogistic;
use App\Faq2;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function show_transport(){
        $faqs = Faq2::all();
        $deliveries =CorporativeLogistic::all();
        return view('web.transport.index',compact('faqs','deliveries'));
    }
    
    public function getTransportPage(){
        return view('web.transport.single');
    }
}
