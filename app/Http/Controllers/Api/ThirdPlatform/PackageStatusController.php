<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use App\Platform;
use App\Settings;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DateTime;
use Exception;

class PackageStatusController extends Controller
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

    public function check_package_status(Request $request)
    {
        try
        {
            $fromDate = $request->start_date;
            $toDate = $request->end_date;
            $datetime1 = new DateTime($fromDate);
            $datetime2 = new DateTime($toDate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
        
            if((int)$days > 60){
                return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Date range cannot be longer than 60 days']);
            }else{
                $package = Package::leftJoin('lb_status as statuses', 'statuses.id', 'package.last_status_id')
                ->leftJoin('item', 'item.package_id', 'package.id')
                ->leftJoin('users', 'users.id', 'package.client_id')
                ->join('currency as cur', 'item.currency_id', '=', 'cur.id')
                ->whereDate('package.created_at', '>=', $request->start_date)
                ->whereDate('package.created_at', '<=', $request->end_date)
                ->where('package.partner_id', $this->platform->id)
                ->where('package.approve_partner', '!=', true);

                $datas = $package->orderBy('package.id')
                ->select([
                    'statuses.status_en as current_status',
                    'package.internal_id as internal_id',
                    'package.number as track_number',
                    'package.gross_weight as gross_weight',
                    'package.carrier_status_id as carrier_status_id',
                    'users.name as username',
                    'users.surname as surname',
                    'package.container_id',
                    'package.last_container_id',
                    'package.is_warehouse',
                    'package.in_baku',
                    'item.price',
                    // 'item.invoice_doc',
                    // 'item.invoice_confirmed',
                    // 'item.invoice_status',
                    'cur.name as currencyName',
                    'package.last_status_date'

                ])
                ->get();
        
                $arr = [];
                $carrier_status_id = '';
                foreach($datas as $data){
                    switch ($data->carrier_status_id) {
                        case '0':
                            {
                                $carrier_status_id = "The package was not sent to the customs system";
                            }
                            break;
                        case '1':
                            {
                                $carrier_status_id = "Client debt ";
                            }
                            break;
                        case '2':
                            {
                                $carrier_status_id = "The package has been declared to the customs by the customer";
                            }
                            break;
                        case '4':
                            {
                                $carrier_status_id = "The package was sent to the customs system. Customer is expected to declare";
                            }
                            break;
                        case '7':
                            {
                                $carrier_status_id = "The package has been loaded into the boxes";
                            }
                            break;
                        case '8':
                            {
                                $carrier_status_id = "Package is ready for flight";
                            }
                            break;
                        
                        default:
                        {
                            $carrier_status_id = "Unknow error";
                        }
                    }
        
                    $conatiner = $data->container_id != null ? $data->container_id : $data->last_container_id;
                    
                    $response = [
                        "current_status" => $data->current_status,
                        "internal_id" => $data->internal_id,
                        "track_number" => $data->track_number,
                        "date" => $data->last_status_date,
                    ];

                    array_push($arr, $response);
                }
                
            
                return $arr;
            


            }
        }
        catch(Exception $exception)
        {
            return response()->json([
                'message' => 'An error occurred!',
            ], Response::HTTP_BAD_REQUEST);
        }

        


    }

    public function approve_partner(Request $request){
        try
        {
            $tracks = $request->tracks;

            if(count($tracks) > 300){
                return response(['status' => 'error', 'case' => 'No more than 300 packages can be sent.'], Response::HTTP_BAD_REQUEST);
            }

            for ($j = 0, $jMax = count($tracks); $j < $jMax; $j++) {
                $tracks[$j] = str_replace('ə', ',', $tracks[$j]);
            }

            $packages = Package::whereIn("number", $tracks)
                ->where('partner_id', $this->platform->id)
                ->where('last_status_id', 3)
                ->get();

            if(count($packages)){
                foreach ($packages as $package){
                    $package->update([
                        'approve_partner' => 1
                    ]);
                }
                return response(['status' => 'success'], Response::HTTP_OK);
            }else{
                return response(['status' => 'error'], Response::HTTP_NOT_ACCEPTABLE);
            }

        }catch (Exception $exception){
            //dd($exception);
            return response()->json([
                'message' => 'An error occurred!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function package_all_status(Request $request, $hash): JsonResponse
    {
        Log::info([
            $request->all(),
            'partner package_all_status',
            $hash,
            $this->platform->id
        ]);
        try {
            if (!$hash) {
                return response()->json([
                    'message' => 'internal_id_required'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }


            $statuses = DB::select(DB::raw('
                SELECT
                    statuses.status_en AS en,
                    package_status.created_at AS status_time,
                    package.number,
                    package.internal_id,
                    courier.azerpost_track
                FROM
                    package
                JOIN
                    package_status ON package.id = package_status.package_id
                JOIN
                    lb_status AS statuses ON statuses.id = package_status.status_id
                LEFT JOIN
                   courier_orders AS courier ON courier.packages  LIKE CONCAT("%", package.id, "%")
                WHERE
                    package.internal_id = :internal_id
                    AND package.partner_id = :partner_id
                ORDER BY
                    package_status.id DESC
            '), [
                'internal_id' => $hash,
                'partner_id' => $this->platform->id
            ]);

            $stat = [];

            foreach ($statuses as $status) {
                $stat[] = [
                    'status' => $status->en,
                    'status_time' => $status->status_time
                ];
            }

            return response()->json([
                'internal_id' => $statuses[0]->internal_id,
                'azerpost_track' => $statuses[0]->azerpost_track,
                'statuses' => $stat
            ], 200);
        } catch (ModelNotFoundException $exception) {
            Log::channel('thirdpart_data_logger')
                ->error($exception->getModel() . ' not found', [
                    'message' => $exception->getMessage(),
                    'internal_id' => $hash
                ]);

            return response()->json([
                'message' => 'order_not_found_by_this_hash',
                'hash' => $hash
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            //dd($exception);
            Log::channel('thirdpart_data_logger')
                ->error('get_order_status_fail', [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'order_hash' => $hash
                ]);

            return response()->json([
                'message' => 'get_order_status_fail'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
