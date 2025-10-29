<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\IndividualVerification;

class VerificationDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public IndividualVerification $verification;
    public string $declineReason;
    public string $resubmitUrl;

    public function __construct(IndividualVerification $verification, string $declineReason)
    {
        $this->verification  = $verification;
        $this->declineReason = $declineReason;
        $frontend = rtrim(config('app.frontend_url'), '/');
        $this->resubmitUrl ='https://xpertbid.com/verify/'.$verification->id;
    }

 public function build()
{
    return $this
        ->subject('Your identity verification was declined')
        ->view('emails.verification_declined')
        ->with([
            'user'          => $this->verification->user,  // <-- add this
            'declineReason' => $this->declineReason,
            'resubmitUrl'   => $this->resubmitUrl,
        ]);
}

}
