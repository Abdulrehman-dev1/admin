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

    {{-- Slug --}}
    <div class="mb-3">
      <label for="slug" class="form-label">Slug (Optional)</label>
      <input 
        type="text" 
        name="slug" 
        id="slug"
        class="form-control @error('slug') is-invalid @enderror"
        value="{{ old('slug', $category->slug ?? '') }}"
      >
      <div class="form-text">Leave empty to auto-generate from name.</div>
      @error('slug')
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

    {{-- SEO Section --}}
    <div class="card mb-4 mt-5">
      <div class="card-header bg-light">
          <h5 class="mb-0">SEO Configuration</h5>
      </div>
      <div class="card-body">
          {{-- Meta Title --}}
          <div class="mb-3">
              <label for="meta_title" class="form-label">Meta Title</label>
              <input type="text" name="meta_title" id="meta_title"
                  class="form-control @error('meta_title') is-invalid @enderror"
                  value="{{ old('meta_title', $category->meta_title ?? '') }}">
              @error('meta_title')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          {{-- Meta Description --}}
          <div class="mb-3">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea name="meta_description" id="meta_description" rows="3"
                  class="form-control rich-editor @error('meta_description') is-invalid @enderror">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
              @error('meta_description')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          {{-- SEO Content --}}
          <div class="mb-3">
              <label for="seo_content" class="form-label">SEO Content (Displayed on Page)</label>
              <textarea name="seo_content" id="seo_content" rows="5"
                  class="form-control rich-editor @error('seo_content') is-invalid @enderror">{{ old('seo_content', $category->seo_content ?? '') }}</textarea>
              <div class="form-text">This content will be displayed on the category page. Supports text.</div>
              @error('seo_content')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          {{-- SEO Short Content --}}
          <div class="mb-3">
              <label for="seo_short_content" class="form-label">SEO Short Content</label>
              <textarea name="seo_short_content" id="seo_short_content" rows="3"
                  class="form-control rich-editor @error('seo_short_content') is-invalid @enderror">{{ old('seo_short_content', $category->seo_short_content ?? '') }}</textarea>
              <div class="form-text">Short version of SEO content. Supports text.</div>
              @error('seo_short_content')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          {{-- Schema Markup --}}
          <div class="mb-3">
              <label for="schema_markup" class="form-label">Schema Markup (JSON-LD)</label>
              <textarea name="schema_markup" id="schema_markup" rows="5"
                  class="form-control @error('schema_markup') is-invalid @enderror" style="font-family: monospace; font-size: 0.9em;">{{ old('schema_markup', $category->schema_markup ?? '') }}</textarea>
              <div class="form-text">Paste valid JSON-LD schema here (without &lt;script&gt; tags logic, just the JSON object or array).</div>
              @error('schema_markup')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
      </div>
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

  // Function to clear and load categories
  const loadCategories = (parentId, targetSelect, urlPath) => {
    targetSelect.innerHTML = '<option value="">— Loading... —</option>';
    
    fetch(`${urlPath}/${parentId}`)
      .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
      })
      .then(data => {
        targetSelect.innerHTML = '<option value="">— None —</option>';
        const categories = data.subcategories || data.categories || [];
        categories.forEach(item => {
          const opt = document.createElement('option');
          opt.value = item.id;
          opt.text = item.name;
          targetSelect.appendChild(opt);
        });
      })
      .catch(err => {
        console.error('Fetch error:', err);
        targetSelect.innerHTML = '<option value="">— Error loading —</option>';
      });
  };

  parentSelect.addEventListener('change', () => {
    const parentId = parentSelect.value;
    subSelect.innerHTML = '<option value="">— None —</option>';
    if (!parentId) return;
    loadCategories(parentId, subSelect, "{{ url('/get-subcategories') }}");
  });

  // Check if we need to load subcategories on page load (for edit view)
  if (parentSelect.value && subSelect.options.length <= 1) {
     // This is handled by Blade @foreach normally, but good to have as fallback or if we want to refresh
  }
});
</script>

{{-- CKEditor Integration --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
(function () {
  const editors = [];
  const $$ = (sel, root=document) => Array.from(root.querySelectorAll(sel));

  $$('.rich-editor').forEach(el => {
    ClassicEditor.create(el, { })
    .then(editor => {
      // Sync on change
      editor.model.document.on('change:data', () => {
        el.value = editor.getData();
      });
      // Store reference
      editors.push({ editor, el });
    })
    .catch(err => console.error('CKE init error:', err));
  });

  // Force sync on submit
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', () => {
      editors.forEach(({ editor, el }) => {
        el.value = editor.getData();
      });
    });
  }
})();
</script>
@endpush
