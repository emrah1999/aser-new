<?php

namespace App\Http\Middleware;

use App\Platform;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ThirdPlatform
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
             return Platform::where('status_id', 1)->get();
        });

        if (!$request->header('X-AUTH-KEY')) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'AUTHORIZATION_KEY_NOT_DEFINED'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            if (!count($platforms->where('authorization_key', $request->header('X-AUTH-KEY')))) {
                return response()->json([
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => 'PLATFORM_NOT_RECOGNIZED'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return $next($request);
    }
}
