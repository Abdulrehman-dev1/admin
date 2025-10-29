@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Blog</h1>
    <form id="blogForm" action="{{ route('blogs.update',$blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Title --}}
        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title',$blog->title) }}" class="form-control" required>
        </div>

        {{-- Content --}}
        <div class="form-group mb-3">
            <label>Content</label>
            <textarea id="editor" name="content" rows="6" class="form-control">{{ old('content',$blog->content) }}</textarea>
        </div>

        {{-- Image --}}
        <div class="form-group mb-3">
            <label>Image (optional)</label>
            <input type="file" name="image" class="form-control">
            @if($blog->image)
                <img src="{{ asset($blog->image) }}" alt="" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;

    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => { editorInstance = editor; })
        .catch(error => { console.error(error); });

    // Optional validation (prevent empty content)
    document.querySelector('#blogForm').addEventListener('submit', function (e) {
        let content = editorInstance.getData().trim();
        if (content === "") {
            e.preventDefault();
            alert("Please enter blog content before submitting.");
        }
    });
</script>
@endpush
