<?php

namespace App\Http\Controllers;

use App\BalanceLog;
use App\Country;
use App\CourierOrders;
use App\DebtsLog;
use App\EmailListContent;
use App\ExchangeRate;
use App\Notifications\Emails;
use App\Package;
use App\PartnerPaymentLog;
use App\PaymentLog;
use App\PaymentTask;
use App\SpecialOrderGroups;
use App\SpecialOrderPayments;
use App\SpecialOrderStatus;
use App\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class BalanceController extends Controller
{
	public function callback_millikart(Request $request)
	{
		try {
			$payment_key = $request->input("reference");

			$payment_task = PaymentTask::where(['payment_key' => $payment_key, 'type' => 'millikart', 'status' => 0])
					->orderBy('id', 'desc')
					->select('id', 'payment_type', 'order_id', 'packages')
					->first();

			if ($payment_task) {
				$payment_id = $payment_task->id;
				$payment_type = $payment_task->payment_type; // balance or courier or payment to partner
				$courier_order_id = $payment_task->order_id; // for courier
				$courier_packages = $payment_task->packages; // for courier

				$mid = "asercargo";
				$url = 'https://pay.millikart.az/gateway/payment/status?';
				$url .= 'mid=' . $mid . '&reference=' . $payment_key;

				$client = new Client();
				$response = $client->get($url);
				$response = $client->get($url);
				$content = $response->getBody();

				$response = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
				$json = json_decode(json_encode((array)$response), TRUE);

				$code_description = null;
				$res_code = null;
				$code_control = false;
				$rc_description = null;
				$res_rc = null;
				$rc_control = false;
				switch ($json['code']) {
					case '-1':
						{
							$code_description = "Uğursuz əməliyyat";
							$res_code = '-1';
						}
						break;
					case '0':
						{
							$code_description = "Uğurlu əməliyyat";
							$res_code = '0';
							$code_control = true;
						}
						break;
					case '1':
						{
							$code_description = "Uğursuz əməliyyat";
							$res_code = '1';
						}
						break;
					case '2':
						{
							$code_description = "Əməliyyat sona çatdırılmayıb";
							$res_code = '2';
						}
						break;
					case '3':
						{
							$code_description = "Əməliyyat sona çatdırılmayıb";
							$res_code = '3';
						}
						break;
					case '4':
						{
							$code_description = "Uğursuz əməliyyat";
							$res_code = '4';
						}
						break;
					case '5':
					{
						$code_description = "Əməliyyat geri qaytarılıb (Merçant tərəfindən əməliyyat ləğv edilib)";
						$res_code = '5';
					}
					case '7':
						{
							$code_description = "Uğursuz əməliyyat (əməliyyat sona çatdırılmayıb)";
							$res_code = '7';
						}
						break;
					case '9':
						{
							$code_description = "Uğursuz əməliyyat (Müştəri tərəfindən əməliyyat ləğv edilib)";
							$res_code = '9';
						}
						break;
					case '10':
						{
							$code_description = "Əməliyyat geri qaytarılıb (Merçant tərəfindən əməliyyat ləğv edilib)";
							$res_code = '10';
						}
						break;
					case '11':
						{
							$code_description = "Əməliyyat sona çatdırılmayıb";
							$res_code = '11';
						}
						break;
					case '12':
						{
							$code_description = "Əməliyyat sona çatdırılmayıb (3DS yoxlanışı attempt kimi keçmişdir)";
							$res_code = '12';
						}
						break;
					case '13':
						{
							$code_description = "Əməliyyat sona çatdırılmayıb (OTP kod daxil edilməyib)";
							$res_code = '13';
						}
						break;
					default:
					{
						$code_description = "Bilinməyən xəta";
					}
				}

				if (isset($json['RC'])) {
					switch ($json['RC']) {
						case '000':
							{
								$rc_description = "Uğurlu əməliyyat";
								$res_rc = '000';
								$rc_control = true;
							}
							break;
						case '101':
							{
								$rc_description = "İmtina, istifadə müddəti bitmiş kart";
								$res_rc = '101';
							}
							break;
						case '119':
							{
								$rc_description = "İmtina, kart sahibinə əməliyyata icazə verilmir";
								$res_rc = '119';
							}
							break;
						case '100':
							{
								$rc_description = "İmtina (Şərhsiz)";
								$res_rc = '100';
							}
							break;
						default:
						{
							$rc_description = "Bilinməyən xəta";
						}
					}
				}

				$is_paid = 0;
				if ($code_control && $rc_control) {
					// paid successfully
					$is_paid = 1;
				}

				$pan = null; //cart number
				if (isset($json['pan'])) {
					$pan = $json['pan'];
				}

				$amount_azn = null;
				if (isset($json['amount'])) {
					$amount_azn = $json['amount'];
				}

				PaymentTask::where('id', $payment_id)->update([
						'status' => 1,
						'is_paid' => $is_paid,
						'pan' => $pan,
						'response_code' => $res_code,
						'response_code_description' => $code_description,
						'response_rc' => $res_rc,
						'response_rc_description' => $rc_description,
						'amount' => $amount_azn,
						'response_str' => json_encode($json)
				]);

				if ($is_paid == 1) {
					$class = "page-success";
					$message = "Təşəkkür edirik!";

					$user_id = 0;
					if (isset($json['payment-description']) && isset($json['amount'])) {
						$description = $json['payment-description'];
						$user = explode('_', $description);
						if (count($user) > 1) {
							$user_id = $user[1];
							if (!is_numeric($user_id)) {
								$user_id = 0;
							}
						}
						$amount = $json['amount'];
						if (!is_numeric($amount)) {
							$user_id = 0;
						}
						$user_query = User::where('id', $user_id);
						$user_exist = $user_query->select('balance')->first();
						$user_for_api = $user_query->get();
					
						if (!$user_exist) {
							$user_id = 0;
						}
						if ($user_id == 0) {
							Session::flash('message', "Zəhmət olmasa operatorla əlaqə saxlayın.");
							Session::flash('class', "page-failed");
							Session::flash('description', "Ödəniş balansa əlavə edilərkən xəta baş verdi. Ödəniş kodu: " . $payment_key);
							Session::flash('display', 'block');
							if ($payment_type == 'courier') {
								return redirect()->route("get_courier_page");
							} else if($payment_type == 'payment'){
								return redirect()->route("get_payment_page");
							}
							else {
								return redirect()->route("get_balance_page");
							}
						}

						$date = Carbon::today();
						$rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
						->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
								->select('rate')
								->first();
						if (!$rate) {
							// rate note found
							Session::flash('message', "Zəhmət olmasa operatorla əlaqə saxlayın.");
							Session::flash('class', "page-failed");
							Session::flash('description', "Ödəniş balansa əlavə edilərkən xəta baş verdi. Ödəniş kodu: " . $payment_key);
							Session::flash('display', 'block');
							if ($payment_type == 'courier') {
								return redirect()->route("get_courier_page");
							} else if($payment_type == 'payment'){
								return redirect()->route("get_payment_page");
							}
							else {
								return redirect()->route("get_balance_page");
							}
						}
						$rate_to_azn = $rate->rate;

						if ($amount_azn == null) {
							$new_amount_azn = 0;
						} else {
							$new_amount_azn = $amount_azn / 100;
						}
						$new_amount = $new_amount_azn / $rate_to_azn;
						$new_amount = sprintf('%0.2f', $new_amount);

						$old_balance = $user_exist->balance;
						$new_balance = $old_balance + $new_amount;
						$new_balance = sprintf('%0.2f', $new_balance);
						// add to balance if not courier
						$payment_code = Str::random(20);
						$new_amount_azn = sprintf('%0.2f', $new_amount_azn);
						BalanceLog::create([
								'payment_code' => $payment_code,
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'status' => 'in',
								'type' => 'cart'
						]);

						if ($payment_type == 'courier') {
							if ($courier_packages != null && strlen($courier_packages) > 0) {
								$packages_arr = explode(',', $courier_packages);

								$packages = Package::whereIn('id', $packages_arr)
										->where('paid_status', 0)
										->select('id', 'total_charge_value as amount', 'paid', 'currency_id')
										->get();

								foreach ($packages as $package) {
									$package_amount = $package->amount - $package->paid;

									PaymentLog::create([
											'payment' => $package_amount,
											'currency_id' => $package->currency_id,
											'client_id' => $user_id,
											'package_id' => $package->id,
											'type' => 3, // balance
											'created_by' => $user_id
									]);
								}

								Package::whereIn('id', $packages_arr)
										->update([
												'paid' => DB::raw("`total_charge_value`"),
												'paid_status' => 1,
												'payment_type_id' => 1, // online
												'courier_order_id' => $courier_order_id,
												'has_courier' => 1,
												'has_courier_by' => $user_id,
												'has_courier_at' => Carbon::now(),
												'has_courier_type' => 'user_millikart_' . $courier_order_id
										]);
							}

							$courier_order = CourierOrders::where('id', $courier_order_id)->select('amount')->first();

							CourierOrders::where('id', $courier_order_id)
									->update([
											'paid' => $courier_order->amount,
											'is_paid' => 1,
											'payment_key' => $payment_key
									]);

							PaymentLog::create([
									'payment' => $courier_order->amount,
									'currency_id' => 3, // azn
									'client_id' => $user_id,
									'package_id' => $courier_order_id,
									'is_courier_order' => 1, // 1 - yes, 2- no
									'type' => 3, // balance
									'created_by' => $user_id
							]);

							$payment_code = Str::random(20);
							BalanceLog::create([
									'payment_code' => $payment_code,
									'amount' => $new_amount,
									'amount_azn' => $new_amount_azn,
									'client_id' => $user_id,
									'status' => 'out',
									'type' => 'courier'
							]);
						}else if ($payment_type == 'payment') {

							PartnerPaymentLog::create([
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'created_by' => $user_id,
							]);

							$payment_code = Str::random(20);
							BalanceLog::create([
									'payment_code' => $payment_code,
									'amount' => $new_amount,
									'amount_azn' => $new_amount_azn,
									'client_id' => $user_id,
									'status' => 'out',
									'type' => 'payment'
							]);

						} else {
							User::where('id', $user_id)->update(['balance' => $new_balance]);
						}
					} else {
						Session::flash('message', "Zəhmət olmasa operatorla əlaqə saxlayın.");
						Session::flash('class', "page-failed");
						Session::flash('description', "Ödəniş balansa əlavə edilərkən xəta baş verdi. Ödəniş kodu: " . $payment_key);
						Session::flash('display', 'block');
						if ($payment_type == 'courier') {
							return redirect()->route("get_courier_page");
						} else if($payment_type == 'payment'){
							return redirect()->route("get_payment_page");
						}
						else {
							return redirect()->route("get_balance_page");
						}
					}
				} else {
					$class = "page-failed";
					$message = "Zəhmət olmasa yenidən cəhd edin!";
				}

				Session::flash('message', $message);
				Session::flash('class', $class);
				Session::flash('description', $code_description);
				Session::flash('display', 'block');
				if ($payment_type == 'courier') {
					return redirect()->route("get_courier_page");
				} else if($payment_type == 'payment'){
					return redirect()->route("get_payment_page");
				}
				else {
					return redirect()->route("get_balance_page");
				}
			} else {
				Log::channel('balance_log')->emergency('error', ['payment_key' => $payment_key, 'place' => 'if ($payment_task)else{} ', 'error text' => '$payment_task = false']);
				Session::flash('message', "Zəhmət olmasa yenidən cəhd edin!");
				Session::flash('class', "page-failed");
				Session::flash('description', "Ödəniş edilərkən səhv baş verdi!");
				Session::flash('display', 'block');
				return redirect()->route("get_balance_page");
			}
		} catch (\Exception $exception) {
			Log::error($exception);
			$payment_key = $request->input("reference") || 'empty';
			Log::channel('millikart_callback')->emergency('error', ['payment_key' => $payment_key, 'place' => 'catch', 'error text' => $exception]);
			Session::flash('message', "Zəhmət olmasa yenidən cəhd edin!");
			Session::flash('class', "page-failed");
			Session::flash('description', "Ödəniş edilərkən səhv baş verdi!");
			Session::flash('display', 'block');
			return redirect()->route("get_balance_page");
		}
	}

	public function callback_paytr()
	{
		$post = $_POST;

		$merchant_key = '1XFsb51gWB4sCAq3';
		$merchant_salt = 'xBfZx49J8TnYx9Zt';
		#
		## POST değerleri ile hash oluştur.
		$hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));

		if ($hash != $post['hash']) {
			die('PAYTR notification failed: bad hash');
		}

		$payment_key = $post['merchant_oid'];

		$payment_task = PaymentTask::where('payment_key', $payment_key)->select('id', 'status')->orderBy('id', 'desc')->first();
		if (!$payment_task) {
			die('Notification failed: bad payment');
		}

		$payment_id = $payment_task->id;
		$payment_status = $payment_task->status;

		if ($payment_status == 1) {
			echo "OK";
			exit;
		}

		if ($post['status'] == 'success') {
			// success pay
			PaymentTask::where('id', $payment_id)->update([
					'status' => 1,
					'is_paid' => 1,
					'amount' => $post['payment_amount'],
					'response_str' => implode('|', $post)
			]);
			$amount = $post['payment_amount'] / 100;

			$order_payments = SpecialOrderPayments::where('payment_key', $payment_key)->orderBy('id', 'desc')->select('id', 'order_id')->first();
			if ($order_payments) {
				$order_id = $order_payments->order_id;

				$order = SpecialOrderGroups::where('id', $order_id)->orderBy('id', 'desc')->select('id', 'price', 'common_debt', 'cargo_debt', 'client_id', 'country_id')->first();

				$cargo_debt = (float)$order->cargo_debt;
				$common_debt = (float)$order->common_debt;

				SpecialOrderGroups::where('id', $order_id)->update([
						'is_paid' => 1,
						'paid' => $order->price,
						'paid_at' => Carbon::now(),
						'cargo_debt' => 0,
						'common_debt' => 0
				]);

				if ($cargo_debt > 0 || $common_debt > 0) {
					$client = User::where('id', $order->client_id)->select('cargo_debt', 'common_debt')->first();
					if ($client) {
						$client_old_cargo_debt = (float)$client->cargo_debt;
						$client_new_cargo_debt = $client_old_cargo_debt - $cargo_debt;
						$client_new_cargo_debt = sprintf('%0.2f', $client_new_cargo_debt);
						if ($client_new_cargo_debt < 0) {
							$client_new_cargo_debt = 0;
						}
						$client_old_common_debt = (float)$client->common_debt;
						$client_new_common_debt = $client_old_common_debt - $common_debt;
						$client_new_common_debt = sprintf('%0.2f', $client_new_common_debt);
						if ($client_new_common_debt < 0) {
							$client_new_common_debt = 0;
						}
						User::where('id', $order->client_id)->update([
								'cargo_debt' => $client_new_cargo_debt,
								'common_debt' => $client_new_common_debt
						]);
						DebtsLog::create([
								'type' => 'out',
								'client_id' => $order->client_id,
								'order_id' => $order_id,
								'cargo' => $cargo_debt,
								'common' => $common_debt,
								'old_cargo' => $client_old_cargo_debt,
								'old_common' => $client_old_common_debt,
								'new_cargo' => $client_new_cargo_debt,
								'new_common' => $client_new_common_debt,
								'created_by' => $order->client_id
						]);
						SpecialOrderStatus::create([
								'order_id' => $order_id,
								'status_id' => 28 //paid debt
						]);
					}
				} else {
					SpecialOrderStatus::create([
							'order_id' => $order_id,
							'status_id' => 2 //paid
					]);
				}

				SpecialOrderPayments::where('id', $order_payments->id)->update(['paid' => 1]);

				$email = EmailListContent::where(['type' => 'sp_ord_paid_bycustomer'])->first();

				if ($email) {
					$user = User::where('id', $order->client_id)->first();

					$client = $user->name . ' ' . $user->surname;
					$lang = strtolower($user->language);

					$country = Country::where('id', $order->country_id)->select('countries.name_' . $lang . ' as name')->first();
					if ($country) {
						$country_name = $country->name;
					} else {
						$country_name = '';
					}

					$now = Carbon::now();
					$date = substr($now, 0, 16);

					$email_title = $email->{'title_' . $lang}; //from
					$email_subject = $email->{'subject_' . $lang};
					$email_bottom = $email->{'content_bottom_' . $lang};
					$email_button = $email->{'button_name_' . $lang};
					$email_content = $email->{'content_' . $lang};

					$email_subject = str_replace('{country_name}', $country_name, $email_subject);

					$email_content = str_replace('{name_surname}', $client, $email_content);
					$email_content = str_replace('{amount}', $amount . ' TRY', $email_content);
					$email_content = str_replace('{date}', $date, $email_content);

					$user->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom, $email_button));
				}
			}
		} else {
			PaymentTask::where('id', $payment_id)->update([
					'status' => 1,
					'is_paid' => 0,
					'response_code' => $post['failed_reason_code'],
					'response_code_description' => $post['failed_reason_msg'],
					//'amount' => $post['payment_amount'],
					'response_str' => implode('|', $post)
			]);
		}

		## Bildirimin alındığını PayTR sistemine bildir.
		echo "OK";
		exit;
	}

	public function callback_pashaBank_special(Request $req)
	{
		try{
			$trans_id = $req->input('trans_id');
			if (!isset($trans_id) || empty($trans_id) && !is_string($trans_id)) return;
	
			$payment_task = PaymentTask::where(['payment_key' => $trans_id, 'type' => 'pasha', 'status' => 0])
				->orderBy('id', 'desc')
				->select('id', 'payment_type', 'order_id', 'packages', 'amount', 'created_by', 'is_api')
				->first();
			
			$baseUrl = 'https://azercargo.az';
	
			$payment_id = $payment_task->id;
			$payment_status = $payment_task->status;
			$country_id = null;
	
	
			if ($payment_task) {
				// success pay
				$payment_id = $payment_task->id;
				$payment_type = $payment_task->payment_type; // balance or courier or payment to partner
				$courier_order_id = $payment_task->order_id; // for courier
				$courier_packages = $payment_task->packages; // for courier
				$amount = $payment_task->amount / 100;
				$paymentDetails = $this->getPaymentDetailsSpecial($trans_id);
	
	            //dd($paymentDetails);
				$paymentStatus = $paymentDetails;
				$payment_user_id = $payment_task->created_by;
				$code_description = null;
				$res_code = null;
				$code_control = false;
				$rc_description = null;
				$res_rc = null;
				$rc_control = false;
				if ($paymentStatus["RESULT"] == "OK") {
					switch ($paymentStatus['RESULT_CODE']) {
						case '000':
							{
								$rc_description = "Uğurlu əməliyyat";
								$res_rc = '000';
								$rc_control = true;
							}
							break;
						case '101':
							{
								$rc_description = "İmtina, istifadə müddəti bitmiş kart";
								$res_rc = '101';
							}
							break;
						case '102':
							{
								$rc_description = "İmtina, şübhəli fırıldaqçılıq";
								$res_rc = '102';
							}
							break;
						case '107':
							{
								$rc_description = "İmtina et, kart emitentinə müraciət et (adətən Kartı verən tərəfindən qaytarılır)";
								$res_rc = '107';
							}
							break;
						case '119':
							{
								$rc_description = "İmtina, kart sahibinə əməliyyata icazə verilmir";
								$res_rc = '119';
							}
							break;
						case '100':
							{
								$rc_description = "İmtina (Şərhsiz)";
								$res_rc = '100';
							}
							break;
						case '110':
							{
								$rc_description = "İmtina (invalid amount)";
								$res_rc = '110';
							}
							break;
						case '111':
							{
								$rc_description = "İmtina (invalid card)";
								$res_rc = '111';
							}
							break;
						default:
						{
							$rc_description = "Bilinməyən xəta";
							$res_rc = $paymentStatus['RESULT_CODE'];
						}
					}
				}
	
				$is_paid = 0;
				if ($rc_control) {
					// paid successfully
					$is_paid = 1;
				}
	
				$pan = null; //cart number
				if (isset($paymentStatus['CARD_NUMBER'])) {
					$pan = $paymentStatus['CARD_NUMBER'];
				}
                
                PaymentTask::where('id', $payment_id)->update([
                    'status' => 1,
                    'is_paid' => $is_paid,
                    'pan' => $pan,
                    //'response_code' =>$res_rc,
                    'response_code_description' => $rc_description,
                    'response_rc' => $res_rc,
                    'response_rc_description' => $rc_description,
                    'response_str' => json_encode((array)$paymentStatus)
                ]);
                
				if ($is_paid == 1) {
                    
                    $class = "page-success";
                    $message = "Təşəkkür edirik!";
                    
                    $order_payments = SpecialOrderPayments::where('payment_key', $trans_id)->orderBy('id', 'desc')->select('id', 'order_id')->first();
                    //dd($order_payments);
					if ($order_payments) {
						$order_id = $order_payments->order_id;
		
						$order = SpecialOrderGroups::where('id', $order_id)->orderBy('id', 'desc')->select('id', 'price', 'common_debt', 'cargo_debt', 'client_id', 'country_id')->first();
		                $country_id = $order->country_id;
                        //dd($order);
						$cargo_debt = (float)$order->cargo_debt;
						$common_debt = (float)$order->common_debt;
		
						SpecialOrderGroups::where('id', $order_id)->update([
								'is_paid' => 1,
								'paid' => $order->price,
								'paid_at' => Carbon::now(),
								'cargo_debt' => 0,
								'common_debt' => 0
						]);
		
						if ($cargo_debt > 0 || $common_debt > 0) {
							$client = User::where('id', $order->client_id)->select('cargo_debt', 'common_debt')->first();
							if ($client) {
								$client_old_cargo_debt = (float)$client->cargo_debt;
								$client_new_cargo_debt = $client_old_cargo_debt - $cargo_debt;
								$client_new_cargo_debt = sprintf('%0.2f', $client_new_cargo_debt);
								if ($client_new_cargo_debt < 0) {
									$client_new_cargo_debt = 0;
								}
								$client_old_common_debt = (float)$client->common_debt;
								$client_new_common_debt = $client_old_common_debt - $common_debt;
								$client_new_common_debt = sprintf('%0.2f', $client_new_common_debt);
								if ($client_new_common_debt < 0) {
									$client_new_common_debt = 0;
								}
								User::where('id', $order->client_id)->update([
										'cargo_debt' => $client_new_cargo_debt,
										'common_debt' => $client_new_common_debt
								]);
								DebtsLog::create([
										'type' => 'out',
										'client_id' => $order->client_id,
										'order_id' => $order_id,
										'cargo' => $cargo_debt,
										'common' => $common_debt,
										'old_cargo' => $client_old_cargo_debt,
										'old_common' => $client_old_common_debt,
										'new_cargo' => $client_new_cargo_debt,
										'new_common' => $client_new_common_debt,
										'created_by' => $order->client_id
								]);
								SpecialOrderStatus::create([
										'order_id' => $order_id,
										'status_id' => 28 //paid debt
								]);
							}
						} else {
							SpecialOrderStatus::create([
									'order_id' => $order_id,
									'status_id' => 2 //paid
							]);
						}
		
						SpecialOrderPayments::where('id', $order_payments->id)->update(['paid' => 1]);
		
						$email = EmailListContent::where(['type' => 'sp_ord_paid_bycustomer'])->first();
		
						if ($email) {
							$user = User::where('id', $order->client_id)->first();
		
							$client = $user->name . ' ' . $user->surname;
							$lang = strtolower($user->language);
		
							$country = Country::where('id', $order->country_id)->select('countries.name_' . $lang . ' as name')->first();
							if ($country) {
								$country_name = $country->name;
							} else {
								$country_name = '';
							}
		
							$now = Carbon::now();
							$date = substr($now, 0, 16);
		
							$email_title = $email->{'title_' . $lang}; //from
							$email_subject = $email->{'subject_' . $lang};
							$email_bottom = $email->{'content_bottom_' . $lang};
							$email_button = $email->{'button_name_' . $lang};
							$email_content = $email->{'content_' . $lang};
		
							$email_subject = str_replace('{order_id}', $order->id, $email_subject);
		
							$email_content = str_replace('{name_surname}', $client, $email_content);
							$email_content = str_replace('{amount}', $amount . ' AZN', $email_content);
							$email_content = str_replace('{date}', $date, $email_content);
		
							$user->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom, $email_button));
						}
                        
					}
				}else{
                    $class = "page-failed";
                    $message = "Zəhmət olmasa yenidən cəhd edin!";
                }
                
                $status = $class;
                
                Session::flash('message', $message);
                Session::flash('class', $class);
                Session::flash('description', $code_description);
                Session::flash('display', 'block');
                if($payment_task->is_api){
                    if($status=="page-success"){
                        return redirect("asercargo://app/payment/success");
                    }else{
                        return redirect("asercargo://app/payment/error");
                    }
                    $url = $baseUrl . '?status=' . $status . '&trans_id=' . $trans_id;
                    return response()->json([
                        'class'=>$class,
                        'url' => $url
                    ]);
                }
				return redirect("https://asercargo.az/".App::getLocale()."/account/special-order");
                return redirect()->route("special_order_select");
				
			} 
		}catch(\Exception $exception){
			Log::error($exception);
			$payment_key = $req->input("reference") || 'empty';
			Log::channel('millikart_callback')->emergency('error', ['payment_key' => $payment_key, 'place' => 'catch', 'error text' => $exception]);
			Session::flash('message', "Zəhmət olmasa yenidən cəhd edin!");
			Session::flash('class', "page-failed");
			Session::flash('description', "Ödəniş edilərkən səhv baş verdi!");
			Session::flash('display', 'block');
			return redirect("https://asercargo.az/".App::getLocale()."/account/special-order");
			return redirect()->route("special_order_select");
		}
	
		
	}

    public function callback_pashaBank(Request $req)
    {
		try{
			$trans_id = $req->input('trans_id');
			if (!isset($trans_id) || empty($trans_id) && !is_string($trans_id)) return;
	
			$payment_task = PaymentTask::where(['payment_key' => $trans_id, 'type' => 'pasha', 'status' => 0])
				->orderBy('id', 'desc')
				->select('id', 'payment_type', 'order_id', 'packages', 'amount', 'created_by', 'is_api')
				->first();
            
            $baseUrl = 'https://azercargo.az';
            /*$payment_user_id = $payment_task->created_by;
            $payment_id = $payment_task->id;
            $payment_type = $payment_task->payment_type; // balance or courier or payment to partner
            $courier_order_id = $payment_task->order_id; // for courier
            $courier_packages = $payment_task->packages; // for courier*/
			if($payment_task)
			{

				$payment_id = $payment_task->id;
				$payment_type = $payment_task->payment_type; // balance or courier or payment to partner
				$courier_order_id = $payment_task->order_id; // for courier
				$courier_packages = $payment_task->packages; // for courier
	
				$paymentDetails = $this->getPaymentDetails($trans_id);
	
	
				$paymentStatus = $paymentDetails;
				$payment_user_id = $payment_task->created_by;
				$code_description = null;
				$res_code = null;
				$code_control = false;
				$rc_description = null;
				$res_rc = null;
				$rc_control = false;
				if ($paymentStatus["RESULT"] == "OK") {
					switch ($paymentStatus['RESULT_CODE']) {
						case '000':
							{
								$rc_description = "Uğurlu əməliyyat";
								$res_rc = '000';
								$rc_control = true;
							}
							break;
						case '101':
							{
								$rc_description = "İmtina, istifadə müddəti bitmiş kart";
								$res_rc = '101';
							}
							break;
						case '102':
							{
								$rc_description = "İmtina, şübhəli fırıldaqçılıq";
								$res_rc = '102';
							}
							break;
						case '107':
							{
								$rc_description = "İmtina et, kart emitentinə müraciət et (adətən Kartı verən tərəfindən qaytarılır)";
								$res_rc = '107';
							}
							break;
						case '119':
							{
								$rc_description = "İmtina, kart sahibinə əməliyyata icazə verilmir";
								$res_rc = '119';
							}
							break;
						case '100':
							{
								$rc_description = "İmtina (Şərhsiz)";
								$res_rc = '100';
							}
							break;
						case '110':
							{
								$rc_description = "İmtina (invalid amount)";
								$res_rc = '110';
							}
							break;
						case '111':
							{
								$rc_description = "İmtina (invalid card)";
								$res_rc = '111';
							}
							break;
						default:
						{
							$rc_description = "Bilinməyən xəta";
							$res_rc = $paymentStatus['RESULT_CODE'];
						}
					}
				}
	
				$is_paid = 0;
				if ($rc_control) {
					// paid successfully
					$is_paid = 1;
				}
	
				$pan = null; //cart number
				if (isset($paymentStatus['CARD_NUMBER'])) {
					$pan = $paymentStatus['CARD_NUMBER'];
				}
				

				PaymentTask::where('id', $payment_id)->update([
					'status' => 1,
					'is_paid' => $is_paid,
					'pan' => $pan,
					//'response_code' =>$res_rc,
					'response_code_description' => $rc_description,
					'response_rc' => $res_rc,
					'response_rc_description' => $rc_description,
					'response_str' => json_encode((array)$paymentStatus)
				]);
                //$is_paid = 1;
				if ($is_paid == 1) {
     
					$class = "page-success";
					$message = "Təşəkkür edirik!";
	
					$user_id = $payment_user_id;
					
						$user_query = User::where('id', $user_id);
						$user_exist = $user_query->select('balance')->first();
						$user_for_api = $user_query->get();
	
						if (!$user_exist) {
							$user_id = 0;
						}
						if ($user_id == 0) {
							Session::flash('message', "Zəhmət olmasa operatorla əlaqə saxlayın.");
							Session::flash('class', "page-failed");
							Session::flash('description', "Ödəniş balansa əlavə edilərkən xəta baş verdi. Ödəniş kodu: " . $trans_id);
							Session::flash('display', 'block');
							if ($payment_type == 'courier') {
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("/az/account/courier");
							} else if($payment_type == 'payment'){
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("/az/account/balance");
							}
							else if($payment_type == 'packages'){
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("/az/account/orders");
							}
							else {
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("/az/account/balance");
							}
						}
						$user=User::find($user_id);
						$date = Carbon::today();
						$rate = ExchangeRate::where(['from_currency_id' => 1, 'to_currency_id' => 3]) // usd -> azn
						
						->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
							->select('rate')
							->first();
						if (!$rate) {
							// rate note found
							// Session::flash('message', "Zəhmət olmasa operatorla əlaqə saxlayın.");
							// Session::flash('class', "page-failed");
							// Session::flash('description', "Ödəniş balansa əlavə edilərkən xəta baş verdi. Ödəniş kodu: " . $trans_id);
							// Session::flash('display', 'block');
							if ($payment_type == 'courier') {
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("https://asercargo.az/".strtolower($user->language)."/account/courier");
								return redirect()->route("get_courier_page", ['locale' => $user->language]);
							} else if($payment_type == 'payment'){
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("https://asercargo.az/".strtolower($user->language)."/account/balance");
								return redirect()->route("get_payment_page", ['locale' => $user->language]);
							}
							else if($payment_type == 'packages'){
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("https://asercargo.az/".strtolower($user->language)."/account/orders");
								return redirect()->route("get_payment_page", ['locale' => $user->language]);
							}
							else {
                                if($payment_task->is_api){
                                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                                    return response()->json([
                                        'url' => $url
                                    ]);
                                }
								return redirect("https://asercargo.az/".strtolower($user->language)."/account/balance");
								return redirect()->route("get_balance_page", ['locale' => $user->language]);
							}
						}
						$rate_to_azn = $rate->rate;
						$amount_azn = $payment_task->amount;
						if ($amount_azn == null) {
							$new_amount_azn = 0;
						} else {
							$new_amount_azn = $amount_azn / 100;
						}
						$new_amount = $new_amount_azn / $rate_to_azn;
						$new_amount = sprintf('%0.2f', $new_amount);
	
						$old_balance = $user_exist->balance;
						$new_balance = $old_balance + $new_amount;
						$new_balance = sprintf('%0.2f', $new_balance);
						// add to balance if not courier
						$payment_code = Str::random(20);
						$new_amount_azn = sprintf('%0.2f', $new_amount_azn);
						BalanceLog::create([
							'payment_code' => $payment_code,
							'amount' => $new_amount,
							'amount_azn' => $new_amount_azn,
							'client_id' => $user_id,
							'status' => 'in',
							'type' => 'cart'
						]);
	
						if ($payment_type == 'courier') {
							if ($courier_packages != null && strlen($courier_packages) > 0) {
								$packages_arr = explode(',', $courier_packages);
	
								$packages = Package::whereIn('id', $packages_arr)
									->where('paid_status', 0)
									//->select('id', 'total_charge_value as amount', 'paid', 'currency_id')
									->get();
                                
                                $pay_for_currency = 0;
                                $pay_azn = 0;
                                $pay_usd = 0;
								foreach ($packages as $package) {
									//$package_amount = $package->amount - $package->paid;
	                               
                                    $result = $this->CalculatePaid($package);

                                    $pay_azn = $result['total_paid_azn'];
                                    $pay_usd = $result['total_paid_usd'];
                                    $pay_for_currency = $result['total_paid'];
            
                                    $total_pay = $result['pay'];
									PaymentLog::create([
										'payment' => $total_pay,
										'currency_id' => $package->currency_id,
										'client_id' => $user_id,
										'package_id' => $package->id,
                                        'is_courier_order' => 0,
										'type' => 3, // balance
										'created_by' => $user_id
									]);
								}
	                            //dd($packages);
								Package::whereIn('id', $packages_arr)
									->update([
                                        'paid' => $pay_for_currency,
                                        'paid_sum' => $pay_usd,
                                        'paid_azn' => $pay_azn,
										'paid_status' => 1,
										'payment_type_id' => 1, // online
										'courier_order_id' => $courier_order_id,
										'has_courier' => 1,
										'has_courier_by' => $user_id,
										'has_courier_at' => Carbon::now(),
										'has_courier_type' => 'user_pasha_' . $courier_order_id
									]);
							}
	
							$courier_order = CourierOrders::where('id', $courier_order_id)->select('amount')->first();
	
							CourierOrders::where('id', $courier_order_id)
								->update([
									'paid' => $courier_order->amount,
									'is_paid' => 1,
									'payment_key' => $trans_id
								]);
	
							PaymentLog::create([
								'payment' => $courier_order->amount,
								'currency_id' => 3, // azn
								'client_id' => $user_id,
								'package_id' => $courier_order_id,
								'is_courier_order' => 1, // 1 - yes, 2- no
								'type' => 3, // balance
								'created_by' => $user_id
							]);
	
							$payment_code = Str::random(20);
							BalanceLog::create([
								'payment_code' => $payment_code,
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'status' => 'out',
								'type' => 'courier'
							]);
						}
						else if ($payment_type == 'packages') {
							if ($courier_packages != null && strlen($courier_packages) > 0) {
								$packages_arr = explode(',', $courier_packages);
	
								$packages = Package::whereIn('id', $packages_arr)
									->where('paid_status', 0)
									//->select('id', 'total_charge_value as amount', 'paid', 'currency_id')
									->get();
                                
                                $pay_for_currency = 0;
                                $pay_azn = 0;
                                $pay_usd = 0;
								foreach ($packages as $package) {
									//$package_amount = $package->amount - $package->paid;
	                               
                                    $result = $this->CalculatePaid($package);

                                    $pay_azn = $result['total_paid_azn'];
                                    $pay_usd = $result['total_paid_usd'];
                                    $pay_for_currency = $result['total_paid'];
            
                                    $total_pay = $result['pay'];
									PaymentLog::create([
										'payment' => $total_pay,
										'currency_id' => $package->currency_id,
										'client_id' => $user_id,
										'package_id' => $package->id,
                                        'is_courier_order' => 0,
										'type' => 3, // balance
										'created_by' => $user_id
									]);
								}
	                            // dd($packages);
								Package::whereIn('id', $packages_arr)
									->update([
                                        'paid' => $pay_for_currency,
                                        'paid_sum' => $pay_usd,
                                        'paid_azn' => $pay_azn,
										'paid_status' => 1,
										'payment_type_id' => 1
									]);
							}
							$payment_code = Str::random(20);
							BalanceLog::create([
								'payment_code' => $payment_code,
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'status' => 'out',
								'type' => 'package'
							]);
	
							
						}
						else if ($payment_type == 'payment') {
	
							PartnerPaymentLog::create([
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'created_by' => $user_id,
							]);
	
							$payment_code = Str::random(20);
							BalanceLog::create([
								'payment_code' => $payment_code,
								'amount' => $new_amount,
								'amount_azn' => $new_amount_azn,
								'client_id' => $user_id,
								'status' => 'out',
								'type' => 'payment'
							]);
	
						}
						else {
							User::where('id', $user_id)->update(['balance' => $new_balance]);
						}
					
				} else {
					$class = "page-failed";
					$message = "Zəhmət olmasa yenidən cəhd edin!";
				}


                $status = $class;
				$user=User::find($payment_user_id);
				$lang=$user?$user->language:'az';
				// Session::flash('message', $message);
				// Session::flash('class', $class);
				// Session::flash('description', $code_description);
				// Session::flash('display', 'block');
				if ($payment_type == 'courier') {
                    if($payment_task->is_api){
                        if($status=="page-success"){
                            return redirect("asercargo://app/payment/success");
                        }else{
                            return redirect("asercargo://app/payment/error");
                        }
                        $url = $baseUrl . '?status=' . $status . '&trans_id=' . $trans_id;
                        return response()->json([
                            'class'=>$class,

                            'url' => $url
                        ]);
                    }
					return redirect("https://asercargo.az/".strtolower($lang)."/account/courier");
					return redirect()->route("get_courier_page", ['locale' => $lang]);
				} else if($payment_type == 'payment'){
                    if($payment_task->is_api){
                        if($status=="page-success"){
                            return redirect("asercargo://app/payment/success");
                        }else{
                            return redirect("asercargo://app/payment/error");
                        }
                        $url = $baseUrl . '?status=' . $status . '&trans_id=' . $trans_id;
                        return response()->json([
                            'class'=>$class,

                            'url' => $url
                        ]);
                    }
					return redirect("https://asercargo.az/".strtolower($lang)."/account/balance");
					return redirect()->route("get_payment_page", ['locale' => $lang]);
				}
				else if($payment_type == 'packages'){
                    if($payment_task->is_api){
                        if($status=="page-success"){
                            return redirect("asercargo://app/payment/success");
                        }else{
                            return redirect("asercargo://app/payment/error");
                        }
                        $url = $baseUrl . '?status=' . $status . '&trans_id=' . $trans_id;
                        return response()->json([
                            'class'=>$class,

                            'url' => $url
                        ]);
                    }
					return redirect("https://asercargo.az/".strtolower($lang)."/account/orders");
					return redirect()->route("get_payment_page", ['locale' => $lang]);
				}
				else {
                    if($payment_task->is_api){
                        if($status=="page-success"){
                            return redirect("asercargo://app/payment/success");
                        }else{
                            return redirect("asercargo://app/payment/error");
                        }
                        $url = $baseUrl . '?status=' . $status . '&trans_id=' . $trans_id;
                        return response()->json([
                            'class'=>$class,

                            'url' => $url
                        ]);
                    }
					return redirect("https://asercargo.az/".strtolower($lang)."/account/balance");
					return redirect("/$lang/account/balance");
					return redirect()->route("get_balance_page", ['locale' => $lang]);
				}
			}
			else
			{
				Log::channel('balance_log')->emergency('error', ['payment_key' => $trans_id, 'place' => 'if ($payment_task)else{} ', 'error text' => '$payment_task = false']);
				// Session::flash('message', "Zəhmət olmasa yenidən cəhd edin!");
				// Session::flash('class', "page-failed");
				// Session::flash('description', "Ödəniş edilərkən səhv baş verdi!");
				// Session::flash('display', 'block');
                if($payment_task->is_api){
                    $url = $baseUrl . '?status=' . 'page-failed' . '&trans_id=' . $trans_id;
                    return response()->json([
                        'url' => $url
                    ]);
                }
				return redirect("https://asercargo.az/az/account/balance");
				return redirect()->route("get_balance_page", ['locale' => 'az']);
			}
	
			
		}catch(Exception $exception){
			return redirect("https://asercargo.az/az/account/balance");
			return redirect("/az/account/balance");
			dd($exception);
		}
    }

    public static function getPaymentDetails($trans_id)
    {
        if (!isset($trans_id) || empty($trans_id) && !is_string($trans_id)) abort(403, 'Incorrect transaction id');

        $ca = "/var/www/sites/certificates/PSroot.pem";
        $key = "/var/www/sites/certificates/rsa_key_pair.pem";
        $cert = "/var/www/sites/certificates/certificate.0031686.pem";

        $merchant_handler = "https://ecomm.pashabank.az:18443/ecomm2/MerchantHandler";

        $errors = [];
        $paymentDetails = [];



        if (
            base64_encode(base64_decode($trans_id)) != $trans_id
        ) {
            abort(403, 'Incorrect transaction id');
        }

        $params['command'] = "C";
        $params['trans_id'] = $trans_id;

        if (filter_input(INPUT_SERVER, 'REMOTE_ADDR') != null) {
            $params['client_ip_addr'] = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        } elseif (filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR') != null) {
            $params['client_ip_addr'] =
                filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR');
        } elseif (filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP') != null) {
            $params['client_ip_addr'] = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP');
        } else {
            $params['client_ip_addr'] = "10.10.10.10";
        }

        $qstring = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $merchant_handler);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);
        curl_setopt($ch, CURLOPT_SSLCERT, $cert);
        curl_setopt($ch, CURLOPT_SSLKEY, $key);
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");
        //curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $password);
        curl_setopt($ch, CURLOPT_CAPATH, $ca);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $result = curl_exec($ch);

        // Example returning result:
        // RESULT: OK
        // RESULT_PS: FINISHED
        // RESULT_CODE: 000
        // 3DSECURE: ATTEMPTED
        // RRN: 123456789012
        // APPROVAL_CODE: 123456
        // CARD_NUMBER: 4***********9999
        // RECC_PMNT_ID: 1258
        // RECC_PMNT_EXPIRY: 1108
        // for debug reasons only!

        if (curl_error($ch)) array_push($errors, 'Payment error!');

        curl_close($ch);

		
        $r_hm = array();
        $r_arr = array();

        $r_arr = explode("\n", $result);

        for ($i = 0; $i < count($r_arr); $i++) {
            $param = explode(":", $r_arr[$i])[0];
            $value = substr(explode(":", $r_arr[$i])[1], 1);
            $r_hm[$param] = $value;
        }

		return $r_hm;
        // if ($r_hm["RESULT"] == "OK") {
        //     if ($r_hm["RESULT_CODE"] == "000") $paymentDetails['status'] = 'completed';
        //     else $paymentDetails['status'] = 'not_completed';
        // } elseif ($r_hm["RESULT"] == "FAILED") {
        //     if ($r_hm["RESULT_CODE"] == "116") $paymentDetails['status'] = 'insufficent_funds';
        //     elseif ($r_hm["RESULT_CODE"] == "129") $paymentDetails['status'] = 'card_expired';
        //     elseif ($r_hm["RESULT_CODE"] == "909") $paymentDetails['status'] = 'system_malfunction';
        //     else $paymentDetails['status'] = 'system_malfunction';
        // } elseif ($r_hm["RESULT"] == "TIMEOUT") $paymentDetails['status'] = 'timeout';
        // else $paymentDetails['status'] = 'system_malfunction';

        // if ($r_hm["RESULT"] == "FAILED") {
        //     // Log::info([
        //     //     'transaction_id' => $trans_id,
        //     //     'error_code' => $r_hm["RESULT_CODE"],
        //     //     'rrn' => $r_hm["RRN"]
        //     // ]);

		// 	Log::channel('millikart_callback')->emergency('error', 
		// 		[
		// 			'payment_key' => $trans_id, 
		// 			'error_code' => $r_hm["RESULT_CODE"],
        //         	'rrn' => $r_hm["RRN"]
		// 		]);
        // }


        //return ['trans_id' => $trans_id, 'errors' => $errors, 'paymentDetails' => $paymentDetails];
    }

	public static function getPaymentDetailsSpecial($trans_id)
    {
        if (!isset($trans_id) || empty($trans_id) && !is_string($trans_id)) abort(403, 'Incorrect transaction id');

        $ca = "/var/www/sites/certificates_special/PSroot.pem";
        $key = "/var/www/sites/certificates_special/rsa_key_pair.pem";
        $cert = "/var/www/sites/certificates_special/certificate.0032188.pem";

        $merchant_handler = "https://ecomm.pashabank.az:18443/ecomm2/MerchantHandler";

        $errors = [];
        $paymentDetails = [];


        if (
            base64_encode(base64_decode($trans_id)) != $trans_id
        ) {
            abort(403, 'Incorrect transaction id');
        }

        $params['command'] = "C";
        $params['trans_id'] = $trans_id;

        if (filter_input(INPUT_SERVER, 'REMOTE_ADDR') != null) {
            $params['client_ip_addr'] = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        } elseif (filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR') != null) {
            $params['client_ip_addr'] =
                filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR');
        } elseif (filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP') != null) {
            $params['client_ip_addr'] = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP');
        } else {
            $params['client_ip_addr'] = "10.10.10.10";
        }

        $qstring = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $merchant_handler);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);
        curl_setopt($ch, CURLOPT_SSLCERT, $cert);
        curl_setopt($ch, CURLOPT_SSLKEY, $key);
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");
        curl_setopt($ch, CURLOPT_CAPATH, $ca);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $result = curl_exec($ch);

        if (curl_error($ch)) array_push($errors, 'Payment error!');

        curl_close($ch);

		
        $r_hm = array();
        $r_arr = array();

        $r_arr = explode("\n", $result);

        for ($i = 0; $i < count($r_arr); $i++) {
            $param = explode(":", $r_arr[$i])[0];
            $value = substr(explode(":", $r_arr[$i])[1], 1);
            $r_hm[$param] = $value;
        }

		return $r_hm;
    }
    
    private function CalculatePaid($package){
        
        $amount = $package->total_charge_value;
        $amount_usd = $package->amount_usd;
        $amount_azn = $package->amount_azn;
        
        $paid = $package->paid;
        $paid_usd = $package->paid_sum;
        $paid_azn = $package->paid_azn;
        
        $currency_id = $package->currency_id;
        
        $external_w_debt_azn = $package->external_w_debt_azn;
        $external_w_debt_usd = $package->external_w_debt;
        $internal_w_debt_azn = $package->internal_w_debt;
        $internal_w_debt_usd = $package->internal_w_debt_usd;
        
        $allDebtUsd = $amount_usd + $internal_w_debt_usd + $external_w_debt_usd;
        $allDebtAzn = $amount_azn + $internal_w_debt_azn + $external_w_debt_azn;
        
        $pay_azn = $allDebtAzn - $paid_azn;
        $pay_azn = sprintf('%0.2f', $pay_azn);
        
        $pay_usd = $allDebtUsd - $paid_usd;
        $pay_usd = sprintf('%0.2f', $pay_usd);
        

        if ($currency_id != 1) { // currency != USD
            $rate = $this->GetExchangeRate(1, $currency_id);
            $calculate_rate = $rate;
            $pay = (($internal_w_debt_usd + $external_w_debt_usd) * $calculate_rate) + $amount;
            $pay = $pay - $paid;
            $pay = sprintf('%0.2f', $pay);
        }else{
            $pay = $pay_usd;
        }
        
        $total_paid = $paid + $pay;
        $total_paid_usd = $paid_usd + $pay_usd;
        $total_paid_azn = $paid_azn + $pay_azn;
        
        $total_paid = sprintf('%0.2f', $total_paid);
        
        $response = [
            'total_paid_azn' => $total_paid_azn,
            'total_paid_usd' => $total_paid_usd,
            'total_paid' => $total_paid,
            'pay' => $pay,
        ];
        
        return $response;
    }
    
    private function GetExchangeRate($from_currency_id, $to_currency_id = 1){
        $date = Carbon::today();
        $rate = ExchangeRate::whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->where(['from_currency_id' => $from_currency_id, 'to_currency_id' => $to_currency_id]) //to USD
            ->select('rate')
            ->orderBy('id', 'desc')
            ->first();
        
        if (!$rate) {
            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Rate not found!']);
        }
        return $rate->rate;
    }
}
