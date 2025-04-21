<?php

namespace App\Http\Controllers\Auth;

use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\LoginLog;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $date = Carbon::today();
        $rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
            ->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
            ->whereDate('exchange_rate.from_date', '<=', $date)
            ->whereDate('exchange_rate.to_date', '>=', $date)
            ->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
            ->orderBy('exchange_rate.id', 'desc')
            ->get();

        $general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru')->first();

        View::share(['exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]);
    }

    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            LoginLog::create([
                'user_id' => Auth::id(),
                'role_id' => Auth::user()->role(),
                'ip' => $request->ip(),
                'type' => 'login',
            ]);

//            $remember=$request->remember_me?true:false;
//
//            if(Auth::attempt($checkData,$remember)){

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function showLoginForm()
    {
        return view('web.login.index');
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            LoginLog::create([
                'user_id' => Auth::id(),
                'role_id' => Auth::user()->role(),
                'ip' => $request->ip(),
                'type' => 'logout',
            ]);
        }

        Auth::logout();

        if (!empty($request->get('del')) && $request->get('del') == 1) {
            Session::flash('message', 'Your account has been deleted!');
            Session::flash('class', 'danger');
            Session::flash('display', 'block');
        }

        return redirect('/login');
    }

    public function user_reset_password() {
        return view('front.reset_password');
    }
}
