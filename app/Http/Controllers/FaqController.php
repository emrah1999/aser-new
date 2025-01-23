<?php

namespace App\Http\Controllers;

use App\Faq;

class FaqController extends HomeController
{
    public function index(){
        try {
            $faqs = Faq::all();
            return view('web.faq.index')->with([
                'faqs'=>$faqs
            ]);
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
}
