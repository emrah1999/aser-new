<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Country;
use App\Http\Controllers\Controller;
use App\Flight;

use App\Item;
use App\Location;
use App\Package;
use Illuminate\Http\Request;
use App\Platform;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\EmailListContent;
use App\PackageStatus;
use Illuminate\Http\Response;
use App\Jobs\CollectorInWarehouseJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PartnerFlightController extends Controller
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

    public function get_flight(Request $request)
    {
        try {

            $query = Flight::whereNull('deleted_by')
                ->whereNull('deleted_at')
                ->whereNull('status_in_baku_date')
                ->where('location_id', $this->platform->country_id)
                ->orWhere('location_id', 1);
                //->where('carrier', 'IST');

            $flights = $query
                ->select(
                    'id',
                    'name',
                    'carrier',
                    'flight_number',
                    'awb',
                    'departure',
                    'destination',
                    'closed_at'
                )->get();

            foreach ($flights as $flight) {
                $flight_id = $flight->id;
                $packages = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                    ->leftJoin('container', 'package.container_id', '=', 'container.id')
                    ->where('container.flight_id', $flight_id)
                    ->whereNull('package.deleted_by')
                    ->whereNull('container.deleted_by')
                    ->select('package.gross_weight')
                    ->get();

                $total_weight = 0;
                $packages_count = 0;

                foreach ($packages as $package) {
                    $packages_count++;
                    if ($package->gross_weight != null) {
                        $total_weight += $package->gross_weight;
                    }
                }

                $flight->packages_count = $packages_count;
                $flight->total_weight = $total_weight;
            }

            return $flights;


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
                'message' => 'An error occurred!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function create_flight(Request $request){
        $validator = Validator::make($request->all(), [
            'carrier' => ['required', 'string', 'max:3'],
            'flight_number' => ['required', 'date'],
            'awb' => ['nullable', 'string', 'max:15'],
            'departure' => ['required', 'string', 'max:50']
        ]);

        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            unset($request['id']);

            if ($this->platform->id) {
                $public = 3;
            }

            $date = strtotime($request->flight_number);
            $day = date('d', $date);
            $month = date('m', $date);
            $year = date('Y', $date);

            $name = $request->carrier . $day . $month . $year;

            $request->merge([
                'created_by' => $this->platform->id, 
                'name' => $name, 
                'location_id'=>$this->platform->country_id, 
                'public'=>$public,
                'destination' => 'GYD'
            ]);

            $flight = Flight::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'flight_id' =>$flight->id]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }


    public function close_flight(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Flight not found!']);
        }
        try {
            $date = Carbon::now()->toDateTimeString();

            if (Flight::whereNotNull('closed_by')->where('id', $request->id)->select('id')->first()) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Flight already closed!'], Response::HTTP_NOT_FOUND);
            }

            if (Flight::where('id', $request->id)->select('id')->first() == null || Flight::whereNotNull('deleted_at')->where('id', $request->id)->select('id')->first()) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Flight not found!'], Response::HTTP_NOT_FOUND);
            }

            //$containers = Container::where('flight_id', $request->id)->where('deleted_by')->select('id')->get();
            $packages = Package::leftJoin('container as con', 'package.container_id', '=', 'con.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->where('con.flight_id', $request->id)
                ->where('package.client_id', '<>', 0)
                ->whereNull('package.on_the_way_date')
                ->whereNull('package.deleted_by')
                ->whereNull('con.deleted_by')
                ->select('package.id', 'package.client_id', 'package.number', 'package.carrier_registration_number', 'client.name', 'client.surname', 'client.email', 'client.language', 'client.id as cl_id', 'package.carrier_status_id', 'package.internal_id')
                ->orderBy('package.client_id')
                ->get();
            //dd($packages);

            $packages_arr = array();
            $packagesIds = array();

            if (count($packages) > 0) {
                $departure_id = $this->platform->country_id;
                $country = Location::where('id', $departure_id)->select('country_id')->first();
                if ($country) {
                    $country_id = $country->country_id;
                } else {
                    $country_id = 0;
                }

                //variables for email
                $email_to = '';
                $email_title = '';
                $email_subject = '';
                $email_bottom = '';
                $email_content = '';
                $email_list_inside = '';
                $list_insides = '';

                $email = EmailListContent::where(['type' => 'on_the_way_list'])->first();

                if (!$email) {
                    return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Email template not found!']);
                }

                $client_id_for_email = 0;
                foreach ($packages as $package) {

                    if($package->carrier_status_id != 7){
                        $internal_id = $package->internal_id;
                        array_push($packagesIds, $internal_id);
                    }

                    // array_push($packagesIds, [
                    //     'trackNumber' =>  $package->internal_id,
                    //     'carrierStatusId' => $package->carrier_status_id == 2 ? 'Declared' : ($package->carrier_status_id == 7 ? 'AddToBox' : '')
                    // ]);
                    array_push($packages_arr, $package->id);

                    if ($package->client_id != 0 && $package->client_id != null) {
                        if ($package->client_id != $client_id_for_email) {
                            // new client
                            if ($client_id_for_email != 0) {
                                $email_content = str_replace('{list_inside}', $list_insides, $email_content);

                                $job = (new CollectorInWarehouseJob($email_to, $this->platform->email, $email_title, $email_subject, $email_content, $email_bottom))
                                    ->delay(Carbon::now()->addSeconds(10));
                                dispatch($job);
                            }

                            $list_insides = '';

                            $language = $package->language;
                            $language = strtolower($language);

                            $country_check = Country::where('id', $country_id)->select('name_' . $language . ' as name')->first();
                            if ($country_check) {
                                $country_name = $country_check->name;
                            } else {
                                $country_name = '---';
                            }

                            $email_title = $email->{'title_' . $language}; //from
                            $email_subject = $email->{'subject_' . $language};
                            $email_bottom = $email->{'content_bottom_' . $language};
                            $email_content = $email->{'content_' . $language};
                            $email_list_inside = $email->{'list_inside_' . $language};

                            $email_push_content = $email->{'push_content_' . $language};
                            $email_push_content = str_replace('{tracking_number}', $package->number, $email_push_content);

                            $list_inside = $email_list_inside;

                            $list_inside = str_replace('{tracking_number}', $package->number, $list_inside);
                
                            $list_insides .= $list_inside;

                            $email_to = $package->email;
                            $client = $package->name . ' ' . $package->surname;
                            $email_content = str_replace('{name_surname}', $client, $email_content);
                            $email_content = str_replace('{country_name}', $country_name, $email_content);


                            $client_id_for_email = $package->client_id;
                        } else {
                            // same client
                            $list_inside = $email_list_inside;

                            $list_inside = str_replace('{tracking_number}', $package->number, $list_inside);

                            $list_insides .= $list_inside;
                        }
                    }
                }
      
                if($package->carrier_status_id != 7){
                    return response()->json([
                        'message' => "These packages have not been added to the customs box. Please wait until all packages have been 'AddToBox!'",
                        'NotAddToBoxPackages' => $packagesIds
                    ]);
                }
                
                $flight = Flight::where(['id' => $request->id])
                    ->whereNull('deleted_by')
                    ->whereNull('deleted_at')
                    ->whereNull('status_in_baku_date')
                    ->first();

                if($flight->location_id == $this->platform->country_id || $flight->location_id == 1 && $flight->carrier == 'IST'){
                    $flight->update(['closed_by' => $this->platform->id, 'closed_at' => $date]);
                }else{
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Access denied!'], Response::HTTP_NOT_FOUND);
                }

                Package::whereIn('id', $packages_arr)->update(['is_warehouse'=>2, 'on_the_way_date' => Carbon::now(), 'last_status_id' => 14, 'last_status_date' => Carbon::now()]);

                // send email
                if ($client_id_for_email != 0) {
                    $email_content = str_replace('{list_inside}', $list_insides, $email_content);
                    // dd($email_content);
                    $job = (new CollectorInWarehouseJob($email_to, $this->platform->email, $email_title, $email_subject, $email_content, $email_bottom))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
                
               foreach($packages_arr as $pack_arr){
                    PackageStatus::create([
                        'package_id' => $pack_arr,
                        'status_id' => 14, // on the way
                        'created_by' => $this->platform->id
                    ]);
               }
                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Flight closed!', 'closed_at' => $date], Response::HTTP_OK);
            }else{
                return response(['case' => 'Ooops', 'title' => 'Ooops!', 'content' => 'The package was not found on the flight. You cant close!'], Response::HTTP_NOT_FOUND);
            }

        } catch (\Exception $exception) {
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
