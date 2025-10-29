@extends('layouts.app')

@section('content')
    <h1>User Details</h1>
    <p>ID: {{ $user->id }}</p>
    <p>Email: {{ $user->email }}</p>
    <a href="{{ route('users.index') }}">Back to List</a>
@endsection
