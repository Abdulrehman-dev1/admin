@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Individual Verification</h1>
{{-- Status Badge --}}
  <div>
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

    {{-- Flash Message --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('individual-verifications.update', $verification->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Status --}}
        

   
        {{-- Full Legal Name --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Full Legal Name</label>
            <input type="text" class="form-control" name="full_legal_name"
                   value="{{ old('full_legal_name', $verification->full_legal_name) }}" required>
        </div>

        {{-- Date of Birth --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Date of Birth</label>
            <input type="date" class="form-control" name="dob"
                   value="{{ old('dob', $verification->dob) }}" required>
        </div>

        {{-- Nationality --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Nationality</label>
            <input type="text" class="form-control" name="nationality"
                   value="{{ old('nationality', $verification->nationality) }}" required>
        </div>

        {{-- Residential Address --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Residential Address</label>
            <input type="text" class="form-control" name="residential_address"
                   value="{{ old('residential_address', $verification->residential_address) }}" required>
        </div>

        {{-- ID Document (Front) --}}
<div class="form-group mb-3">
  <label class="fw-bold">ID Document (Front)</label><br>
  @if($verification->id_front_path)
    @php
      $path = $verification->id_front_path;
      $url  = asset($path);
      $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    @endphp

    @if($ext === 'pdf')
      {{-- PDF icon opens in new tab --}}
      <a href="{{ $url }}" target="_blank" class="m-1" style="font-size:2rem; color:#e74c3c;">
        <i class="fa-solid fa-file-pdf"></i>
      </a>
    @else
      {{-- Image thumbnail opens modal --}}
      <img
        src="{{ $url }}"
        alt="Front of ID"
        width="90"
        class="img-thumbnail doc-thumb"
        data-bs-toggle="modal"
        data-bs-target="#docModal"
        data-src="{{ $url }}"
      >
    @endif
  @endif

  {{-- File input field if you allow re-upload --}}
  <input type="file" name="id_front" accept="image/*,application/pdf" class="form-control mt-2 d-none">
</div>

{{-- ID Document (Back) --}}
<div class="form-group mb-3">
  <label class="fw-bold">ID Document (Back)</label><br>
  @if($verification->id_back_path)
    @php
      $path = $verification->id_back_path;
      $url  = asset($path);
      $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    @endphp

    @if($ext === 'pdf')
      <a href="{{ $url }}" target="_blank" class="m-1" style="font-size:2rem; color:#e74c3c;">
        <i class="fa-solid fa-file-pdf"></i>
      </a>
    @else
      <img
        src="{{ $url }}"
        alt="Back of ID"
        width="90"
        class="img-thumbnail doc-thumb"
        data-bs-toggle="modal"
        data-bs-target="#docModal"
        data-src="{{ $url }}"
      >
    @endif
  @endif

  <input type="file" name="id_back" accept="image/*,application/pdf" class="form-control mt-2 d-none">
</div>


        {{-- Contact Number --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Contact Number</label>
            <input type="text" class="form-control" name="contact_number"
                   value="{{ old('contact_number', $verification->contact_number) }}" required>
        </div>

        {{-- Email Address --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Email Address</label>
            <input type="email" class="form-control" name="email_address"
                   value="{{ old('email_address', $verification->email_address) }}" required>
        </div>

        {{-- Country --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Country</label>
            <input type="text" class="form-control" name="country"
                   value="{{ old('country', $verification->country) }}" required>
        </div>

        {{-- Save Button --}}
       {{--<button class="btn btn-success">Update</button>--}}
        <a href="{{ route('individual-verifications.index') }}" class="btn btn-secondary">Back</a>
    </form>

<div class="mt-4">
  {{-- Accept Form --}}
  <form action="{{ route('individual-verifications.accept', $verification->id) }}"
        method="POST"
        style="display:inline;">
    @csrf
    <button class="btn btn-info me-2">Accept (Verify)</button>
  </form>

  {{-- Decline Button --}}
  <button class="btn btn-danger" id="decline-btn">Decline</button>
</div>

<form id="decline-form"
      action="{{ route('individual-verifications.decline', $verification->id) }}"
      method="POST"
      style="display:none;"
      class="mt-3">
  @csrf
  <div class="form-group">
    <label class="fw-bold">Decline Reason</label>
    <textarea name="decline_reason" class="form-control" rows="3" required></textarea>
  </div>
  <button class="btn btn-primary mt-2">Submit Decline</button>
</form>

    {{-- Modal for image preview --}}
    <div class="modal fade" id="docModal" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-body p-0">
            <img src="" id="modalImage" class="img-fluid w-100" alt="Document Preview"/>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.doc-thumb').forEach(function(img) {
    img.addEventListener('click', function() {
      document.getElementById('modalImage').src = this.getAttribute('data-src');
    });
  });
});
   document.addEventListener('DOMContentLoaded', function() {
    const declineBtn  = document.getElementById('decline-btn');
    const declineForm = document.getElementById('decline-form');
    if (!declineBtn || !declineForm) return;

    declineBtn.addEventListener('click', function() {
      // hide the button
      declineBtn.style.display = 'none';
      // show the form
      declineForm.style.display = 'block';
    });
  });
</script>
@endpush
