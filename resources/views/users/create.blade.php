@extends('layouts.app')

@section('title', $user->exists ? 'Edit User' : 'Add User')

@section('content')
<div class="nftmax__container">
  <h1 class="nftmax__header">
    {{ $user->exists ? 'Edit User' : 'Add User' }}
  </h1>

  <form
    action="{{ $user->exists
        ? route('users.update', $user->id)
        : route('users.store') }}"
    method="POST"
  >
    @csrf
    @if($user->exists)
      @method('PUT')
    @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif
    {{-- Full Name --}}
    <div class="form-group mb-3">
      <label for="name">Full Name</label>
      <input
        type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name) }}"
        required
      >
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Username --}}
    <div class="form-group mb-3">
      <label for="username">Username</label>
      <input
        type="text"
        name="username"
        id="username"
        class="form-control @error('username') is-invalid @enderror"
        value="{{ old('username', $user->username) }}"
        required
      >
      @error('username')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Email --}}
    <div class="form-group mb-3">
      <label for="email">Email</label>
      <input
        type="email"
        name="email"
        id="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email) }}"
        required
      >
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div class="form-group mb-3">
      <label for="password">
        {{ $user->exists ? 'New Password (leave blank to keep current)' : 'Password' }}
      </label>
      <input
        type="password"
        name="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
        {{ $user->exists ? '' : 'required' }}
      >
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="form-group mb-3">
      <label for="password_confirmation">Confirm Password</label>
      <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        class="form-control @error('password_confirmation') is-invalid @enderror"
        {{ $user->exists ? '' : 'required' }}
      >
      @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Phone --}}
    <div class="form-group mb-3">
      <label for="phone">Phone</label>
      <input
        type="text"
        name="phone"
        id="phone"
        class="form-control @error('phone') is-invalid @enderror"
        value="{{ old('phone', $user->phone) }}"
        required
      >
      @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Role --}}
    <div class="form-group mb-3">
      <label for="role">Role</label>
      <select
        name="role"
        id="role"
        class="form-control @error('role') is-invalid @enderror"
        required
      >
        <option value="">Select Role</option>
        @foreach($roles as $role)
          <option
            value="{{ $role }}"
            {{ old('role', $user->role) === $role ? 'selected' : '' }}
          >
            {{ ucfirst($role) }}
          </option>
        @endforeach
      </select>
      @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

   {{-- Country --}}
<div class="form-group mb-3">
  <label for="country_id">Country</label>
  <select
    name="country_id"
    id="country_id"
    class="form-control @error('country_id') is-invalid @enderror"
    required
  >
    <option value="">Select Country</option>
    @foreach(\App\Models\Country::all() as $c)
      <option
        value="{{ $c->id }}"
        {{ old('country_id', $user->country_id) == $c->id ? 'selected' : '' }}
      >
        {{ $c->name }}
      </option>
    @endforeach
  </select>
  @error('country_id')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

{{-- City --}}
<div class="form-group mb-3">
  <label for="city_id">City</label>
  <select
    name="city_id"
    id="city_id"
    class="form-control @error('city_id') is-invalid @enderror"
    required
  >
    <option value="">Select City</option>
    @foreach(\App\Models\City::all() as $city)
      <option
        value="{{ $city->id }}"
        {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}
      >
        {{ $city->name }}
      </option>
    @endforeach
  </select>
  @error('city_id')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
    {{-- Company --}}
    <div class="form-group mb-3">
      <label for="company">Company</label>
      <input
        type="text"
        name="company"
        id="company"
        class="form-control @error('company') is-invalid @enderror"
        value="{{ old('company', $user->company) }}"
      >
      @error('company')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Address --}}
    <div class="form-group mb-3">
      <label for="address">Address</label>
      <input
        type="text"
        name="address"
        id="address"
        class="form-control @error('address') is-invalid @enderror"
        value="{{ old('address', $user->address) }}"
      >
      @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">
      {{ $user->exists ? 'Update User' : 'Create User' }}
    </button>
  </form>
</div>
@endsection
