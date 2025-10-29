{{-- resources/views/emails/corporate_verification_accepted.blade.php --}}

@component('mail::message')
# Congrats, {{ $name }}!

Your corporate verification has been **approved**.  

@component('mail::button', ['url' => $url])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
