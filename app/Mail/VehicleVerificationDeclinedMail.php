<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\VehicleVerification;

class VehicleVerificationDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public VehicleVerification $verification;
    public string $reason;
    public string $resubmitUrl;

    public function __construct(VehicleVerification $verification, string $reason, string $resubmitUrl)
    {
        $this->verification = $verification;
        $this->reason       = $reason;
        $this->resubmitUrl  = $resubmitUrl;
    }

    public function build()
    {
        return $this
            ->subject('Your Vehicle Verification Was Declined')
            ->markdown('emails.vehicle_verification_declined') 
            ->with([
                'verification' => $this->verification,
                'reason'       => $this->reason,
                'resubmitUrl'  => $this->resubmitUrl,
            ]);
    }
}
