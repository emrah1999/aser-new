<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Faq;
use App\Menu;
use App\Service;
use App\ServiceText;
use App\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class OurServicesController extends Controller
{
    public function index() {
        try {
            $faqs = Faq::query()->where('page',3)->select([
                'id',
                DB::raw("question_" . App::getLocale() . " as name"),
                DB::raw("answer_" . App::getLocale() . " as content")
            ])
                ->get();



            $text=ServiceText::query()
                ->select([
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])->first();
            $fields = [
                'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
                'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
            ];

            $title = Title::query()
                ->select(array_map(function($field) {
                    return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
                }, $fields))
                ->first();

            $services = Service::query()->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
                ->get();

            $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
                ->where('page',1)
                ->select([
                    'id','icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content"),
                    DB::raw("slug_" . App::getLocale() . " as slug")
                ])
                ->get();

            $breadcrumbs=1;



            return view("web.services.index", compact("faqs", "text",'title','blogs','breadcrumbs','services'));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }
    
    public function branches(){
        try {
            $branches = DB::table('filial')->where('is_active', 1)->get();
            $breadcrumbs=1;

            return view("web.services.branches", compact('branches','breadcrumbs'));
        }catch (\Exception $exception){
            return view("front.error");
        }
    }
    
    public function cargomat(){
        try {
            return view("web.services.cargomat");
        }catch (\Exception $exception){
            return view("front.error");
        }
    }

    public function get_services($locale , $id)
    {
        $service = Service::query()->select([
            'id','icon','internal_images',
            DB::raw("name_" . App::getLocale() . " as name"),
            DB::raw("content_" . App::getLocale() . " as content"),
            DB::raw("ceo_title_" . App::getLocale() . " as ceo_title"),
            DB::raw("seo_description_" . App::getLocale() . " as seo_description"),
        ])
            ->where('id',$id)
            ->first();


        return view("web.services.single", compact('service'));
    }
}
