<!-- resources/views/emails/corporate_verification_declined.blade.php -->
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Verification Declined</title></head>
<body>
  <h1>Corporate Verification Declined</h1>

  <p>Dear {{ $verification->user->name }},</p>
  <p>
    Unfortunately your corporate verification was declined for this reason:<br>
    <strong>{{ $reason }}</strong>
  </p>

  <p>
    <a href="{{ $resubmitUrl }}" style="
        display:inline-block;
        padding:10px 20px;
        background-color:#e74c3c;
        color:#fff;
        text-decoration:none;
        border-radius:4px;
      ">
      Resubmit Your Verification
    </a>
  </p>

  <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>
