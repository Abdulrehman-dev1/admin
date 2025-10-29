@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Show Letter</h2>
    <div class="card">
        <div class="card-header">
            <strong>To:</strong> {{ $createLetter->to }}
        </div>
        <div class="card-body">
            <strong>Title:</strong> {{ $createLetter->title }}
            <hr>
            <strong>Message:</strong>
            <p>{{ $createLetter->message }}</p>
        </div>
    </div>
</div>
@endsection
