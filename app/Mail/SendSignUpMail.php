<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSignUpMail extends Mailable
{
    use Queueable, SerializesModels;
	public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
		$subject='We are glad to have you!!';
        //return $this->from('info@charitism.com')->$this->subject('We are glad to have you!!')->$this->view('emails.signup');
        return $this->view('emails.signup')->from($from,$fromName)->subject($subject);
    }
}
