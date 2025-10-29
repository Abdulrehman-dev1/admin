<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWonNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $listingTitle;
    public $winningBidAmount;
    public $auctionEnded;
    public $completePaymentLink;

    /**
     * Create a new message instance.
     *
     * @param string $firstName          Winner's first name.
     * @param string $listingTitle       Title of the won listing.
     * @param string $winningBidAmount   The winning bid amount.
     * @param string $auctionEnded       Auction end date & time.
     * @param string $completePaymentLink URL for completing the payment.
     */
    public function __construct($firstName, $listingTitle, $winningBidAmount, $auctionEnded, $completePaymentLink)
    {
        $this->firstName          = $firstName;
        $this->listingTitle       = $listingTitle;
        $this->winningBidAmount   = $winningBidAmount;
        $this->auctionEnded       = $auctionEnded;
        $this->completePaymentLink = $completePaymentLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations – You Have Won the Auction!')
                    ->view('emails.auction_won_notification');
    }
}
