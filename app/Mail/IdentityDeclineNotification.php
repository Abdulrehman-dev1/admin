<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $verification;
    public $reason;
    public $resubmitUrl;
    public function __construct($verification, $reason)
    {
        $this->verification = $verification;
        $this->reason       = $reason;
        // yahan button ka URL, front-end form edit page ya API page
        // Build a URL to your Next.js edit page
    $this->resubmitUrl  = config('app.frontend_url')
      . "/verify/{$verification->id}";
    }

public function build()
{
    // 1) Construct karo URL
    $resubmitUrl = rtrim(config('app.frontend_url', env('APP_URL')), '/') 
        . "/verify/{$this->verification->id}";

    // 2) Dump & Die yahan laga do
    dd(compact('resubmitUrl'));

    // 3) Baad me normal mail build karne ke liye yeh use karoge:
    // return $this
    //     ->subject('Your identity verification was declined')
    //     ->view('emails.verification_declined', [
    //         'user'          => $this->verification,
    //         'declineReason' => $this->reason,
    //         'resubmitUrl'   => $resubmitUrl,
    //     ]);
}

}
