<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendThankYouCardMail extends Mailable
{
    use Queueable, SerializesModels;
	public $data1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1)
    {
        $this->data1 = $data1;
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
		$subject='Well done, you raised a donation.';

        return $this->view('emails.thank-you-card')->from($from,$fromName)->subject($subject);
    }
}
