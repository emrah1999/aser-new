<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class ResetPassword extends ResetPasswordNotification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
//    public $token;
//
//    public function __construct($token)
//    {
//        $this->token = $token;
//    }

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
		$lang = strtolower(App::getLocale());

		switch ($lang) {
			case 'en':
				{
					$subject = 'Password recovery on Asercargo.az';
				}
				break;
			case 'ru':
				{
					$subject = 'Восстановление пароля на сайте Asercargo.az';
				}
				break;
			default:
			{
				// az
				$subject = 'Asercargo.az saytında şifrənin bərpası';
			}
		}

		return (new MailMessage)
				->from('noreply@asercargo.az', "Aser Cargo")
				->subject($subject)
				->action('Sahib', url('password/reset', $this->token))
				->markdown('emails.reset_password_' . $lang);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
