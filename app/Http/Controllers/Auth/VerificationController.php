<?php

namespace App\Http\Controllers\Auth;

use App\EmailListContent;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Notifications\Emails;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class VerificationController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Email Verification Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling email verification for any
	| user that recently registered with the application. Emails may also
	| be re-sent if the user didn't receive the original email message.
	|
	*/

	use VerifiesEmails;

	/**
	 * Where to redirect users after verification.
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
		$this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');

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

	public function show(Request $request)
	{
		return $request->user()->hasVerifiedEmail()
				? redirect($this->redirectPath())
				: view('front.verify');
	}

	public function resend(Request $request)
	{
		if ($request->user()->hasVerifiedEmail()) {
			return redirect($this->redirectPath());
		}

		$request->user()->sendEmailVerificationNotification();

		return back()->with('resent', true);
	}

	public function resendAjax(Request $request)
	{
		if ($request->user()->hasVerifiedEmail()) {
			return response('Already verified', 200);
		}

		$request->user()->sendEmailVerificationNotification();

		return response('sent', 200);
	}


	public function verify(Request $request)
	{
		if (!hash_equals((string)$request->route('id'), (string)$request->user()->getKey())) {
			throw new AuthorizationException;
		}

		if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
			throw new AuthorizationException;
		}

		if ($request->user()->hasVerifiedEmail()) {
			return redirect($this->redirectPath());
		}

		if ($request->user()->markEmailAsVerified()) {
			event(new Verified($request->user()));
		}

		$email = EmailListContent::where(['type' => 'register_success'])->first();

		if ($email) {
			$client = Auth::user()->full_name();
			$lang = strtolower(Auth::user()->language());

			$email_title = $email->{'title_' . $lang}; //from
			$email_subject = $email->{'subject_' . $lang};
			$email_bottom = $email->{'content_bottom_' . $lang};
			$email_content = $email->{'content_' . $lang};

			$terms_link = 'https://asercargo.az/uploads/static/terms_aze.pdf';

			$email_content = str_replace('{name_surname}', $client, $email_content);
			$email_content = str_replace('{after_link}', $terms_link, $email_content);

			$request->user()->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom));
		}

		return redirect($this->redirectPath())->with('verified', true);
	}
}
