@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $seo->exists ? 'Edit' : 'Create' }} SEO</h1>

  <form action="{{ $seo->exists ? route('seo.update', $seo->id) : route('seo.store') }}" method="POST">
    @csrf
    @if($seo->exists) @method('PUT') @endif

    <div class="mb-3">
      <label>Slug</label>
      <input type="text" name="slug" value="{{ old('slug',$seo->slug) }}"
             class="form-control" @if($seo->exists) readonly @endif>
    </div>

    <div class="mb-3">
      <label>Meta Title</label>
      <input type="text" name="meta_title" value="{{ old('meta_title',$seo->meta_title) }}"
             class="form-control">
    </div>

    <div class="mb-3">
      <label>Meta Description</label>
      <textarea name="meta_description" class="form-control">{{ old('meta_description',$seo->meta_description) }}</textarea>
    </div>

    <div class="mb-3">
      <label>Meta Keywords</label>
      <input type="text" name="meta_keywords" value="{{ old('meta_keywords',$seo->meta_keywords) }}"
             class="form-control">
    </div>

    
    <button class="btn btn-success">{{ $seo->exists ? 'Update' : 'Save' }}</button>
    <a href="{{ route('seo.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
