<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class AuctionResultNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $auction;
    protected $user;

    public function __construct($auction, $user)
    {
        $this->auction = $auction;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Auction Result')
            ->greeting('Hello ' . $this->user->name)
            ->line('You won the auction for ' . $this->auction->title . '!')
            ->action('View Auction', url('/auctions/' . $this->auction->id))
            ->line('Thank you for using our auction platform!');
    }
}