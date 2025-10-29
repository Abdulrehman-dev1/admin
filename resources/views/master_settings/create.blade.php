@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($masterSetting) ? 'Edit' : 'Create' }} Master Setting</h2>
    <form method="POST" action="{{ isset($masterSetting) ? route('master-settings.update', $masterSetting->id) : route('master-settings.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($masterSetting))
            @method('PATCH')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <span class="text-red">*</span>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $masterSetting->title ?? '') }}" required>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="key">Key</label>
            <span class="text-red">*</span>
            <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key', $masterSetting->key ?? '') }}" {{ isset($masterSetting) ? 'readonly' : '' }} required>
            @error('key')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
            @if(isset($masterSetting) && $masterSetting->image)
                <img src="{{ asset('storage/' . $masterSetting->image) }}" alt="Image" width="100" class="mt-2">
            @endif
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $masterSetting->description ?? '') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ isset($masterSetting) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('master-settings.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
