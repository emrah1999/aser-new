<?php

namespace App\Providers;

use App\CorporativeLogistic;
use App\İnternationalDelivery;
use App\Menu;
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
        $menu=[];
        $menu['tariff']=Menu::query()->where('id',1)->first();
        $menu['logistics']=Menu::query()->where('id',2)->first();
        $menu['services']=Menu::query()->where('id',3)->first();
        $menu['branch']=Menu::query()->where('id',4)->first();
        $menu['contact']=Menu::query()->where('id',5)->first();
        $menu['trackingSearch']=Menu::query()->where('id',6)->first();

        $tariffs=İnternationalDelivery::all();
        $logistics=CorporativeLogistic::all();


        View::share('menu', $menu);
        View::share('tariffs', $tariffs);
        View::share('logistics', $logistics);
    }
}
