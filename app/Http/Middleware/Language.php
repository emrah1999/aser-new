<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /*public function handle($request, Closure $next)
    {
        if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), Config::get('languages'))) {
            App::setLocale(Session::get('applocale'));
        }
        else {
            // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }*/
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        
        // Eğer locale geçersizse varsayılan dile yönlendir
        if (!array_key_exists($locale, Config::get('languages'))) {
            $fallbackLocale = Config::get('app.fallback_locale'); // Varsayılan dil
            
            // Sadece eğer yanlış URL'den kaynaklanmıyorsa yönlendir
            if ($locale !== $fallbackLocale) {
                return redirect($fallbackLocale . '/' . $request->path());
            }
        }
        
        // Locale doğruysa session ve app locale ayarlarını yap
        Session::put('applocale', $locale);
        App::setLocale($locale);
        
        // Rota var mı kontrol etmeden ilerle, eğer yoksa 404 döner
        return $next($request);
    }
    
    
    
}
