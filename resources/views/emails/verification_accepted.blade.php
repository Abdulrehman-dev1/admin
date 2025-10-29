@component('mail::message')
# Congratulations, {{ $name }}!

Your identity verification has been **accepted**. You can now access all the features of your account without restrictions.

@component('mail::button', ['url' => https://www.xpertbid.com/userDashboard])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
