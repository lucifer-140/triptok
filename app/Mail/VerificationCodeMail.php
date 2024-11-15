<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        $url = route('verify.form', ['verificationCode' => $this->verificationCode]);

        return $this->view('emails.verification')
                    ->with([
                        'url' => $url,
                    ]);
    }

}
