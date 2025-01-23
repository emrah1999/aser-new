<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Platform;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class OrderUpdateController extends Controller
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

    public function order_update(Request $request)
    {
        try{
            $gross_weight = Package::where('hash', $request->hash)->whereNull('deleted_at')->first();
         
            if($gross_weight){
                if($gross_weight->carrier_status_id == 0 && $gross_weight->last_status_id == 37 || $gross_weight->carrier_status_id == 4 && $gross_weight->last_status_id == 37){
                    $gross_weight->update([
                        'gross_weight' => $request->gross_weight,
                        'carrier_status_id' => 9
                    ]);
            
                    return response()->json([
                        'message' => 'Package gross weight was update!',
                        'new_gross_weight' => $gross_weight->gross_weight
                    ], Response::HTTP_OK);  
                }else{
                    return response()->json([
                        'message' => 'The package was sent to customs. You cannot change the gross weight',
                    ], Response::HTTP_METHOD_NOT_ALLOWED);
                }
            }else{
                return response()->json([
                    'message' => 'Package not found!',
                ], Response::HTTP_NOT_FOUND);
            }
        }catch(Exception $ex){
            //dd($ex);
            return response()->json([
                'message' => 'An error occurred!',
            ], Response::HTTP_BAD_REQUEST);
        }    
    }
}
