<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Property Verification Declined</title>
</head>
<body>
  <p>Dear {{ $verification->user->name }},</p>

  <p>We’re sorry to let you know your property verification was declined for the following reason:</p>
  <p><strong>{{ $declineReason }}</strong></p>

  <p>If you’d like to try again, please click below to resubmit your documents:</p>
  <p style="text-align:center; margin:2em 0;">
    <a href="{{ $resubmitUrl }}"
       style="display:inline-block;
              background:#1a73e8;
              color:#fff;
              text-decoration:none;
              padding:12px 24px;
              border-radius:4px;
              font-weight:bold;">
      Resubmit Your Verification
    </a>
  </p>

  <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>
 