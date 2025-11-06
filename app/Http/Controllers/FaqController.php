<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Title;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FaqController extends HomeController
{
    public function index()
    {
        try {
            $fields = [
                'faqs',
                'description_faqs',
            ];

            $title = Title::query()
                ->select(array_map(function ($field) {
                    return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
                }, $fields))
                ->first();
            $faqs = Faq::all();
            return view('web.faq.index')->with([
                'faqs' => $faqs,
                'title' => $title
            ]);
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
}
