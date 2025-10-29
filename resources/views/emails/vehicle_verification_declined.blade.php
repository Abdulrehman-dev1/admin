@component('mail::message')
# Verification Declined

Hello {{ $verification->user->name }},

Unfortunately your vehicle verification request (#{{ $verification->id }}) was declined for the following reason:

> {{ $reason }}

@component('mail::button', ['url' => $resubmitUrl])
Resubmit Verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
