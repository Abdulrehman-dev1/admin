<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verification Declined</title>
</head>
<body>
    @php
      $computed = 'https://xpertbid.com/account?tab=identity_verification';
    @endphp

    <h1>Identity Verification Declined</h1>

    <p>Dear {{ $user->name ?? 'User' }},</p>

    <p>
        Unfortunately, your individual identity verification was declined.
        <br>
        <strong>Reason:</strong> {{ $declineReason }}
    </p>

    <p>
        Please review the reason and resubmit your documents.
    </p>

    <p>
      <a href="{{ $computed }}" style="
          display:inline-block;
          padding:10px 20px;
          background-color:#e74c3c;
          color:#fff;
          text-decoration:none;
          border-radius:4px;
        ">
        Resubmit Verification
      </a>
    </p>

    <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>