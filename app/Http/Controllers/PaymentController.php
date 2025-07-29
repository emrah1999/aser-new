<?php

namespace App\Http\Controllers;

use App\Service\AzerCardService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request){
        $order = [
            'id'            => substr(microtime(), 2, 8),
            'amount'        => '0.1',
            'description'   => '3D Secure Test',
            'merchant_id'   => time(),
            'customer_name' => 'Emrah Eyyubov',
            'currency'      => 'AZN',
            'email'         => 'amrahayyubov1907@gmail.com',
            'phone'         =>"513121698"
        ];
        $service=new AzerCardService();
        $data = $service->buildPaymentData($order);
        return view('web.payment.payment', compact('data'));
    }
}
