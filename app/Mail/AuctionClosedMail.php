<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionClosedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;
    public $recipientType; // 'seller' or 'admin'

    /**
     * Create a new message instance.
     *
     * @param Auction $auction
     * @param string $recipientType
     */
    public function __construct(Auction $auction, $recipientType = 'seller')
    {
        $this->auction = $auction;
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
            ? 'Auction Closed - ' . $this->auction->title
            : 'Your Auction Has Been Closed - ' . $this->auction->title;

        return $this->subject($subject)
                    ->view('emails.auction_closed')
                    ->with([
                        'auction' => $this->auction,
                        'recipientType' => $this->recipientType
                    ]);
    }
}

