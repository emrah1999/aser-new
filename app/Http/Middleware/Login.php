<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->deleted_value() == 0 && Auth::user()->role() == 2) {
            if (Auth::user()->is_verified()) {
                return $next($request);
            }

        }
        return redirect('/logout');
    }
}
