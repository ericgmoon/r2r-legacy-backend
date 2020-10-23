<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOTPMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $otp;
    public $subject;
    public function __construct($name,$subject,$otp)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@tellme.com.au')->view('email.otp');
    }
}
