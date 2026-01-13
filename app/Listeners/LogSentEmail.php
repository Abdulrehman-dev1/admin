<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LogSentEmail
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        try {
            $message = $event->message;
            
            // Get recipients
            $to = [];
            foreach ($message->getTo() as $address) {
                // Symfony Mailer Address object
                $to[] = $address->getAddress();
            }
            $recipientEmail = implode(', ', $to);

            // Get subject
            $subject = $message->getSubject();

            // Try to find user by email
            // We assume the first recipient is the main user for now
            $firstEmail = $to[0] ?? null;
            $user = null;
            if ($firstEmail) {
                $user = User::where('email', $firstEmail)->first();
            }

            // Determine type (optional, based on mailable class if available? 
            // The event data has 'data' which might contain the mailable)
            $type = null;
            if (isset($event->data['__laravel_notification'])) {
                $type = class_basename($event->data['__laravel_notification']); 
            } elseif (isset($event->data['__laravel_mailable'])) { // This key might vary depending on Laravel version
                 // If using Mailable, we might check the object class
            }
            
            // If we can't get it easily from data, we leave it null or try to guess from subject
            
            EmailLog::create([
                'user_id' => $user ? $user->id : null,
                'recipient_email' => $recipientEmail,
                'subject' => $subject,
                'type' => $type,
                'sent_at' => now(),
                'status' => 'sent',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to log sent email: ' . $e->getMessage());
        }
    }
}
