<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidOutbidNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $listingTitle;
    public $yourBidAmount;
    public $newHighestBid;
    public $dashboardLink;

    /**
     * Create a new message instance.
     *
     * @param string $firstName     Bidder ka naam.
     * @param string $listingTitle  Listing ka title.
     * @param string $yourBidAmount Us ne kitna bid kiya.
     * @param string $newHighestBid Ab tak ka sab se zyada bid.
     * @param string $dashboardLink My Bids Dashboard ka link.
     */
    public function __construct($firstName, $listingTitle, $yourBidAmount, $newHighestBid, $dashboardLink)
    {
        $this->firstName = $firstName;
        $this->listingTitle = $listingTitle;
        $this->yourBidAmount = $yourBidAmount;
        $this->newHighestBid = $newHighestBid;
        $this->dashboardLink = $dashboardLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have been outbid on XpertBid')
                    ->view('emails.bid_outbid_notification');
    }
}
