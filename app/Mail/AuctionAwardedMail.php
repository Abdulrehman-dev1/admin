<?php

namespace App\Mail;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionAwardedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;
    public $highestBid;
    public $recipientType; // 'winner' or 'admin'

    /**
     * Create a new message instance.
     *
     * @param Auction $auction
     * @param Bid $highestBid
     * @param string $recipientType
     */
    public function __construct(Auction $auction, Bid $highestBid, $recipientType = 'winner')
    {
        $this->auction = $auction;
        $this->highestBid = $highestBid;
        $this->recipientType = $recipientType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->recipientType === 'admin'
            ? 'Auction Awarded - ' . $this->auction->title
            : 'Congratulations! You Won the Auction - ' . $this->auction->title;

        return $this->subject($subject)
                    ->view('emails.auction_awarded')
                    ->with([
                        'auction' => $this->auction,
                        'highestBid' => $this->highestBid,
                        'recipientType' => $this->recipientType
                    ]);
    }
}

