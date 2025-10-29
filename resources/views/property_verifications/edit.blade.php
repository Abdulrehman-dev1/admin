@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Property Verification</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Status Badge --}}
  <div class="mb-3">
    @switch($verification->status)
      @case('verified')
        <span class="badge bg-success">Verified</span>
        @break
      @case('not_verified')
        <span class="badge bg-warning text-dark">Not Verified</span>
        @break
      @case('declined')
        <span class="badge bg-danger">Declined</span>
        @break
      @case('resubmit')
        <span class="badge bg-info text-dark">Resubmit</span>
        @break
      @default
        <span class="badge bg-secondary">Unknown</span>
    @endswitch
  </div>

  <form action="{{ route('property-verifications.update', $verification->id) }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Property Type</label>
        <input type="text"
               name="property_type"
               class="form-control"
               value="{{ old('property_type', $verification->property_type) }}"
               required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Property Address</label>
        <input type="text"
               name="property_address"
               class="form-control"
               value="{{ old('property_address', $verification->property_address) }}"
               required>
      </div>
    </div>

    {{-- Auction Details --}}
    <div class="mb-3">
      <label class="form-label fw-bold">Auction Details</label>
      @if($verification->auction)
        <p><strong>ID:</strong>   {{ $verification->auction->id   }}</p>
        <p><strong>Title:</strong>{{ $verification->auction->title }}</p>
      @else
        <p class="text-muted">No auction linked.</p>
      @endif
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Title Deed Number</label>
        <input type="text"
               name="title_deed_number"
               class="form-control"
               value="{{ old('title_deed_number', $verification->title_deed_number) }}"
               required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Country</label>
        <input type="text"
               name="country"
               class="form-control"
               value="{{ old('country', $verification->country) }}"
               required>
      </div>
    </div>

    {{-- Documents Preview --}}
    <div class="mb-4">
      <label class="form-label fw-bold">Property Documents</label>
      <div class="d-flex flex-wrap mb-2">
        @foreach($verification->property_documents as $path)
          @php
            $url = asset($path);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
          @endphp

          @if($ext === 'pdf')
            <a href="{{ $url }}" target="_blank" class="m-1" style="font-size:2rem; color:#e74c3c;" title="Open PDF">
              <i class="fa-solid fa-file-pdf"></i>
            </a>
          @else
            <img src="{{ $url }}"
                 class="img-thumbnail m-1 doc-thumb"
                 style="max-height:100px; cursor:pointer"
                 data-bs-toggle="modal"
                 data-bs-target="#docModal"
                 data-src="{{ $url }}">
          @endif
        @endforeach
      </div>
      <p class="form-text">Leave blank to keep existing documents.</p>
    </div>

    <a href="{{ route('property-verifications.index') }}" class="btn btn-secondary">Back</a>
  </form>

  {{-- Accept/Decline Controls --}}
  <div class="mt-4">
    <form action="{{ route('property-verifications.accept',   $verification->id) }}" method="POST" style="display:inline">
      @csrf
      <button class="btn btn-success me-2">Accept</button>
    </form>
    <button class="btn btn-danger" id="decline-btn">Decline</button>
  </div>

  {{-- Decline Reason Form --}}
  <form id="decline-form"
        action="{{ route('property-verifications.decline', $verification->id) }}"
        method="POST"
        style="display:none;"
        class="mt-3">
    @csrf
    <div class="mb-3">
      <label class="form-label fw-bold">Decline Reason</label>
      <textarea name="decline_reason" class="form-control" rows="3" required></textarea>
    </div>
    <button class="btn btn-primary">Submit Decline</button>
  </form>

  {{-- Document Preview Modal --}}
  <div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body p-0">
          <img src="" id="modalImage" class="img-fluid w-100" alt="Document Preview">
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.doc-thumb').forEach(img =>
      img.addEventListener('click', () =>
        document.getElementById('modalImage').src = img.dataset.src
      )
    );

    document.getElementById('decline-btn')?.addEventListener('click', () => {
      document.getElementById('decline-form').style.display = 'block';
    });
  });
</script>
@endpush
@endsection
