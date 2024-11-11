<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TestEmail extends Mailable
{
    public function build()
    {
        return $this->view('emails.test')
                    ->subject('Test Email from Laravel');
    }
}
