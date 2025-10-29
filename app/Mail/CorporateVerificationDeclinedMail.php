<?php

// app/Mail/CorporateVerificationDeclinedMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CorporateVerification;

class CorporateVerificationDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verification;
    public $declineReason;
    public $resubmitUrl;

    public function __construct(CorporateVerification $verification, $declineReason, $resubmitUrl)
    {
        $this->verification   = $verification;
        $this->declineReason  = $declineReason;
        $this->resubmitUrl    = $resubmitUrl;
    }

    public function build()
    {
        return $this->subject('Corporate Verification Declined')
                    ->view('emails.corporate_verification_declined')
                    ->with([
                        'verification'  => $this->verification,
                        'reason'        => $this->declineReason,
                        'resubmitUrl'   => $this->resubmitUrl,
                    ]);
    }
}

