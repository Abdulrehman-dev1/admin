@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>
    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
        </div>

        <div class="form-group mb-3">
            <label for="firstName">Name</label>
            <input type="text" name="name" id="firstName" class="form-control" value="{{ $user->name ?? old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="country">Country</label>

            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $user->country ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ $user->city ?? old('city') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone ?? old('phone') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="company">Company</label>
            <input type="text" name="company" id="company" class="form-control" value="{{ $user->company ?? old('company') }}">
        </div>

        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $user->address ?? old('address') }}">
        </div>

        <div class="form-group mb-3">
            <label for="warehouse">Warehouse</label>
            <input type="text" name="warehouse" id="warehouse" class="form-control" value="{{ $user->warehouse ?? old('warehouse') }}">
        </div>

        <div class="form-group mb-3">
            <label for="nickname">Nickname</label>
            <input type="text" name="nickname" id="nickname" class="form-control" value="{{ $user->nickname ?? old('nickname') }}">
        </div>

        <div class="form-group mb-3">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ (old('role', $user->role ?? '') == $role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($user) ? 'Update User' : 'Create User' }}
        </button>
    </form>

@endsection
