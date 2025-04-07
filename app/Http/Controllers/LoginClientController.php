<?php

namespace App\Http\Controllers;

use App\TokensForLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginClientController extends Controller
{

    public function index()
    {
        return view('web.login.index');
    }
    public function login(Request $request,$token) {
        try {
            $token=$request->token;
            $token_control = TokensForLogin::where('token', $token)
                ->where('created_time', '>', time()-60)
                ->orderBy('id', 'desc')
                ->select('client_id')
                ->first();

            if (!$token_control) {
                return redirect("https://asercargo.az/az");
                return redirect()->route("home_page");
            }

            if (Auth::loginUsingId($token_control->client_id)) {
                return redirect("https://asercargo.az/az/account");
                return redirect()->route("get_account");
            } else {
                return redirect("https://asercargo.az/az");
                return redirect()->route("home_page");
            }
        } catch (\Exception $exception) {
            return view('front.error');
        }
    }
}
