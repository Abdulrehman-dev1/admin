<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Auction;

class FeaturedListingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $listingTitle;
    public $homeUrl;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Auction $auction
     */
    public function __construct(User $user, Auction $auction)
    {
        $this->firstName = $user->name; // Assuming name is full name, or just use name
        $this->listingTitle = $auction->title;
        $this->homeUrl = env('NEXT_PUBLIC_FRONTEND_URL', 'https://xpertbid.com');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Product is Featured on XpertBid')
            ->view('emails.featured_listing_notification');
    }
}
