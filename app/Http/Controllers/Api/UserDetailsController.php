<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

    public function change_password(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required','min:8'],
            'confirm_password' => ['required','min:8','same:new_password']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()],422);
        }
        $user = User::find($this->userID);



        if (!Hash::check($request->old_password , $user->password)){

            return response()->json([
                'status'=>false,
                'message' => 'Old password is incorrect'
            ],400);
            
        }

        if (!($request->new_password==$request->confirm_password)){
            return response()->json([ 'status'=>false,'message'=>'New password and confirm password is incorrect'],400);
        }
        User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'status'=>true,
            'message'=>'Password changed successfully'
        ]);
    }
    public function user_details(Request $request){
        $user = User::where('id', $this->userID)
            ->whereNull('deleted_at')
            ->select('id', 'name', 'surname', 'email', 'passport_series','passport_number', 'passport_fin', 'language', 'birthday', 'address1', 'phone1', 'phone2', 'city', 'gender', 'balance', 'is_legality', 'is_partner', 'image', 'read_notification_count','branch_id')
            ->first();

        return response([
            'user' => $user, 
            'suit' => 'AS'.Auth::user()->suite()]);
    }
}
