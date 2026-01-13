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

            // Determine type
            $type = null;
            
            // 1. Check if 'data' contains a Mailable object
            if (is_array($event->data)) {
                foreach ($event->data as $key => $value) {
                    if (is_object($value) && $value instanceof \Illuminate\Mail\Mailable) {
                        $type = class_basename($value);
                        break;
                    }
                }
            }

            // 2. Check for Notification
            if (!$type && isset($event->data['__laravel_notification'])) {
                $type = class_basename($event->data['__laravel_notification']); 
            } elseif (!$type && isset($event->data['__laravel_mailable'])) {
                // Some versions store it here
                $type = class_basename($event->data['__laravel_mailable']);
            }
            
            // 3. Fallback: Try to infer from Subject if still null
            if (!$type && $subject) {
                 // Example: "Order Confirmation - ..." -> "Order Confirmation"
                 $parts = explode('-', $subject);
                 $type = trim($parts[0]);
            }
            
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
