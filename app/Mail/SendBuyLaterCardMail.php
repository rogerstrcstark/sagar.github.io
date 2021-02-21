<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBuyLaterCardMail extends Mailable
{
    use Queueable, SerializesModels;
	public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$from='hello@charitism.com';
		$fromName='Charitism';
		$subject='You have a pending bucket list at charitism.';

        return $this->view('emails.buy-later')->from($from,$fromName)->subject($subject);
    }
}
