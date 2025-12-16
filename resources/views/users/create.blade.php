@extends('layouts.app')

@section('title', $user->exists ? 'Edit User' : 'Add User')

@section('content')
  <div class="nftmax__container">
    <h1 class="nftmax__header">
      {{ $user->exists ? 'Edit User' : 'Add User' }}
    </h1>

    <form action="{{ $user->exists
    ? route('users.update', $user->id)
    : route('users.store') }}" method="POST">
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
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
          value="{{ old('name', $user->name) }}" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>



      {{-- Email --}}
      <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
          value="{{ old('email', $user->email) }}" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Password --}}
      <div class="form-group mb-3">
        <label for="password">
          {{ $user->exists ? 'New Password (leave blank to keep current)' : 'Password' }}
        </label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
          {{ $user->exists ? '' : 'required' }}>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>



      {{-- Phone --}}
      <div class="form-group mb-3">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
          value="{{ old('phone', $user->phone) }}" required>
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Role --}}
      <div class="form-group mb-3">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
          <option value="">Select Role</option>
          @foreach($roles as $role)
            <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
              {{ ucfirst($role) }}
            </option>
          @endforeach
        </select>
        @error('role')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>








      <button type="submit" class="btn btn-primary">
        {{ $user->exists ? 'Update User' : 'Create User' }}
      </button>
    </form>
  </div>
@endsection