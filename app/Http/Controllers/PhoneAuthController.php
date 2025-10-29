<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\TwilioService;

class PhoneAuthController extends Controller
{
protected $twilioService;

public function __construct(TwilioService $twilioService)
{
    //$this->client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));

$this->twilioService = $twilioService;
}

public function sendOtp(Request $request)
{
$request->validate([
'phone' => 'required|numeric|min:10',
]);

$otp = rand(1000, 9999); // Generate a random 4-digit OTP

// Cache the OTP with a 5-minute expiry
Cache::put('otp_' . $request->phone, $otp, now()->addMinutes(5));

// Send the OTP via Twilio
    try {
        if ($this->twilioService->sendOtp($request->phone, $otp)) {
            return response()->json(['message' => 'OTP sent successfully.']);
        }
    } catch (\Exception $e) {

        return response()->json(['message' => $e->getMessage()], 500);

    }

//return response()->json(['message' => 'Failed to send OTP.'], 500);
}

public function verifyOtp(Request $request)
{
$request->validate([
'phone' => 'required|numeric|min:10',
'otp' => 'required|numeric|digits:4',
]);

$cachedOtp = Cache::get('otp_' . $request->phone);

if ($cachedOtp && $cachedOtp == $request->otp) {
Cache::forget('otp_' . $request->phone); // Clear the OTP after successful verification
return response()->json(['message' => 'OTP verified successfully.']);
}

return response()->json(['message' => 'Invalid or expired OTP.'], 422);
}
}
