@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>{{ $emailTemplate->title }}</h1>
        <div class="form-group">
            <strong>Type:</strong> {{ $emailTemplate->type }}
        </div>
        <div class="form-group">
            <strong>Subject:</strong> {{ $emailTemplate->subject }}
        </div>
        <div class="form-group">
            <strong>Content:</strong>
            <div>{!! $emailTemplate->content !!}</div>
        </div>
        <a href="{{ route('emailtemplates.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
