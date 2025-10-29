@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Blog</h1>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" 
                   name="title" 
                   class="form-control" 
                   value="{{ old('title') }}" 
                   required>
            @error('title') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Content --}}
        <div class="form-group mb-3">
            <label>Content</label>
            <textarea id="editor"
                      name="content" 
                      rows="6" 
                      class="form-control" 
                      >{{ old('content') }}</textarea>
            @error('content') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Image --}}
        <div class="form-group mb-3">
            <label>Image (optional)</label>
            <input type="file" 
                   name="image" 
                   class="form-control">
            @error('image') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });
</script>
@endpush

