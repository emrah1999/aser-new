<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ContractDetail;
use App\Country;
use App\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class NewsController extends HomeController
{
    public function show_news() {
        try {
            $newses = DB::table('news')->where('is_active', 1)->select('id', 'name_' . App::getLocale() . ' as name', 'image', 'slug', 'created_at')->get();
            return view('web.news.index', compact('newses'));
        } catch (\Exception $exception) {
            //dd($exception);
            return view('front.error');
        }
    }

    public function news_details(Request $request , $locale, $id) {
        try {
            $news = DB::table('news')->where('is_active', 1)
                ->where('id', $id)
                ->select('id', 'name_' . App::getLocale() . ' as name', 'content_'.App::getLocale().' as content', 'image', 'slug', 'created_at')->first();

            return view('web.news.show', compact('news'));
        } catch (\Exception $exception) {
            //dd($exception);
            return $exception->getMessage();
            return view('front.error');
        }
    }


    public function video_show(Request $request) {
        try {
            return view('web.videos.index');
        } catch (\Exception $exception) {
            //dd($exception);
            return view('front.error');
        }
    }
}
