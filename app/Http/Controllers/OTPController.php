<?php

namespace App\Http\Controllers;

use App\EmailListContent;
use App\Notifications\Emails;
use App\OTP;
use App\SellerOtp;
use App\Service\SendOTPCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class OTPController extends Controller
{
    public function index( $locale,$otp_session,$otpType)
    {
        $otp_session = $otp_session;
        return view('web.register.otp', compact('otp_session','otpType'));
    }
    
    public function verifyOtp(Request $request, $locale){
        //dd($request->otp_full);
//        return $request;
        $validator = Validator::make($request->all(), [
            'otp_full' => ['required', 'string', 'max:6']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'OTP kodunda səhvlik var yenidən cəhd edin' . '!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
    
        try {
        
            $otp = OTP::where('otp', $request->otp_full)->where('is_verify', 0)->first();
            //dd($otp);
            if(is_null($otp)){
                return redirect()->back()->with('error', 'OTP kodunda səhvlik var yenidən cəhd edin');
            }
            
            $user = User::where('id', $otp->client_id)->whereNull('email_verified_at')->first();
            
            if(is_null($user)){
                return redirect()->back()->with('error', 'Bu istifadəçi ya mövcud deyil ya da artıq təsdiqlənib');
            }
            
            $otp->update([
                'is_verify' => 1,
            ]);
            
            $user->update([
                'email_verified_at' => Carbon::now()
            ]);
    
//            $email = EmailListContent::where(['type' => 'register_success'])->first();
//
//            if ($email) {
//                $client = $user->name . ' ' . $user->surname;
//                $lang = strtolower($user->language);
//
//                $email_title = $email->{'title_' . $lang}; //from
//                $email_subject = $email->{'subject_' . $lang};
//                $email_bottom = $email->{'content_bottom_' . $lang};
//                $email_content = $email->{'content_' . $lang};
//
//                $terms_link = 'https://asercargo.az/uploads/static/terms.pdf';
//
//                $email_content = str_replace('{name_surname}', $client, $email_content);
//                $email_content = str_replace('{after_link}', $terms_link, $email_content);
//
//                $user->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom));
//            }
            return redirect()->route("get_account", ['locale' => App::getLocale()]);
            /*return redirect()->route('get_account')->with([
                'case' => 'success',
                'title' => __('static.success'),
                'content' => __('register.success_message')
            ]);*/
        }catch (\Exception $e){
            dd($e);
            return 'Error';
        }
        
    }
    
    public function resendOtp(Request $request)
    {
        //dd($request->all());
        try {
    
            $otp = OTP::where('otp_session', $request->otp_session)->where('is_verify', 0)->first();

            $otpSentTime = $otp->created_at;
            $currentTime = Carbon::now();
    
            if ($currentTime->diffInSeconds($otpSentTime) < 120) {
                return response()->json(['success' => false, 'message' => '2 dəqiqə tamamlanmadan yeni OTP kodu tələb edilə bilməz.'], 429);
            }
    
            $otp_session = $this->generateRandomCode();
            $sendOtp = new SendOTPCode();
            $sendOtp->send_sms($otp->client_id, $request->phone1, $otp_session);
    
    
            return response()->json([
                'success' => true,
                'message' => 'OTP yenidən göndərildi',
                'otp_session' => $otp_session
            ]);
        }catch (\Exception $e){
            //dd($e);
            return 'Error';
        }
        
    }
    
    protected function generateRandomCode($length = 18) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomCode;
    }

    public function getOnayCodeList(Request $request){
        $data=[];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://onaykodu.bionet.az/api/trendyolsms-list?cargo_id=2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER=>0,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'X-Api-Key: BisFgRG9lIewerWFPostazeo0Ijcargo2MjMASDDIyS.xvbde'
                )
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response);
            if (is_array($response)) {
                $data=$response;
            }
            $date=date('d.m.Y H:i:s', strtotime('-3 minutes'));
            return view('web.account.onay_code',compact('data','date'));
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return view("front.error");
        }
    }

    public function getTrendyolOTP(){
        $data=[];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://onaykodu.bionet.az/api/trendyolsms-list?cargo_id=2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER=>0,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'X-Api-Key: BisFgRG9lIewerWFPostazeo0Ijcargo2MjMASDDIyS.xvbde'
                )
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response);
            if (is_array($response)) {
                $data=$response;
            }
            $date=date('d.m.Y H:i:s', strtotime('-3 minutes'));
            return  response()->json([
                'success' => true,
                'data' => $data,
                'date' => $date
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    public function getAmazonOTP(){

        $otp = SellerOtp::paginate(30);
        return response()->json([
            'success' => true,
            'data' => $otp
        ]);
    }

    public function reset(Request $request, $locale,$type=2)
    {
        if($locale=='1' || $locale=='2'){
            $type = (int) $locale;
        }

        if($type==2){
             $request->validate([
                'user_email' => 'required|email',
            ]);
            $user=User::where('email',$request->user_email)->first();

        }else{
            $user=User::where('phone1',$request->number)->first();
        }





        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Daxil etdiyiniz email ilə istifadəçi tapılmadı'
            ]);
        }
        $otp = OTP::where('client_id', $user->id)->where('is_verify', 0)->first();

        $otp_session = $this->generateRandomCode();
//        return $otp_session;
        $sendOtp = new SendOTPCode();
        if($type==2){
            $sendOtp->send_mail($user->id, $request->email, $otp_session);
        }else{
            $sendOtp->send_sms($user->id, $request->phone1, $otp_session);
        }

        return response()->json([
            'success' => true,
            'message'=>'otp gonderildi',
        ]);
    }

    public function verifyForgetOtp(Request $request)
    {
//        return $request;
        $validator = Validator::make($request->all(), [
            'full_otp' => ['required', 'string', 'max:6']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'OTP kodunda səhvlik var yenidən cəhd edin' . '!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        $otp = OTP::where('otp', $request->full_otp)->where('is_verify', 0)->first();
        //dd($otp);
//        return $otp;
        if(is_null($otp)){
            return redirect()->back()->with('error', 'OTP kodunda səhvlik var yenidən cəhd edin');
        }

        $user = User::where('id', $otp->client_id)->first();


        $otp->update([
            'is_verify' => 1,
        ]);

        $user->update([
            'email_verified_at' => Carbon::now()
        ]);
//        return 'aaa';

        return view('auth.passwords.resetPassoword',compact('user'));
    }


}
