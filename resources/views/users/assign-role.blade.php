@extends('layouts.app')

@section('content')
<h1>Assign Role to {{ $user->name }}</h1>
<form action="{{ route('users.roles.store', $user) }}" method="POST">
    @csrf
    <label for="roles">Roles:</label>
    <select name="roles[]" class="form-control" multiple>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary mt-3">Assign</button>
</form>
@endsection
