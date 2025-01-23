<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    private $userID;
    private $api = false;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {

            if ($request->get('api')) {
                App::setlocale($request->get('apiLang') ?? 'en');
                $this->userID = $request->get('user_id');
                $this->api = true;
                if (Auth::guest()) {
                    $user = User::find($this->userID);
                    Auth::login($user);
                }
            } else {
                $this->userID = Auth::id();
            }
            return $next($request);
        });
    }

    public function saveToken(Request $request)
    {
        try{
            $fcm_token = User::where('id', $this->userID)->first();
     
            if($fcm_token->fcm_token != $request->fcm_token || $fcm_token->fcm_token == null){
                $fcm_token->update(['fcm_token'=>$request->fcm_token]);
                return response()->json([
                    'title' => 'token saved successfully.',
                    'fcm_token' => $request->fcm_token
                ]);
            }else{
                return response()->json([
                    'title' => 'token is same.',
                    'fcm_token' => $fcm_token->fcm_token
                ]);
            }
        }catch(Exception $e){
            return $e;
        }
    }

}
