<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Currency;
use App\Http\Controllers\Classes\SMS;
use App\Http\Controllers\Controller;
use App\Package;
use App\PackageStatus;
use App\Seller;
use App\SmsTask;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OtherApiController extends Controller
{
    public function seller()
    {
        $first = Seller::where('id', 2824)
            ->whereNull('deleted_by')
            ->select('id', 'name', 'title', 'url', 'img')
            ->get();

        $rest = Seller::whereNull('deleted_by')
            ->where('id', '!=', 2824)
            ->select('id', 'name', 'title', 'url', 'img')
            ->orderBy('title')
            ->get();

        $seller = $first->merge($rest);

        $data = [];
        foreach ($seller as $s) {
            array_push($data, [
                'id' => $s->id,
                'name' => $s->name,
                'title' => $s->title,
                'url' => $s->url,
                'img' => $s->img ? 'https://manager.asercargo.az' . $s->img : null
            ]);
        }

        return $data;
    }


    public function categories(Request $request){
        $header = $request->header('Language');
        $categories = Category::orderBy('name_' . $header)
            ->select('id', 'name_' . $header.' as title', 'country_id')
            ->whereNull('deleted_by')
            ->get();

        return $categories;
    }
    public function prohibitedItems(Request $request)
    {
        $header = $request->header('Language');
        try {
            
            $items = DB::table('prohibited_items')
                ->leftJoin('countries', 'countries.id', '=', 'prohibited_items.country_id')
                ->select('countries.name_' . $header . ' as title', 'prohibited_items.item_' . $header . ' as text')
                ->where('prohibited_items.country_id', '=', $request->country_id)
                ->first();

            if (!$items) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot find item'
                ]);
            }


            return response()->json([
                'status' => true,
                'data' => $items
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
    public function currency(){
        $currencies = Currency::whereNull('deleted_by')->select('id', 'name', 'icon')->orderBy('id')->get();
        return $currencies;
    }

    public function local_tracking_search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => ['required', 'string', 'max:500'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => 'Track not found!']);
        }
        try {
            $header = $request->header('Accept-Language');
            $track = $request->order;

            $package = Package::whereRaw("(package.number = ? or package.internal_id = ?)", [$track, $track])
                ->orderBy('id', 'desc')
                ->select('id')
                ->first();

            if (!$package) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
            }

            $package_id = $package->id;

            $events = PackageStatus::leftJoin('lb_status as status', 'package_status.status_id', '=', 'status.id')
                ->where('package_status.package_id', $package_id)
                ->select('status.status_' . $header . ' as status', 'package_status.created_at as date')
                ->get();

            if (count($events) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Event not found!']);
            }

            return response(['case' => 'success', 'events' => $events]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function getFcmToken(){
        return DB::table('user_devices')->where('user_id', 155724)->get();
    }
    
    public function send_incoming_otp(Request $request)
    {
    
        Log::info('Trendyol', $request->all());
//        $jsonObject = json_decode(implode('', file("php://input")));
//        dd($jsonObject);
//        do_anything($jsonObject->subject, $jsonObject->message);
//
//        $validatedData = $request->validate([
//            'otp' => 'required|string',
//        ]);
//
//        $otpRecord = DB::table('incoming_otp')
//            ->where('is_wait', true)
//            ->where('expired_time', '>', Carbon::now()->timestamp * 1000000)
//            ->orderBy('created_at', 'asc')
//            ->first();
//
//        if (!$otpRecord) {
//            return response()->json([
//                'message' => 'OTP request not found'
//            ], 404);
//        }
//
//        //$this->send_sms($otpRecord->client_id, $validatedData['otp']);
//
//        DB::table('incoming_otp')
//            ->where('id', $otpRecord->id)
//            ->update([
//                'is_wait' => false,
//                'message_txt' => $validatedData['otp']
//            ]);
//
//        return response()->json([
//            'message' => 'OTP başarıyla gönderildi ve kaydedildi.',
//            'client_id' => $otpRecord->client_id
//        ], 200);
    }
    
    public function send_sms($client_id, $otp_text)
    {
        $sms = new SMS();
        $date = Carbon::now();
        $phone_arr_az = array();
        $text = '';
        $client_id_for_sms = 0;
        
        $email = $otp_text;
        
        
        $package = User::where('id', $client_id)->first();
        // dd($package);
        if ($package->id != 0 && $package->id != null && $package != null
            && $package->phone1 != null
        ) {
            if ($package->id != $client_id_for_sms) {
                // new client
                $language_for_sms = strtoupper($package->language);
                switch ($language_for_sms) {
                    case 'AZ':
                        {
                            array_push($phone_arr_az,  $package->phone1);
                        }
                        break;
                    case 'EN':
                        {
                            array_push($phone_arr_az, $package->phone1);
                        }
                        break;
                    case 'RU':
                        {
                            array_push($phone_arr_az, $package->phone1);
                        }
                        break;
                }
                
                $client_id_for_sms = $package->id;
            }
        }
        
        if ($package) {
            $text = $email;
            
            $control_id = time() . 'az';
            $phone_arr_az = array_unique($phone_arr_az);
            $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr_az, $control_id);
            
            // dd($send_bulk_sms);
            if ($send_bulk_sms[0] == true) {
                $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                $json = json_decode(json_encode((array)$response), TRUE);
                if (isset($json['head']['responsecode'])) {
                    $response_code = $json['head']['responsecode'];
                } else {
                    $response_code = 'error';
                }
                if (isset($json['body']['taskid'])) {
                    $task_id = $json['body']['taskid'];
                } else {
                    $task_id = 'error';
                }
                
                if ($response_code == '000') {
                    //success
                    $sms_status = 1;
                } else {
                    //failed
                    $sms_status = 0;
                }
                
                $package_arr_for_sms = array();
                
                array_push($package_arr_for_sms, $package->id);
                
                SmsTask::create([
                    'type' => 'partner',
                    'code' => $response_code,
                    'task_id' => $task_id,
                    'control_id' => $control_id,
                    'package_id' => $package->id,
                    'client_id' => $package->id,
                    'number' => $package->phone1,
                    'message' => $text,
                    'created_by' => $package->id
                ]);
                
            }
        }
        
        
    }
}
