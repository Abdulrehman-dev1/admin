@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Property Scraper</h1>

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

  <form method="POST" action="{{ route('scraper.preview') }}" class="mb-3">
    @csrf
    <div class="mb-3">
      <label for="url" class="form-label">PropertyFinder URL</label>
      <div class="input-group">
        <input id="url" name="url" type="url" class="form-control" placeholder="https://www.propertyfinder.ae/..." value="{{ old('url', $url ?? '') }}" required>
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
    
    // Update save form URL on input change
    document.getElementById('url')?.addEventListener('input', function() {
      const saveUrlInput = document.querySelector('form[action="{{ route('scraper.save') }}"] input[name="url"]');
      if (saveUrlInput) {
        saveUrlInput.value = this.value;
      }
    });
  </script>

  <form method="POST" action="{{ route('scraper.save') }}">
    @csrf
    <input type="hidden" name="url" id="save-url" value="{{ old('url', $url ?? '') }}" />
    <button type="submit" class="btn btn-primary">Save to Database</button>
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
            <strong>Price (AED):</strong>
            <div class="border p-2 bg-light">AED {{ number_format($preview['price_aed'] ?? 0, 2) }}</div>
          </div>
          <div class="col-md-4">
            <strong>Minimum Bid:</strong>
            <div class="border p-2 bg-light">AED {{ number_format($preview['minimum_bid'] ?? 0, 2) }}</div>
          </div>
          <div class="col-md-4">
            <strong>Reserve Price:</strong>
            <div class="border p-2 bg-light">AED {{ number_format($preview['reserve_price'] ?? 0, 2) }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <strong>Category:</strong>
            <div class="border p-2 bg-light">{{ $preview['category'] ?? 'N/A' }}</div>
          </div>
          <div class="col-md-4">
            <strong>Sub Category:</strong>
            <div class="border p-2 bg-light">{{ $preview['sub_category'] ?? 'N/A' }}</div>
          </div>
          <div class="col-md-4">
            <strong>Child Category (Property Type):</strong>
            <div class="border p-2 bg-light">{{ $preview['child_category'] ?? ($preview['property_type'] ?? 'N/A') }}</div>
          </div>
        </div>

        <div class="mb-3">
          <strong>Property Type (Raw):</strong>
          <div class="border p-2 bg-light">{{ $preview['property_type_raw'] ?? ($preview['property_type'] ?? 'N/A') }}</div>
        </div>

        <div class="mb-3">
          <strong>Description:</strong>
          <div class="border p-2 bg-light" style="max-height:200px; overflow:auto; white-space:pre-wrap;">{{ $preview['description'] ?? 'N/A' }}</div>
        </div>

        <div class="mb-3">
          <strong>Amenities ({{ $preview['amenities_count'] ?? 0 }}):</strong>
          <div class="border p-2 bg-light">
            @if(!empty($preview['amenities']) && is_array($preview['amenities']))
              <ul class="mb-0">
                @foreach($preview['amenities'] as $amenity)
                  <li>{{ $amenity }}</li>
                @endforeach
              </ul>
            @else
              N/A
            @endif
          </div>
        </div>

        <div class="mb-3">
          <strong>Images ({{ $preview['image_count'] ?? 0 }}):</strong>
          <div class="row g-2 mt-2">
            @php($imgs = $preview['images'] ?? [])
            @if(!empty($imgs) && is_array($imgs))
              @foreach($imgs as $img)
                <div class="col-6 col-md-3">
                  <img src="{{ $img }}" class="img-fluid border" style="max-height:150px; object-fit:cover; width:100%;" />
                </div>
              @endforeach
            @else
              <div class="col-12"><em>No images found</em></div>
            @endif
          </div>
        </div>
      </div>
    </div>

    @if(!empty($preview['html']))
      <details class="mt-3">
        <summary class="btn btn-outline-secondary">Show HTML Sections (Debug)</summary>
        <div class="border p-2 mt-2" style="max-height:400px; overflow:auto;">
          {!! $preview['html'] !!}
        </div>
      </details>
    @endif
  @endif

  @if(!empty($raw))
    <details class="mt-4">
      <summary>Raw output</summary>
      <pre class="border p-2" style="white-space:pre-wrap">{{ $raw }}</pre>
    </details>
  @endif

</div>
@endsection


