@extends('layouts.app')

@section('content')
<div class="nftmax-profile__container">
    <div class="nftmax-profile__header">
        <h1>Edit Profile</h1>
    </div>
    <form action="{{ route('user.profile.update') }}" method="POST" class="nftmax-form">
        @csrf
        <div class="nftmax-form__group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="nftmax-form__group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="nftmax-form__group">
            <label for="password">New Password</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="nftmax-form__group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm new password">
        </div>
        <button type="submit" class="nftmax-btn nftmax-btn__primary">Update Profile</button>
    </form>
</div>
@endsection
