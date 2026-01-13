@component('mail::message')
# Congratulations!

Your identity verification for **{{ $name }}** has been **approved**.

You can now participate in auctions and use all features of {{ config('app.name') }}.

@component('mail::button', ['url' => 'https://xpertbid.com/userDashboard'])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent