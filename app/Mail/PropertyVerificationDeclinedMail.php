<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PropertyVerification;

class PropertyVerificationDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var PropertyVerification */
    public $verification;

    /** @var string */
    public $declineReason;

    /** @var string */
    public $resubmitUrl;

    /**
     * Create a new message instance.
     *
     * @param  PropertyVerification  $verification
     * @param  string                $declineReason
     * @param  string                $resubmitUrl
     */
    public function __construct(PropertyVerification $verification, string $declineReason, string $resubmitUrl)
    {
        $this->verification  = $verification;
        $this->declineReason = $declineReason;
        $this->resubmitUrl   = $resubmitUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Your property verification was declined')
            ->view('emails.property_verification_declined')
            ->with([
                'verification'  => $this->verification,
                'declineReason' => $this->declineReason,
                'resubmitUrl'   => $this->resubmitUrl,
            ]);
    }
}
