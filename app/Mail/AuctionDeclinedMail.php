<?php
// app/Mail/AuctionDeclinedMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Auction;

class AuctionDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;
    public $editUrl;

    public function __construct(Auction $auction, $editUrl)
    {
        $this->auction = $auction;
        $this->editUrl = $editUrl;
    }

    public function build()
    {
        return $this->subject('Your Auction Has Been Declined')
            ->view('emails.auction_declined');
    }
}

