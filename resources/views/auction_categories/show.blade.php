@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Category: {{ $category->name }}</h1>
  @if($category->image)
    <img src="{{ asset($category->image) }}" alt="" style="max-width:200px;" class="mb-4">
  @endif

  <h3>Sub-Categories</h3>
  <ul>
    @foreach($category->childrenRecursive as $sub)
      <li>{{ $sub->name }}</li>
    @endforeach
  </ul>

  <a href="{{ route('auction_categories.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
