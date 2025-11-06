<?php

namespace App\Http\Controllers;

use App\Title;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        try {
        $fields = ['description_tracking_search','about','description_about','description_faqs','terms',
        ];
            $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

            return view("web.about.about", compact('title'));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
}
