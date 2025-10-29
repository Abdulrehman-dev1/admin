@component('mail::message')
# Hello {{ $name }},

We’re sorry, but your identity verification request was **declined** for the following reason:

> {{ $reason }}

Please correct that issue and resubmit your documents.

@component('mail::button', ['url' => config('app.frontend_url') . '/account?tab=identity_verification'])
Verify Now
@endcomponent

Thanks,<br>
**XpertBid Team**
@endcomponent
