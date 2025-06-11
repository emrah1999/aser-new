<?php

namespace App\Providers;

use App\Blog;
use App\CorporativeLogistic;
use App\InternationalDelivery;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return View
     */
    public function boot()
    {

        $userAgent = request()->header('User-Agent');
        $popupClosed = request()->cookie('popup_closed2');


        $menu=[];
        $menu['tariff']=Menu::query()->where('id',1)->first();
        $menu['logistics']=Menu::query()->where('id',2)->first();
        $menu['services']=Menu::query()->where('id',3)->first();
        $menu['branch']=Menu::query()->where('id',4)->first();
        $menu['contact']=Menu::query()->where('id',5)->first();
        $menu['trackingSearch']=Menu::query()->where('id',6)->first();
        $menu['blog']=Menu::query()->where('id',7)->first();
        $menu['home']=Menu::query()->where('id',8)->first();

        $tariffs=InternationalDelivery::orderBy('rank','asc')->get();
        $logistics=CorporativeLogistic::all();

        $footerBlogs=Blog::query()->where('show',1)->get();



        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false || stripos($userAgent, 'iOS') !== false) {
            if ($popupClosed !== 'true') {
                $userAgent = 1;
            } else {
                $userAgent = 0;
            }
        } elseif (stripos($userAgent, 'Android') !== false) {
            if ($popupClosed !== 'true') {
                $userAgent = 1;
            } else {
                $userAgent = 0;
            }

        } else {
            $userAgent = 0;

        }



        View::share('menu', $menu);
        View::share('tariffs', $tariffs);
        View::share('logistics', $logistics);
        View::share('footerBlogs', $footerBlogs);
        View::share('userAgent', $userAgent);
    }
}
