<?php

namespace App\Http\Controllers;

use App\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends HomeController
{

    public function index()
    {
        $tutorial=Tutorial::all();
        return view('front.tutorial')->with('tutorials',$tutorial);
    }

}
