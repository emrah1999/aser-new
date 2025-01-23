<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
	use Queueable;

	private static $toMailCallback;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$verificationUrl = $this->verificationUrl($notifiable);

		if (static::$toMailCallback) {
			return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
		}

		$lang = strtolower(Auth::user()->language());

		switch ($lang) {
			case 'en':
				{
					$subject = 'Aser Cargo email verification';
				}
				break;
			case 'ru':
				{
					$subject = 'Подтверждение адреса электронной почты в Aser Cargo';
				}
				break;
			default:
			{
				// az
				$subject = 'Aser Cargo-da e-poçt ünvanının təsdiqi';
			}
		}

		return (new MailMessage)
				->from('noreply@asercargo.az', "Aser Cargo")
				->subject($subject)
				->action('Sahib', url($verificationUrl))
				->markdown('emails.verify_' . $lang);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return string
	 */

	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
				'verification.verify',
				Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
				[
						'id' => $notifiable->getKey(),
						'hash' => sha1($notifiable->getEmailForVerification()),
				]
		);
	}

	public function toArray($notifiable)
	{
		return [
			//
		];
	}

	public static function toMailUsing($callback)
	{
		static::$toMailCallback = $callback;
	}
}
