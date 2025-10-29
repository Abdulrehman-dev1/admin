@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Corporate Verification</h1>

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

  <form action="{{ route('corporate-verifications.update', $verification->id) }}" 
        method="POST" 
        enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Hidden status select (optional) --}}
    <div class="d-none mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="not_verified" {{ $verification->status==='not_verified'?'selected':'' }}>Not Verified</option>
        <option value="verified"    {{ $verification->status==='verified'   ?'selected':'' }}>Verified</option>
      </select>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Legal Entity Name</label>
        <input type="text" name="legal_entity_name" class="form-control"
               value="{{ old('legal_entity_name', $verification->legal_entity_name) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Registered Address</label>
        <input type="text" name="registered_address" class="form-control"
               value="{{ old('registered_address', $verification->registered_address) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Date of Incorporation</label>
        <input type="date" name="date_of_incorporation" class="form-control"
               value="{{ old('date_of_incorporation', $verification->date_of_incorporation->format('Y-m-d')) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Type of Entity</label>
        <input type="text" name="entity_type" class="form-control"
               value="{{ old('entity_type', $verification->entity_type) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control"
               value="{{ old('country', $verification->country) }}" required>
      </div>
    </div>

   <div class="mb-4">
  <label class="form-label fw-bold">Business Documents</label>

  @if(is_array($verification->business_documents) && count($verification->business_documents))
    <div class="d-flex flex-wrap mb-2">
      @foreach($verification->business_documents as $path)
        @php
          $url = asset($path);
          $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        @endphp

        @if(in_array($ext, ['jpg','jpeg','png','gif']))
          {{-- Image preview with Bootstrap modal trigger --}}
          <img
            src="{{ $url }}"
            class="img-thumbnail m-1 doc-thumb"
            style="max-height:100px; cursor:pointer"
            data-bs-toggle="modal"
            data-bs-target="#docModal"
            data-src="{{ $url }}"
          >
        @elseif($ext === 'pdf')
          {{-- PDF icon linking to new tab --}}
          <a
            href="{{ $url }}"
            target="_blank"
            class="m-1"
            style="font-size:2rem; color:#e74c3c;"
            title="Open PDF"
          >
            <i class="fa-solid fa-file-pdf"></i>
          </a>
        @endif
      @endforeach
    </div>
  @else
    <p class="form-text">No documents uploaded.</p>
  @endif
</div>
    <!--<button type="submit" class="btn btn-primary">Save Changes</button>-->
    <a href="{{ route('corporate-verifications.index') }}" class="btn btn-secondary">Back</a>
  </form>

  {{-- Accept/Decline controls --}}

    <div class="mt-4">
      <form action="{{ route('corporate-verifications.accept', $verification->id) }}" method="POST" style="display:inline">
        @csrf
        <button class="btn btn-success me-2">Accept</button>
      </form>
      <button class="btn btn-danger" id="decline-btn">Decline</button>
    </div>

    {{-- Decline reason --}}
    <form id="decline-form" action="{{ route('corporate-verifications.decline', $verification->id) }}" method="POST" style="display:none" class="mt-3">
      @csrf
      <div class="mb-3">
        <label class="form-label">Decline Reason</label>
        <textarea name="decline_reason" class="form-control" rows="3" required></textarea>
      </div>
      <button class="btn btn-primary">Submit Decline</button>
    </form>

 {{-- Bootstrap Modal --}}
<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <img src="" id="docModalImg" class="img-fluid" alt="Document preview">
    </div>
  </div>
</div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Image‐thumbnail click → swap modal image src
    document.querySelectorAll('.doc-thumb').forEach(function(el) {
      el.addEventListener('click', function() {
        document.getElementById('docModalImg').src = this.getAttribute('data-src');
      });
    });

    // Decline button toggles the decline‐form
    const declineBtn  = document.getElementById('decline-btn');
    const declineForm = document.getElementById('decline-form');
    if (declineBtn && declineForm) {
      declineBtn.addEventListener('click', function() {
        declineForm.style.display = 'block';
      });
    }
  });
</script>

@endpush
