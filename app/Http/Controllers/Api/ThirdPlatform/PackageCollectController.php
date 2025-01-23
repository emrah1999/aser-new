<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Container;
use App\Http\Controllers\Controller;
use App\Package;
use App\Platform;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\PackageStatus;

class PackageCollectController extends Controller
{
    private $platform;
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

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function add_partner_collector(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'container_id' => 'required|integer',
            'data' => "required|array",
            'data.*.hash' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Validation failed!']);
        }

        try{
            $arr=[];
            $arr_cont=[];
            $arr_cont2=[];
            $data = $request->data;
            foreach($data as $package){
               array_push($arr, $package['hash']);
            }
    
            $container = Container::leftJoin('flight as flt', 'container.flight_id', '=', 'flt.id')
            ->whereNull('container.deleted_at')
            ->whereNull('container.deleted_by')
            ->whereIn('flt.location_id', [$this->platform->country_id, 1])
            //->whereIn('flt.carrier', ['IST', 'HKG', 'TK'])
            ->where('container.id', $request->container_id)
            ->first();
             //dd($container);
            if($container->closed_at == null){
                $pack = Package::whereIn('hash', $arr)
                    ->get();
                
                foreach($pack as $paket){
                    if($paket->last_status_id == 40 && $paket->carrier_status_id == 2){
                        $paket->update([
                            'container_id' => $request->container_id,
                            'last_container_id' => $request->container_id,
                            'container_date' => Carbon::now(),
                            'last_status_id' => 5,
                            'last_status_date' => Carbon::now()
                        ]);
                        array_push($arr_cont, $paket->internal_id . ' - ' . Response::HTTP_OK);
                        PackageStatus::create([
                            'package_id' => $paket->id,
                            'status_id' => 5, // ready for carrieg
                            'created_by' => $this->platform->id
                        ]);
                    }else{
                        array_push($arr_cont, $paket->internal_id . ' - ' . Response::HTTP_NOT_FOUND);
                    }
                }
                
           
                return response()->json([
                    'track_id' => $arr_cont
                ]);

            }else{
                return response()->json([
                    'message' => 'Flight was closed',
                ], Response::HTTP_NOT_FOUND);
            }
            
            
        }catch(Exception $exception){
             //dd($exception);
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('flight_closed_failed', [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'orders' => $request->only('orders'),
                    'email' => $request->get('email'),
                    'key' => $request->header('X-AUTH-KEY')
                ]);

            return response()->json([
                'message' => 'An error occurred!',
            ], Response::HTTP_BAD_REQUEST);
        }
        
    }

}
