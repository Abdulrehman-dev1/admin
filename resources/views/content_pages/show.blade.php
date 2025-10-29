@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Content Page Details</h2>

    <p><strong>Title:</strong> {{ $contentPage->title }}</p>
    <p><strong>Description:</strong> {!! $contentPage->description !!}</p>
    <p><strong>Status:</strong> {{ $contentPage->status }}</p>

    <a href="{{ route('content-pages.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
