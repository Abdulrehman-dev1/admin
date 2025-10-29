@component('mail::message')
# Verification Status Updated

Hello {{ $verification->full_legal_name ?? 'there' }},

Your individual verification status changed from **{{ ucfirst($oldStatus) ?: '—' }}**
to **{{ ucfirst($newStatus) }}**.

@component('mail::panel')
**Country:** {{ $verification->country ?? '—' }}  
**Email:** {{ $verification->email_address ?? '—' }}
@endcomponent

@if ($newStatus === 'resubmit')
Please review your documents/details and re-submit so we can verify you quickly.
@endif

Thanks,  
**{{ config('app.name') }}**
@endcomponent
