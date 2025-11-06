<?php

namespace App\Http\Controllers;

use App\Blog;
use App\CorporativeLogistic;
use App\InternationalDelivery;
use App\Menu;
use App\News;
use App\Service;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Schema;

class LanguageController extends Controller
{
    // public function set_locale_language($locale)
    // {
    //     if (array_key_exists($locale, Config::get('languages'))) {
    //         Session::put('applocale', $locale);
    //         App::setLocale($locale);
    //     }

    //     $previousUrl = url()->previous();
    //     $urlSegments = explode('/', $previousUrl);

    //     if (isset($urlSegments[3]) && in_array($urlSegments[3], array_keys(Config::get('languages')))) {
    //         $urlSegments[3] = $locale;
    //     } else {
    //         $urlSegments[] = $locale;
    //     }

    //     $newUrl = implode('/', $urlSegments);

    //     return redirect($newUrl);
    // }

    // public function set_locale_language($locale)
    // {
    //     if (array_key_exists($locale, Config::get('languages'))) {
    //         Session::put('applocale', $locale);
    //         App::setLocale($locale);
    //     }

    //     $previousUrl = url()->previous();

    //     $path = parse_url($previousUrl, PHP_URL_PATH);
    //     $segments = explode('/', trim($path, '/'));


    //     $oldLocale = $segments[0];
    //     $slug = end($segments);

    //     $item = Menu::where("slug_{$oldLocale}", $slug)->first();

    //     if (!$item) {
    //         $item = Blog::where("slug_{$oldLocale}", $slug)->first();
    //     }

    //     if ($item) {
    //         $segments[0] = $locale;
    //         $segments[array_key_last($segments)] = $item->{"slug_{$locale}"};
    //     } else {
    //         $segments[0] = $locale;
    //     }

    //     $newUrl = url(implode('/', $segments));

    //     return redirect($newUrl);
    // }

    public function set_locale_language($locale)
    {
        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('applocale', $locale);
            App::setLocale($locale);
        }

        $previousUrl = url()->previous();
        $path = parse_url($previousUrl, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));

        $oldLocale = $segments[0];
        $slug = end($segments);

        $models = [
            Menu::class,
            Blog::class,
            News::class,
            Service::class,
            InternationalDelivery::class,
            CorporativeLogistic::class,
        ];

        $item = null;

        foreach ($models as $model) {
            if (Schema::hasColumn((new $model)->getTable(), "slug_{$oldLocale}")) {
                $item = $model::where("slug_{$oldLocale}", $slug)->first();
                if ($item)
                    break;
            }
        }

        if ($item) {
            $segments[0] = $locale;
            $segments[array_key_last($segments)] = $item->{"slug_{$locale}"};
        } else {
            $segments[0] = $locale;
        }

        return redirect(url(implode('/', $segments)));
    }
}
