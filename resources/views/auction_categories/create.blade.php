{{-- resources/views/auction_categories/form.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h1>

  <form 
    action="{{ isset($category) 
                ? route('auction_categories.update', $category->id) 
                : route('auction_categories.store') }}"
    method="POST" 
    enctype="multipart/form-data"
  >
    @csrf
    @if(isset($category))
      @method('PUT')
    @endif

    {{-- Name --}}
    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input 
        type="text" 
        name="name" 
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $category->name ?? '') }}"
        required
      >
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Parent --}}
    <div class="mb-3">
      <label for="parent_id" class="form-label">Parent Category (Optional)</label>
      <select 
        name="parent_id" 
        id="parent_id"
        class="form-select @error('parent_id') is-invalid @enderror"
      >
        <option value="">— Top Level —</option>
        @foreach($parents as $p)
          <option 
            value="{{ $p->id }}"
            {{ old('parent_id', $category->parent_id ?? '') == $p->id ? 'selected' : '' }}
          >{{ $p->name }}</option>
        @endforeach
      </select>
      @error('parent_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Sub-category --}}
    <div class="mb-3">
      <label for="sub_category_id" class="form-label">Subcategory (Optional)</label>
      <select 
        name="sub_category_id" 
        id="sub_category_id"
        class="form-select @error('sub_category_id') is-invalid @enderror"
      >
        <option value="">— None —</option>
        @foreach($subCategories as $s)
          <option 
            value="{{ $s->id }}"
            {{ old('sub_category_id', $category->sub_category_id ?? '') == $s->id ? 'selected' : '' }}
          >{{ $s->name }}</option>
        @endforeach
      </select>
      @error('sub_category_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Image --}}
    <div class="mb-3">
      <label for="image" class="form-label">Category Image</label>
      <input 
        type="file" 
        name="image" 
        id="image"
        class="form-control @error('image') is-invalid @enderror"
      >
      @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror

      @if(isset($category) && $category->image)
        <div class="mt-2">
          <img 
            src="{{ asset($category->image) }}" 
            alt="" 
            class="img-thumbnail" 
            width="100"
          >
        </div>
      @endif
    </div>

    <button type="submit" 
            class="btn {{ isset($category) ? 'btn-primary' : 'btn-success' }}">
      {{ isset($category) ? 'Update' : 'Create' }}
    </button>
    <a href="{{ route('auction_categories.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const parentSelect = document.getElementById('parent_id');
  const subSelect    = document.getElementById('sub_category_id');

  parentSelect.addEventListener('change', () => {
    const parentId = parentSelect.value;
    subSelect.innerHTML = '<option value="">— None —</option>';

    if (!parentId) return;

    fetch(`/get-subcategories/${parentId}`)
      .then(res => res.json())
      .then(data => {
        data.subcategories.forEach(sub => {
          const opt = document.createElement('option');
          opt.value   = sub.id;
          opt.text    = sub.name;
          subSelect.appendChild(opt);
        });
      })
      .catch(console.error);
  });
});
</script>
@endpush
