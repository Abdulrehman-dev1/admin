@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $blog->title }}</h1>
    <p><small>By {{ $blog->user->name ?? 'Admin' }} | {{ $blog->created_at->format('d M Y') }}</small></p>

    @if($blog->image)
        <img src="{{ asset($blog->image) }}" alt="" width="300" height="300" class="img-fluid mb-3">
    @endif

    <div class="blog-content">
        {!! $blog->content !!}
    </div>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
