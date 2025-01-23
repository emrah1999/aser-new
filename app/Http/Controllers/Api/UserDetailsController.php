<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
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


    public function user_details(Request $request){
        $user = User::where('id', $this->userID)
            ->whereNull('deleted_at')
            ->select('id', 'name', 'surname', 'email', 'passport_series','passport_number', 'passport_fin', 'language', 'birthday', 'address1', 'phone1', 'phone2', 'city', 'gender', 'balance', 'is_legality', 'is_partner', 'image', 'read_notification_count')
            ->first();

        return response([
            'user' => $user, 
            'suit' => 'AS'.Auth::user()->suite()]);
    }
}
