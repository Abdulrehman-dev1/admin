@extends('layouts.app')

@section('content')
<h1>Create Slider</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="subtitle" placeholder="Subtitle" value="{{ old('subtitle') }}">
    @error('subtitle')
        <p>{{ $message }}</p>
    @enderror

    <textarea name="description" placeholder="Description">{{ old('description') }}</textarea>
    @error('description')
        <p>{{ $message }}</p>
    @enderror

    <input type="file" name="image">
    @error('image')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Save</button>
</form>
@endsection
