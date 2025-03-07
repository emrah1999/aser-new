<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Faq;
use App\CorporativeLogistic;
use App\Title;
use App\TransportText;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    public function show_transport(){
        $faqs = Faq::query()->where('page',2)->select([
            'id',
            DB::raw("question_" . App::getLocale() . " as name"),
            DB::raw("answer_" . App::getLocale() . " as content")
        ])
            ->get();
//        $deliveries =CorporativeLogistic::query()
//            ->select([
//                'id','icon',
//                DB::raw("name_" . App::getLocale() . " as name"),
//                DB::raw("content_" . App::getLocale() . " as content")
//            ])
//            ->get();

        $text=TransportText::query()
            ->select([
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content")
            ])
            ->first();

        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();
        $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
            ->where('page',2)
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
            ->get();

        $deliveries =CorporativeLogistic::query()
            ->select([
                'id','icon','rank',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
            ->orderBy('rank', 'asc')
            ->get();

        $breadcrumbs=1;



        return view('web.transport.index',compact('faqs','deliveries','text','title','blogs','breadcrumbs'));
    }
    
    public function getTransportPage($locale, $id){
//        return $id;
        $delivery =CorporativeLogistic::query()
            ->select([
                'id','icon','internal_images',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("ceo_title_" . App::getLocale() . " as ceo_title"),
                DB::raw("seo_description_" . App::getLocale() . " as seo_description"),
            ])
            ->where('id',$id)
            ->first();

        $faqs = Faq::query()->where('page',2)
        ->where('sub_category_id',$id)
        ->select([
            'id',
            DB::raw("question_" . App::getLocale() . " as name"),
            DB::raw("answer_" . App::getLocale() . " as content")
        ])
            ->get();

        $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
            ->where('page',2)
            ->where('sub_category_id',$id)
            ->select([
            'id','icon',
            DB::raw("name_" . App::getLocale() . " as name"),
            DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
        ])
            ->get();


        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

        $breadcrumbs=1;



        return view('web.transport.single',compact('delivery','faqs','blogs','title','breadcrumbs'));
    }
}
