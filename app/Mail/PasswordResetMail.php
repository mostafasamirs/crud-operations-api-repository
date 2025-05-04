<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $emailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $emailData)
    {
        $this->subject = $subject;
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.otp')
            ->with([
                'otp' => $this->emailData['verificationCode'],
                'name' => $this->emailData['name'],
                'lang' => $this->emailData['lang'],
            ]);
    }


}
