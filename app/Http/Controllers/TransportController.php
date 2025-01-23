<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function show_transport(){
        return view('web.transport.index');
    }
    
    public function getTransportPage(){
        return view('web.transport.single');
    }
}
