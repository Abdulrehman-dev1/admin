<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\IndividualVerification;

class VerificationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verification;

    public function __construct(IndividualVerification $verification)
    {
        $this->verification = $verification;
    }

    public function build()
    {
        return $this
            ->subject('Your verification has been accepted')
            ->markdown('emails.verification_accepted')
            ->with([
                'name' => $this->verification->full_legal_name,
            ]);
    }
}
