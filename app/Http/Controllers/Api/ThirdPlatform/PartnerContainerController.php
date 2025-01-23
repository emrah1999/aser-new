<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Container;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Platform;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PartnerContainerController extends Controller
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
    

    public function get_container(Request $request, $flight_id)
    {
        try {
            $query = Container::leftJoin('flight as flt', 'container.flight_id', '=', 'flt.id')
                ->leftJoin('locations as dep', 'container.departure_id', '=', 'dep.id')
                ->leftJoin('locations as des', 'container.destination_id', '=', 'des.id')
                ->whereNull('container.deleted_at')
                ->whereNull('container.deleted_by')
                ->whereIn('flt.location_id', [$this->platform->country_id, 1])
                //->whereIn('carrier', ['IST', 'HKG'])
                ->where('container.flight_id', $flight_id);


            $containers = $query
                ->select(
                    'container.id',
                    'flt.carrier as carrier',
                    'flt.flight_number',
                    'flt.awb',
                    'container.created_at',
                    'flt.departure as dep',
                    'flt.destination as des'
                )->get();

            // dd($containers);

            return $containers;

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('thirdpart_data_logger')
                ->error('order_create_fail', [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'orders' => $request->only('orders'),
                    'email' => $request->get('email'),
                    'key' => $request->header('X-AUTH-KEY')
                ]);

            return response()->json([
                'message' => 'fails',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create_container(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'flight_id' => ['required', 'integer'],
            'departure_id' => ['required', 'string'],
            'count' => ['required', 'integer', 'min:1'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type'=>'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            unset($request['id']);
            
            if ($this->platform->id) {
                $public = 3;
            }

            // if($request->departure_id == 'IST'){
            //     $departure_id = 7;
            // }elseif($request->departure_id == 'HKG' || $request->departure_id == 'TK'){
            //     $departure_id = 10;
            // }
            
            $request->merge([
                'public'=>$public,
                'created_by' => $this->platform->id,
                'departure_id' => $this->platform->country_id,
                'destination_id' => 1
            ]);

            $count = $request->count;
            unset($request['count']);
            
            $arr = [];
            for ($i = 0; $i < $count; $i++) {
                $container = Container::create($request->all());
                array_push($arr, $container->id);
            }
     
            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'container_ids' => $arr]);
        } catch (\Exception $exception) {
            //dd($exception);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
