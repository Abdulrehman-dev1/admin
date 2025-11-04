@extends('layouts.app')

@section('content')
<div class="container">
  <h1>OLX Scraper</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if(!empty($error))
    <div class="alert alert-danger">{{ $error }}</div>
  @endif
  @if(!empty($exitCode))
    <div class="alert alert-warning">Script exit code: {{ $exitCode }}</div>
  @endif

  <form method="POST" action="{{ route('olx-scraper.preview') }}" class="mb-3">
    @csrf
    <div class="mb-3">
      <label for="url" class="form-label">OLX URL</label>
      <div class="input-group">
        <input id="url" name="url" type="url" class="form-control" placeholder="https://www.olx.com.pk/..." value="{{ old('url', $url ?? '') }}" required>
        <button type="button" class="btn btn-outline-secondary" onclick="openInNewTab()" title="Open URL in new tab">
          <i class="bi bi-box-arrow-up-right"></i> Open
        </button>
      </div>
      @error('url')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-secondary">Preview (No Save)</button>
      <button type="button" class="btn btn-outline-info" onclick="openInNewTab()">
        <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
      </button>
    </div>
  </form>

  <script>
    function openInNewTab() {
      const url = document.getElementById('url').value;
      if (url && url.startsWith('http')) {
        window.open(url, '_blank');
      } else {
        alert('Please enter a valid URL first');
      }
    }
    
    // Update save form URL and selections on input change
    document.getElementById('url')?.addEventListener('input', function() {
      const saveUrlInput = document.querySelector('form[action="{{ route('olx-scraper.save') }}"] input[name="url"]');
      if (saveUrlInput) {
        saveUrlInput.value = this.value;
      }
    });
  </script>

  <!-- Save Form -->
  <form method="POST" action="{{ route('olx-scraper.save') }}" class="card mb-3">
    @csrf
    <div class="card-header">
      <h5 class="mb-0">Save to Database</h5>
    </div>
    <div class="card-body">
      <input type="hidden" name="url" id="save-url" value="{{ old('url', $url ?? '') }}" />
      
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="user_id" class="form-label">User</label>
          <select name="user_id" id="user_id" class="form-select" required>
            <option value="">Select User</option>
            @foreach($users ?? [] as $user)
              <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
          </select>
          @error('user_id')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="category_id" class="form-label">Category</label>
          <select name="category_id" id="category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories ?? [] as $cat)
              @if($cat->parent_id == null)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endif
            @endforeach
          </select>
          @error('category_id')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="sub_category_id" class="form-label">Sub Category (Optional)</label>
          <select name="sub_category_id" id="sub_category_id" class="form-select">
            <option value="">Select Sub Category</option>
          </select>
          @error('sub_category_id')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="child_category_id" class="form-label">Child Category (Optional)</label>
          <select name="child_category_id" id="child_category_id" class="form-select">
            <option value="">Select Child Category</option>
          </select>
          @error('child_category_id')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save to Database</button>
    </div>
  </form>

  @if(!empty($preview))
    <hr />
    <h3>Preview - All Fields</h3>
    
    <div class="card mb-3">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Extracted Data</h5>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <strong>Title:</strong>
            <div class="border p-2 bg-light">{{ $preview['title'] ?? 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <strong>Location:</strong>
            <div class="border p-2 bg-light">{{ $preview['location_text'] ?? 'N/A' }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <strong>Price:</strong>
            <div class="border p-2 bg-light">{{ $preview['price'] ?? 'N/A' }}</div>
          </div>
          <div class="col-md-4">
            <strong>Minimum Bid:</strong>
            <div class="border p-2 bg-light">{{ number_format($preview['minimum_bid'] ?? 0, 2) }} AED</div>
          </div>
          <div class="col-md-4">
            <strong>Reserve Price:</strong>
            <div class="border p-2 bg-light">{{ number_format($preview['reserve_price'] ?? 0, 2) }} AED</div>
          </div>
        </div>

        <div class="mb-3">
          <strong>Description:</strong>
          <div class="border p-2 bg-light" style="max-height:200px; overflow:auto; white-space:pre-wrap;">{{ $preview['description'] ?? 'N/A' }}</div>
        </div>

        <div class="mb-3">
          <strong>Images ({{ $preview['image_count'] ?? 0 }}):</strong>
          <div class="row g-2 mt-2">
            @php($imgs = $preview['images'] ?? [])
            @if(!empty($imgs) && is_array($imgs))
              @foreach($imgs as $img)
                <div class="col-6 col-md-3">
                  <img src="{{ $img }}" class="img-fluid border" style="max-height:150px; object-fit:cover; width:100%;" alt="Image">
                </div>
              @endforeach
            @else
              <div class="col-12">No images found</div>
            @endif
          </div>
        </div>

        @if(!empty($preview['amenities']))
          <div class="mb-3">
            <strong>Amenities:</strong>
            <div class="border p-2 bg-light">
              @if(is_array($preview['amenities']))
                <ul class="mb-0">
                  @foreach($preview['amenities'] as $amenity)
                    <li>{{ $amenity }}</li>
                  @endforeach
                </ul>
              @else
                {{ $preview['amenities'] }}
              @endif
            </div>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if(!empty($raw))
    <hr />
    <details>
      <summary><strong>Raw Output (for debugging)</strong></summary>
      <pre class="border p-3 bg-light" style="max-height:300px; overflow:auto; white-space:pre-wrap; font-size:12px;">{{ $raw }}</pre>
    </details>
  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Category hierarchy loading
  document.getElementById('category_id')?.addEventListener('change', function() {
    const categoryId = this.value;
    const subCategorySelect = document.getElementById('sub_category_id');
    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
    
    if (categoryId) {
      fetch(`/get-subcategories/${categoryId}`)
        .then(res => res.json())
        .then(data => {
          if (data.subcategories && Array.isArray(data.subcategories)) {
            data.subcategories.forEach(sub => {
              const option = document.createElement('option');
              option.value = sub.id;
              option.textContent = sub.name;
              subCategorySelect.appendChild(option);
            });
          }
        })
        .catch(err => console.error('Error loading subcategories:', err));
    }
  });

  document.getElementById('sub_category_id')?.addEventListener('change', function() {
    const subCategoryId = this.value;
    const childCategorySelect = document.getElementById('child_category_id');
    childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
    
    if (subCategoryId) {
      fetch(`/get-children/${subCategoryId}`)
        .then(res => res.json())
        .then(data => {
          if (data.subcategories && Array.isArray(data.subcategories)) {
            data.subcategories.forEach(child => {
              const option = document.createElement('option');
              option.value = child.id;
              option.textContent = child.name;
              childCategorySelect.appendChild(option);
            });
          }
        })
        .catch(err => console.error('Error loading child categories:', err));
    }
  });
</script>
@endsection

