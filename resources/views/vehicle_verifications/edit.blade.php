@extends('layouts.app')

@section('content')



@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container">
  <h1>Edit Vehicle Verification</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="mb-3">
 @switch($verification->status)
  @case('verified')   <span class="badge bg-success">Verified</span>        @break
  @case('not_verified')<span class="badge bg-warning text-dark">Not Verified</span>@break
  @case('declined')   <span class="badge bg-danger">Declined</span>         @break
  @case('resubmit')   <span class="badge bg-info text-dark">Resubmit</span>  @break
  @default            <span class="badge bg-secondary">Unknown</span>
@endswitch

  </div>

  <form action="{{ route('vehicle-verifications.update', $verification->id) }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Vehicle Make & Model</label>
        <input type="text"
               name="vehicle_make_model"
               class="form-control"
               value="{{ old('vehicle_make_model', $verification->vehicle_make_model) }}"
               required>
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Year of Manufacture</label>
        <input type="number"
               name="year_of_manufacture"
               class="form-control"
               value="{{ old('year_of_manufacture', $verification->year_of_manufacture) }}"
               required>
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Chassis / VIN</label>
        <input type="text"
               name="chassis_vin"
               class="form-control"
               value="{{ old('chassis_vin', $verification->chassis_vin) }}"
               required>
      </div>
    
    </div>
    <div class="mb-3">
  <label class="form-label">User Details</label>
  @if($verification->user)
    <p>
      <strong>ID:</strong>   {{ $verification->user->id }}<br>
      <strong>Name:</strong> {{ $verification->user->name }}<br>
      <strong>Email:</strong> {{ $verification->user->email }}
    </p>
  @else
    <p class="text-muted">No user linked.</p>
  @endif
</div>

{{-- Auction Details --}}
<div class="mb-3">
  <label class="form-label">Auction Details</label>
  @if($verification->auction)
    <p>
      <strong>ID:</strong>   {{ $verification->auction->id }}<br>
      <strong>Name:</strong> {{ $verification->auction->title }}
    </p>
  @else
    <p class="text-muted">No auction linked.</p>
  @endif
</div>

   {{-- documents preview --}}
<div class="d-flex flex-wrap mb-2">
  @foreach($verification->vehicle_documents as $path)
    @php
      $url = asset($path);
      $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    @endphp

    @if($ext === 'pdf')
      <a href="{{ $url }}" target="_blank" class="m-1" style="font-size:2rem; color:#e74c3c;">
        <i class="fa-solid fa-file-pdf"></i>
      </a>
    @else
      <img
        src="{{ $url }}"
        class="img-thumbnail m-1 doc-thumb"
        style="max-height:100px; cursor:pointer"
        data-bs-toggle="modal"
        data-bs-target="#docModal"
        data-src="{{ $url }}"
      >
    @endif
  @endforeach
</div>
    {{-- Hidden status selector, if you need to override --}}
    <div class="d-none">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="not_verified" {{ $verification->status==='not_verified'?'selected':'' }}>Not Verified</option>
        <option value="verified"     {{ $verification->status==='verified'    ?'selected':'' }}>Verified</option>
      </select>
    </div>

   {{-- <button class="btn btn-primary">Save Changes</button>--}}
    <a href="{{ route('vehicle-verifications.index') }}" class="btn btn-secondary">Back</a>
  </form>

  {{-- Accept/Decline Controls --}}

    <div class="mt-4">
      <form action="{{ route('vehicle-verifications.accept', $verification->id) }}"
            method="POST" style="display:inline">
        @csrf
        <button class="btn btn-success me-2">Accept</button>
      </form>
      <button class="btn btn-danger" id="decline-btn">Decline</button>
    </div>
    <form id="decline-form"
          action="{{ route('vehicle-verifications.decline', $verification->id) }}"
          method="POST"
          style="display:none;"
          class="mt-3">
      @csrf
      <div class="mb-3">
        <label class="form-label">Decline Reason</label>
        <textarea name="decline_reason" class="form-control" rows="3" required></textarea>
      </div>
      <button class="btn btn-primary">Submit Decline</button>
    </form>


  {{-- Modal for document preview --}}
<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content"><img src="" id="modalImage" class="img-fluid w-100"></div>
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

    // decline form toggle
    document.getElementById('decline-btn')?.addEventListener('click', () => {
      document.getElementById('decline-form').style.display = 'block';
    });
  });
</script>
@endpush
@endsection
