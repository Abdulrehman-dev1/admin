<?php

namespace App\Mail;

use App\Models\Identity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IdentityStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Identity $identity;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Identity $identity, string $oldStatus, string $newStatus)
    {
        $this->identity = $identity;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        $subject = "Your identity verification status: {$this->newStatus}";
        return $this->subject($subject)
            ->markdown('emails.identity.status-updated');
    }
}
