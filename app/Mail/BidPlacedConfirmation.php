<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidPlacedConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $amount;
    public $listingTitle;
    public $auctionEnds;
    public $currentHighestBid;
    public $dashboardLink;

    /**
     * Create a new message instance.
     *
     * @param string $firstName       User's first name.
     * @param string $amount          The bid amount.
     * @param string $listingTitle    The listing title.
     * @param string $auctionEnds     Auction end date and time.
     * @param string $currentHighestBid The current highest bid.
     * @param string $dashboardLink   URL to the My Bids Dashboard.
     */
    public function __construct($firstName, $amount, $listingTitle, $auctionEnds, $currentHighestBid, $dashboardLink)
    {
        $this->firstName        = $firstName;
        $this->amount           = $amount;
        $this->listingTitle     = $listingTitle;
        $this->auctionEnds      = $auctionEnds;
        $this->currentHighestBid = $currentHighestBid;
        $this->dashboardLink    = $dashboardLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation – Your Bid Has Been Submitted on XpertBid')
                    ->view('emails.bid_placed_confirmation');
    }
}
