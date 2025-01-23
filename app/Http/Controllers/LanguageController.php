<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function set_locale_language($locale) {
        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('applocale', $locale);
            App::setLocale($locale);
        }

        $previousUrl = url()->previous();
        $urlSegments = explode('/', $previousUrl);

        if (in_array($urlSegments[3], array_keys(Config::get('languages')))) {
            $urlSegments[3] = $locale;
        }
        
        $newUrl = implode('/', $urlSegments);
        
        return redirect($newUrl);
    }
    
}
