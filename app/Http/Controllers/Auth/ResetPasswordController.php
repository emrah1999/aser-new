<?php

namespace App\Http\Controllers\Auth;

use App\EmailListContent;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Notifications\Emails;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    public function showResetForm(Request $request, $token = null)
    {
        $date = Carbon::today();
        $rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
            ->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
            ->whereDate('exchange_rate.from_date', '<=', $date)
            ->whereDate('exchange_rate.to_date', '>=', $date)
            ->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
            ->orderBy('exchange_rate.id', 'desc')
            ->get();

        $general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru')->first();

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($response == Password::PASSWORD_RESET) {
            $email = EmailListContent::where(['type' => 'password_changed'])->first();

            if ($email) {
                $client = Auth::user()->full_name();
                $lang = strtolower(Auth::user()->language());

                $email_title = $email->{'title_' . $lang}; //from
                $email_subject = $email->{'subject_' . $lang};
                $email_bottom = $email->{'content_bottom_' . $lang};
                $email_content = $email->{'content_' . $lang};

                $email_content = str_replace('{name_surname}', $client, $email_content);

                $request->user()->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom));
            }

            return $this->sendResetResponse($request, $response);
        } else {
            return $this->sendResetFailedResponse($request, $response);
        }
    }
}
