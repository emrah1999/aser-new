<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->orderBy('id', 'desc')
            ->select([
                'id','icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
            ->get();


        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search','description_tracking_search',
            'description_blogs',
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();
        $breadcrumbs = 1;

        return view('web.blogs.index', compact('blogs', 'title', 'breadcrumbs'));
    }

    public function get_blogs($locale,$id)
    {

        $blog = Blog::query()->select([
            'id','icon','internal_images',
            DB::raw("name_" . App::getLocale() . " as name"),
            DB::raw("content_" . App::getLocale() . " as content"),
            DB::raw("ceo_title_" . App::getLocale() . " as ceo_title"),
            DB::raw("seo_description_" . App::getLocale() . " as seo_description"),
        ])
            ->where('id',$id)
            ->first();
        $breadcrumbs = 1;

        return view('web.blogs.blogs',compact('blog','breadcrumbs'));
    }
}
