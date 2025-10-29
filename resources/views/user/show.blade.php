
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Role:</strong> {{ $user->role->name }}</p>
            <p><strong>Country:</strong> {{ $user->country->name }}</p>
            <p><strong>State:</strong> {{ optional($user->state)->name }}</p>
            <p><strong>City:</strong> {{ optional($user->city)->name }}</p>
            <p><strong>Address:</strong> {{ $user->address }}</p>
            <p><strong>Status:</strong> {{ $user->approved ? 'Approved' : 'Disapproved' }}</p>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
</div>
@endsection
