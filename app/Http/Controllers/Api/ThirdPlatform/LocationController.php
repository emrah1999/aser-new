<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Http\Controllers\Controller;
use App\Location;
use App\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function __construct(Request $request)
    {
        $platforms = Cache::remember('authorization-keys', 6 * 60 * 60, function () {
            return Platform::where('status_id', 1)->get();
        });
        $platform = $platforms
            ->where('authorization_key', $request->header('X-AUTH-KEY'))
            ->first();

        $this->platform = $platform;
    }

    public function get_locations()
    {
        $locations = Location::where('country_id', $this->platform->country_id)
            ->select('id', 'city', 'country_id', 'name')
            ->first();

        return $locations;
    }
    
}
