<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Tools;

class OTP extends Mailable
{
    use SerializesModels;

    private string $otp;
    private string $email;

    public function __construct(string $otp, string $email)
    {
        $this->otp = $otp;
        $this->email = $email;
    }

    public function build(): self
    {
        return $this->subject('OTP')
            ->view('otp')
            ->with([
                'otp' => $this->otp,
                'email' => $this->email,
                'expired_in' => '5 menit',
            ]);
    }
}
