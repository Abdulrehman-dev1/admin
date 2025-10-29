
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($user->id) ? 'Edit User' : 'Create User' }}</h2>

    <form action="{{ isset($user->id) ? route('users.update', $user) : route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($user->id))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" {{ isset($user->id) ? '' : 'required' }}>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
        </div>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select name="role_id" class="form-control" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="country_id">Country</label>
            <select name="country_id" class="form-control" required>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="state_id">State</label>
            <select name="state_id" class="form-control">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ old('state_id', $user->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" class="form-control">
                <option value="">Select City</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="form-group">
            <label for="approved">Status</label>
            <select name="approved" class="form-control" required>
                <option value="1" {{ old('approved', $user->approved) == 1 ? 'selected' : '' }}>Approved</option>
                <option value="0" {{ old('approved', $user->approved) == 0 ? 'selected' : '' }}>Disapproved</option>
            </select>
        </div>

        <div class="form-group">
            <label for="profile_pic">Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control">
        </div>

        <div class="form-group">
            <label for="company_logo">Company Logo</label>
            <input type="file" name="company_logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($user->id) ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
