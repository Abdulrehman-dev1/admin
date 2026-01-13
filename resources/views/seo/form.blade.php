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
             class="form-control">
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

    <div class="mb-3">
      <label>Canonical URL</label>
      <input type="url" name="canonical_url" value="{{ old('canonical_url',$seo->canonical_url) }}"
             class="form-control" placeholder="https://example.com/...">
      <small class="text-muted">Leave empty to use the default page URL.</small>
    </div>

    <div class="mb-3">
      <label>Schema Markup (JSON)</label>
      <textarea name="schema_markup" class="form-control" rows="6" placeholder='{"@context": "https://schema.org", ...}'>{{ old('schema_markup',$seo->schema_markup) }}</textarea>
    </div>

    
    <button class="btn btn-success">{{ $seo->exists ? 'Update' : 'Save' }}</button>
    <a href="{{ route('seo.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
