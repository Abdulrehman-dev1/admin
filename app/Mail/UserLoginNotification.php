<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $location;
    public $device;
    public $time;

    /**
     * Create a new message instance.
     *
     * @param string $firstName    User’s first name (or set a default if not used)
     * @param string $location     e.g., "City, Country"
     * @param string $device       Device type or browser information
     * @param string $time         Date & time of the login
     */
    public function __construct($firstName, $location, $device, $time)
    {
        $this->firstName = $firstName;
        $this->location = $location;
        $this->device   = $device;
        $this->time     = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Security Notification: New Login to Your XpertBid Account')
                    ->view('emails.login_notification');
    }
}
