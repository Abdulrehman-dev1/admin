<?php

namespace App\Mail;

use App\Models\IndividualVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IndividualVerificationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public IndividualVerification $verification;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(IndividualVerification $verification, string $oldStatus, string $newStatus)
    {
        $this->verification = $verification;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject("Your verification status: {$this->newStatus}")
            ->markdown('emails.individual.status-updated', [
                'verification' => $this->verification,
                'oldStatus'    => $this->oldStatus,
                'newStatus'    => $this->newStatus,
            ]);
    }
}
