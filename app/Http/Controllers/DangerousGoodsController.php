<?php

namespace App\Http\Controllers;

use App\DangerousGoodsSettings;
use Illuminate\Http\Request;

class DangerousGoodsController extends HomeController
{
    public function index() {
        try {
            $settings = DangerousGoodsSettings::first();

            if (!$settings) {
                return view("front.error");
            }

            $dangerous_goods_text = $settings->text;

            return view("front.dangerous_goods", compact('dangerous_goods_text'));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
}
