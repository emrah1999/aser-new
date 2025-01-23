<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{

    public function getPhysicalRegister(){
        $errorType=null;
        return $errorType;
        return view('web.register.index',compact('errorType'));
    }

    public function getJuridicalRegister(){
        $errorType=null;
        return $errorType;
        return view('web.register.juridical',compact('errorType'));
    }

    public function getOTPRegister(){
        return view('web.register.otp');
    }
}