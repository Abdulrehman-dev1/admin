@php
  $computed = 'https://xpertbid.com/verify/'.$verification->id;
@endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Verification Declined</title>
</head>
<body>
  <h1>Verification Declined</h1>

  <p>Dear {{ $user->full_legal_name }},</p>

  <p>
    Unfortunately your verification was declined for this reason:<br>
    <strong>{{ $declineReason }}</strong>
  </p>

  <p>
    <a href="{{ $computed }}" class="btn btn-primary">
      Resubmit Your Verification
    </a>
  </p>

  <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>
