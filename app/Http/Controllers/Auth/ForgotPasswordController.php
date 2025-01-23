<?php

namespace App\Http\Controllers\Auth;

use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset emails and
	| includes a trait which assists in sending these notifications from
	| your application to your users. Feel free to explore this trait.
	|
	*/

	use SendsPasswordResetEmails;

	public function showLinkRequestForm()
	{
		if (isset($status)) {
			return $status;
		}

		$date = Carbon::today();
		$rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
				->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
				->whereDate('exchange_rate.from_date', '<=', $date)
				->whereDate('exchange_rate.to_date', '>=', $date)
				->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
				->orderBy('exchange_rate.id', 'desc')
				->get();

		$general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru')->first();

		return view('web.login.reset')->with(['exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]);
	}

	public function sendResetLinkEmail(Request $request)
	{
		$this->validateEmail($request);

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$response = $this->broker()->sendResetLink(
				$this->credentials($request)
		);
		
		if ($response === Password::RESET_LINK_SENT) {
			Session::flash('message', __('forgot_password.sent_email_success_message'));
			Session::flash('class', 'success');
			Session::flash('display', 'block');
			return $this->sendResetLinkResponse($request, $response);
		} else {
			Session::flash('message', __('forgot_password.sent_email_failed_message'));
			Session::flash('class', 'danger');
			Session::flash('display', 'block');
			return $this->sendResetLinkFailedResponse($request, $response);
		}

//        return $response == Password::RESET_LINK_SENT
//            ? $this->sendResetLinkResponse($request, $response)
//            : $this->sendResetLinkFailedResponse($request, $response);
	}
}
