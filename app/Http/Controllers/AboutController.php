<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        try {
            return view("web.about.about");
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
}
