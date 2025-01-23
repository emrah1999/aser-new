<?php
    
    namespace App\Service;
    
    use App\BalanceLog;
    use App\CourierOrders;
    use App\ExchangeRate;
    use App\Package;
    use App\PaymentLog;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;

    class BulkPay
    {
        public function bulk_pay($request, $userID){
            try {
            
                $packages = Package::where('paid_status', 0)
                    ->whereIn('id', $request->package_ids)
                    ->where('client_id', $userID)
                    ->where('amount_usd', '>', 0)
                    ->whereNull('delivered_by')
                    ->whereNull('deleted_at')
                    ->distinct()
                    ->get();
                // dd($packages);
                if ($packages->count() == 0) {
                    return response(['case' => 'error', 'title' => 'Xəbərdarlıq!', 'content' => 'Bağlama tapılmadı. Bağlamaların borcu ödənib!']);
                }
            
            
            
                $amount_ceil = ceil($packages->sum('amount_usd') * 100) / 100;
                $external_w_debt = ceil($packages->sum('external_w_debt') * 100) / 100;
                $internal_w_debt = ceil($packages->sum('internal_w_debt_usd') * 100) / 100;
                $paid_usd = ceil($packages->sum('paid_sum') * 100) / 100;
                //$internal_w_debt_to_usd = $this->ExchangeRate(3, 1, $internal_w_debt);
            
                $total_amount_ceil = $amount_ceil + $external_w_debt + $internal_w_debt;
            
                $total_amount = number_format($total_amount_ceil, 2, '.', '');
                $total_amount = ceil(($total_amount - $paid_usd) * 100)/100;
            
                $user = User::where('id', $userID)->first();
                $user_balance_ceil = ceil($user->balance * 100) / 100;
                $debt_formatted = number_format($user_balance_ceil, 2, '.', '');
            
                if ($user->cargo_debt > 0 || $user->common_debt > 0) {
                    return response(['case' => 'error', 'title' => 'Xəbərdarlıq!', 'content' => 'Sizin sifariş et xidmətində borcunuz mövcuddur. Zəhmət olmasa öncə sifariş et xidmətinə keçid edərək borcu ödəyin.']);
                }
                if ($debt_formatted == 0) {
                
                    return response([
                        'case' => 'warning',
                        'debt' => 0,
                        'amount_paid' => $total_amount,
                        'title' => 'Xəbərdarlıq!',
                        'content' => 'Balansınızda məbləğ yoxdur! Zəhmət olmasa balansınızı artırın']);
                }
            
                if ($total_amount > $debt_formatted)
                {
                    $missing_amount = $total_amount - $user->balance;
                    $rounded_amount = ceil($missing_amount * 100) / 100;
                    $formatted_amount = number_format($rounded_amount, 2, '.', '');
                    //dd($formatted_amount, $missing_amount, $total_amount, $user->balance);
                    return response([
                        //'url' => '',
                        'case' => 'warning',
                        'title' => 'Oops!',
                        'amount_paid' => 'Ümumi məbləğ '. $total_amount .' ',
                        'balance' => 'Balans '. $debt_formatted.' ',
                        'debt' => $formatted_amount,
                        'currency' => 'USD',
                        'content' => 'Hesabda yetərli qədər balans yoxdur. Zəhmət olmasa balansınızı artırın'
                    ]);
                }
                else
                {
                    $total_pay = 0;
                    foreach ($packages as $package) {
                    
                        $result = $this->CalculatePaid($package);
                        $pay = $result['pay_usd'];
                        $total_pay += $pay;
                    
                    }
                
                    $new_balance = $debt_formatted - $total_pay;
                    User::where('id', $user->id)->update(['balance' => $new_balance]);
                    return response(['case' => 'success', 'title' => 'Paid!', 'content' => 'Ödəniş uğurla başa çatdırıldı!']);
                }
            
            }catch (Exception $exception){
                //dd($exception);
                return \response( 'Error');
            }
        }
    
    
        private function ExchangeRate($from, $to, $amount)
        {
            $date = Carbon::today();
            $rate = ExchangeRate::where(['from_currency_id' => $from, 'to_currency_id' => $to])
                ->whereDate('from_date', '<=', $date)->whereDate('to_date', '>=', $date)
                ->select('rate')
                ->first();
        
            if (!$rate) {
                $pay = 0;
            } else {
                $pay = $amount * $rate->rate;
            }
            $pay = sprintf('%0.2f', $pay);
        
            return $pay;
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
    
        private function CalculatePaid($package){
        
            $user_id = $package->client_id;
            $package_id = $package->id;
        
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
        
            $calculate_rate = 1;
            $pay = 0;
            if ($currency_id != 1) { // currency != USD
                $rate = $this->GetExchangeRate(1, $currency_id);
                $calculate_rate = $rate;
                $pay = (($internal_w_debt_usd + $external_w_debt_usd) * $calculate_rate) + $amount;
                $pay = $pay - $paid;
                $pay = sprintf('%0.2f', $pay);
            }else{
                $pay = $pay_usd;
            }
        
            $paid_status = 1;
            $total_paid = $paid + $pay;
            $total_paid_usd = $paid_usd + $pay_usd;
            $total_paid_azn = $paid_azn + $pay_azn;
        
            PaymentLog::create([
                'payment' => $pay,
                'currency_id' => $currency_id,
                'client_id' => $package->client_id,
                'package_id' => $package->id,
                'type' => 3, // balance
                'created_by' => $user_id
            ]);
        
        
            $total_paid = sprintf('%0.2f', $total_paid);
            //dd($total_paid, $no_paid, $paid, $pay);
            Package::where('id', $package_id)
                ->update([
                    'paid' => $total_paid,
                    'paid_sum' => $total_paid_usd,
                    'paid_azn' => $total_paid_azn,
                    'paid_status' => $paid_status,
                    'payment_type_id' => 1 // online
                ]);
        
            $payment_code = Str::random(20);
            BalanceLog::create([
                'payment_code' => $payment_code,
                'amount' => $pay_usd,
                'amount_azn' => $pay_azn,
                'client_id' => $user_id,
                'status' => 'out',
                'type' => 'balance'
            ]);
        
            if ($package->courier_order_id != null) {
                $courier_order_id = $package->courier_order_id;
                $courier_order = CourierOrders::where('id', $courier_order_id)
                    ->select('delivery_amount', 'total_amount')
                    ->first();
            
                if ($courier_order) {
                    $old_delivery_amount = $courier_order->delivery_amount;
                    $old_total_amount = $courier_order->total_amount;
                
                    $new_delivery_amount = $old_delivery_amount - $pay_azn;
                    $new_delivery_amount = sprintf('%0.2f', $new_delivery_amount);
                    if ($new_delivery_amount < 0) {
                        $new_delivery_amount = 0;
                    }
                
                    $new_total_amount = $old_total_amount - $pay_azn;
                    $new_total_amount = ceil($new_total_amount *100)/100;
                    if ($new_total_amount < 0) {
                        $new_total_amount = 0;
                    }
                
                    $courier_order_update_arr = array();
                    $courier_order_update_arr['delivery_amount'] = $new_delivery_amount;
                    $courier_order_update_arr['total_amount'] = $new_total_amount;
                
                    if ($new_delivery_amount == 0) {
                        $courier_order_update_arr['delivery_payment_type_id'] = 1; // online
                    }
                
                    CourierOrders::where('id', $courier_order_id)->update($courier_order_update_arr);
                }
            }
        
            $response = [
                'pay_azn' => $pay_azn,
                'pay_usd' => $pay_usd,
            ];
        
            return $response;
        }
    }