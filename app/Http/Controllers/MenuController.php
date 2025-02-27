<?php

namespace App\Http\Controllers;

use App\Blog;
use App\CorporativeLogistic;
use App\İnternationalDelivery;
use App\Menu;

class MenuController extends Controller
{
    public function index($locale,$slug=null)
    {
        $data=['locale'=>$locale,'slug'=>$slug];

        $country=İnternationalDelivery::query()->where('slug_az',$slug)
            ->orWhere('slug_en',$slug)
            ->orWhere('slug_ru',$slug)
            ->first();

        $blog=Blog::query()->where('slug_az',$slug)
            ->orWhere('slug_en',$slug)
            ->orWhere('slug_ru',$slug)
            ->first();
        $delivery=CorporativeLogistic::query()->where('slug_az',$slug)
            ->orWhere('slug_en',$slug)
            ->orWhere('slug_ru',$slug)
            ->first();
        $menu = Menu::where('slug_' . $locale, $slug)->first();
        if($blog){
            return app(BlogController::class)->get_blogs($locale,$blog->id);
        }
        if($country){
            return app(TariffController::class)->show_tariffs($locale,$country->id);
        }
        if($delivery){
            return app(TransportController::class)->getTransportPage($locale,$delivery->id);
        }
        if (!$menu) {
            return  app(IndexController::class)->index();
        }

        $menuId = $menu->id;

        if ($menuId == 1) {
            return app(TariffController::class)->index();
        }
        elseif ($menuId == 2){
            return app(TransportController::class)->show_transport();
        }
        elseif ($menuId == 3){
            return app(OurServicesController::class)->index();
        }
        elseif ($menuId == 4){
            return app(OurServicesController::class)->branches();
        }
        elseif ($menuId == 5){
            return app(ContactController::class)->index();
        }
        elseif ($menuId == 6){
            return app(TrackingSearchController::class)->get_tracking_search();
        }
       return app(IndexController::class)->index();
    }

}
