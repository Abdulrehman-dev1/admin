<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Auction $auction;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Auction $auction, string $oldStatus, string $newStatus)
    {
        $this->auction   = $auction;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        $subject = "Your auction “{$this->auction->title}” status updated: {$this->newStatus}";

        return $this->subject($subject)
            ->markdown('emails.auctions.status-updated');
    }
}
