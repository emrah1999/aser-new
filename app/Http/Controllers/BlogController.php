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
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search','video'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();
        return view('web.blogs.index', compact('blogs', 'title'));
    }

    public function get_blogs($locale,$id)
    {

        $blog = Blog::query()->select([
            'id','icon',
            DB::raw("name_" . App::getLocale() . " as name"),
            DB::raw("content_" . App::getLocale() . " as content")
        ])
            ->where('id',$id)
            ->first();

        return view('web.home.blogs',compact('blog'));
    }
}
