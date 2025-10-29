<?php
namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
protected $client;

public function __construct()
{
$this->client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
}

public function sendOtp(string $phoneNumber, int $otp): bool
{
try {
$message = "Your OTP code is: $otp";
$this->client->messages->create($phoneNumber, [
'from' => env('TWILIO_PHONE_NUMBER'),
'body' => $message,
]);
return true;
} catch (\Exception $e) {
\Log::error("Twilio SMS Error: " . $e->getMessage());
return false;
}
}
}
