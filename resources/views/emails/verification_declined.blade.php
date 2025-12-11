@php
  $computed = 'https://xpertbid.com/verify/' . $verification->id;
@endphp
<p>
  <a href="{{ $computed }}" class="btn btn-primary">
    Resubmit Your Verification
  </a>
</p>

<p>Thank you,<br>{{ config('app.name') }}</p>
</body>

</html>