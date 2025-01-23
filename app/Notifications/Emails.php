<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Emails extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */

	public $title;
	public $subject;
	public $content;
	public $bottom;
	public $button;

	public function __construct($title, $subject, $content, $bottom, $button = "")
	{
		$this->title = $title;
		$this->subject = $subject;
		$this->content = $content;
		$this->bottom = $bottom;
		$this->button = $button;
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
		return (new MailMessage)
				->from('noreply@asercargo.az', $this->title)
				->subject($this->subject)
				->markdown('emails.notifications', ['content' => $this->content, 'bottom' => $this->bottom, 'button_text' => $this->button]);
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
