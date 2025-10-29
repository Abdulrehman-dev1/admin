<?php

// app/Mail/CorporateVerificationAcceptedMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CorporateVerification;

class CorporateVerificationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verification;

    public function __construct(CorporateVerification $verification)
    {
        $this->verification = $verification;
    }

    public function build()
    {
        return $this
            ->subject('Your Corporate Verification Is Approved')
            ->markdown('emails.corporate_verification_accepted')
            ->with([
                'name' => $this->verification->user->name,
                'url'  => config('app.frontend_url') . '/',
            ]);
    }
}

