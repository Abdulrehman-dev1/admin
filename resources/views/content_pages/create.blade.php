@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($contentPage) ? 'Edit Content Page' : 'Create Content Page' }}</h2>

    <form action="{{ isset($contentPage) ? route('content-pages.update', $contentPage->id) : route('content-pages.store') }}" method="POST">
        @csrf
        @if(isset($contentPage))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $contentPage->title ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control ckeditor" rows="10" required>{{ old('description', $contentPage->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Active" {{ (isset($contentPage) && $contentPage->status == 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($contentPage) && $contentPage->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($contentPage) ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
