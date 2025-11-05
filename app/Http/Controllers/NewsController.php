<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ContractDetail;
use App\Country;
use App\ExchangeRate;
use App\Title;
use App\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class NewsController extends HomeController
{
    public function show_news() {
        try {
            $newses = DB::table('news')->where('is_active', 1)->select('id', 'name_' . App::getLocale() . ' as name', 'image', 'slug', 'created_at')->get();
                    $fields = [
'news','description_news'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();
            return view('web.news.index', compact('newses', 'title'));
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
            $videos = Video::all();
                    $fields = [
            'video', 'description_video'

        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

            return view('web.videos.index', compact('videos', 'title'));
        } catch (\Exception $exception) {
            //dd($exception);
            return view('front.error');
        }
    }
}
