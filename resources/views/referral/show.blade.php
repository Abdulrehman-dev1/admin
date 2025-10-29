@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Referral Details</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5>User Info</h5>
            <p><strong>ID:</strong> {{ $user->id ?? 'N/A' }}</p>
            <p><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
            <p><strong>Referral Code:</strong> {{ $user->referral_code ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Referred By</h5>
            @if($referrer)
                <p><strong>Name:</strong> {{ $referrer->name }}</p>
                <p><strong>Email:</strong> {{ $referrer->email }}</p>
            @else
                <p>No referrer (Direct Signup)</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>
                Referrals 
                <span class="badge bg-primary">{{ $referrals->count() }}</span>
            </h5>

            @if($referrals->count() > 0)
                <ul>
                    @foreach($referrals as $ref)
                        <li>{{ $ref->name ?? 'N/A' }} ({{ $ref->email ?? 'N/A' }})</li>
                    @endforeach
                </ul>
            @else
                <p>No referrals found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
