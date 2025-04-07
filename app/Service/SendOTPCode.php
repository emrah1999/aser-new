<?php
    
    namespace App\Service;
    
    use App\Http\Controllers\Classes\SMS;
    use App\Mail\RegisterMail;
    use App\OTP;
    use App\SmsTask;
    use App\User;
    use Carbon\Carbon;
use Illuminate\Support\Facades\{App, DB, Mail, Validator};
    class SendOTPCode
    {
        public function send_sms($client_id, $phone, $otp_session)
        {
            //dd($phone);
            // $sellerName = $seller_id;
            $sms = new SMS();
            $date = Carbon::now();
            $phone_arr_az = array();
            $text = '';
            $client_id_for_sms = 0;
        
            $otp = rand(100000, 999999);
            
            $email = 'Sizin OTP: '. $otp;
        
        
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
    
                    OTP::create([
                        'otp_session' => $otp_session,
                        'otp' => $otp,
                        'client_id' => $package->id,
                        'phone' => $package->phone1,
                        'is_verify' => 0,
                        'created_by' => $package->id
                    ]);
                
                    SmsTask::create([
                        'type' => 'otp',
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


        public function send_mail($client_id, $email, $otp_session)
        {
            $date = Carbon::now();
            $phone_arr_az = array();
            $text = '';
            $client_id_for_sms = 0;

            $otp = rand(100000, 999999);

            $email = 'Sizin OTP: '. $otp;


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
                                array_push($phone_arr_az,  $package->email);
                            }
                            break;
                        case 'EN':
                            {
                                array_push($phone_arr_az, $package->email);
                            }
                            break;
                        case 'RU':
                            {
                                array_push($phone_arr_az, $package->email);
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
                $userFullName = $package->name. ' '. $package->surname;
                Mail::to($package->email)->send(new RegisterMail($userFullName,$otp));

                    $package_arr_for_sms = array();

                    array_push($package_arr_for_sms, $package->id);

                    OTP::create([
                        'otp_session' => $otp_session,
                        'otp' => $otp,
                        'client_id' => $package->id,
                        'phone' => $package->phone1,
                        'is_verify' => 0,
                        'created_by' => $package->id
                    ]);

                    SmsTask::create([
                        'type' => 'otp',
                        'code' => 1111111111,
                        'task_id' => 11111111111,
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