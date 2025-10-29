<?php

namespace App\Services;

use OneSignal;

class OneSignalService
{
    public function sendNotification($playerIds, $message)
    {
        OneSignal::sendNotificationToExternalUser($playerIds, $message);
    }
}
