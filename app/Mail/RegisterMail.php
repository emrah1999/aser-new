<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_name;
    public $otp;

    public function __construct($customer_name, $otp)
    {
        $this->customer_name = $customer_name;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP Code')
            ->view('emails.register')
            ->with([
                'customer_name' => $this->customer_name,
                'otp' => $this->otp,
            ]);
    }
}
