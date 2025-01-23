<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CollectorInWarehouseEmail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */

	public $title;
	public $subject;
	public $content;
	public $bottom;
	public $button;
    public $cc_email;

	public function __construct($title, $cc_email, $subject, $content, $bottom, $button)
	{
		$this->title = $title;
		$this->subject = $subject;
		$this->content = $content;
		$this->bottom = $bottom;
		$this->button = $button;
        $this->cc_email = $cc_email;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */

	public function build()
	{
		return $this->markdown('emails.partner')
				->from('noreply@asercargo.az', $this->title)
                ->bcc($this->cc_email, '')
				->subject($this->subject)
				->with(['content' => $this->content, 'bottom' => $this->bottom, 'button_text' => $this->button]);
	}
}
