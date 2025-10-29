@extends('admin.layout')

@section('content')
<div class="container">
  <h1>View SEO: {{ $seo->slug }}</h1>

  <table class="table">
    <tr><th>Meta Title</th><td>{{ $seo->meta_title }}</td></tr>
    <tr><th>Meta Description</th><td>{{ $seo->meta_description }}</td></tr>
    <tr><th>Meta Keywords</th><td>{{ $seo->meta_keywords }}</td></tr>
    <tr><th>OG Title</th><td>{{ $seo->og_title }}</td></tr>
    <tr><th>OG Description</th><td>{{ $seo->og_description }}</td></tr>
    <tr><th>OG Image</th><td>{{ $seo->og_image }}</td></tr>
  </table>

  <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">Back</a>
  <a href="{{ route('admin.seo.edit', $seo->id) }}" class="btn btn-primary">Edit</a>
</div>
@endsection
