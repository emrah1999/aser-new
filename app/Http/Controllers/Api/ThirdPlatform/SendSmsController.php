<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\EmailListContent;
use App\Http\Controllers\Classes\SMS;
use App\Http\Controllers\Controller;
use App\Package;
use App\Platform;
use App\SmsTask;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SendSmsController extends Controller
{

    public function send_sms($client_id, $platform_id)
    {
                // $sellerName = $seller_id;
				$sms = new SMS();
				$date = Carbon::now();
				$phone_arr_az = array();
				$text = '';
				$client_id_for_sms = 0;

				$email = 'Hörmətli müştəri, zəhmət olmasa mail adresinizi və ya "smart custom" tətbiqinizi yoxlayaraq, sizə aid olan bağlamaları bəyan edəsiniz';

				
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
								'created_by' => $platform_id
							]);
							
						}
					}

				
    }
}
