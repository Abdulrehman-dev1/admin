@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Identity</h1>

    <form action="{{ route('identities.update', $identity->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Status --}}
          <div>
    @if($identity->status === 'verified')
      <span class="badge bg-success">Verified</span>
    @else
      <span class="badge bg-warning text-dark">Not Verified</span>
    @endif
  </div>

        <div class="form-group mb-3  d-none">
            <label for="status" class="fw-bold">Verification Status</label>
            <select name="status" id="status" class="form-control shadow-lg">
                <option value="not_verified" {{ $identity->status == 'not_verified' ? 'selected' : '' }}>
                  Not Verified
                </option>
                <option value="verified" {{ $identity->status == 'verified' ? 'selected' : '' }}>
                  Verified
                </option>
            </select>
        </div>

        {{-- User Type --}}
        <div class="form-group mb-3">
            <label class="fw-bold">User Type</label>
            <input type="text" class="form-control" 
                   value="{{ ucfirst($identity->user_type) }}" readonly>
        </div>

        @if($identity->user_type === 'individual')
            {{-- Individual fields --}}
            <div class="form-group mb-3">
                <label class="fw-bold">Full Legal Name</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->full_legal_name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Date of Birth</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->dob }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Nationality</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->nationality }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Residential Address</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->residential_address }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Contact Number</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->contact_number }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Email Address</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->email_address }}" readonly>
            </div>

            {{-- ID Documents --}}
            <div class="form-group mb-4">
                <label class="fw-bold">ID Documents</label>
                <div class="d-flex flex-wrap">
                    @foreach($identity->id_documents as $path)
                        <img
                          src="{{ asset($path) }}"
                          alt="ID Document"
                          class="doc-thumb m-1"
                          style="max-width:150px; max-height:150px; object-fit:cover; cursor:pointer; border:1px solid #ddd; padding:2px;"
                          data-bs-toggle="modal"
                          data-bs-target="#docModal"
                          data-src="{{ asset($path) }}"
                        />
                    @endforeach
                </div>
            </div>
        @else
            {{-- Corporate fields --}}
            <div class="form-group mb-3">
                <label class="fw-bold">Legal Entity Name</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->legal_entity_name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Registered Address</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->registered_address }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Date of Incorporation</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->date_of_incorporation }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Entity Type</label>
                <input type="text" class="form-control" 
                       value="{{ $identity->entity_type }}" readonly>
            </div>

            @php
              $bizDocs = $identity->business_documents;
              if (is_string($bizDocs)) {
                  $bizDocs = json_decode($bizDocs, true) ?: [];
              }
              if (is_null($bizDocs)) {
                  $bizDocs = [];
              }
            @endphp

            {{-- Business Documents --}}
            <div class="form-group mb-4">
                <label class="fw-bold">Business Documents</label>
                @if(count($bizDocs))
                  <div class="d-flex flex-wrap">
                    @foreach($bizDocs as $path)
                      <img
                        src="{{ asset($path) }}"
                        alt="Business Document"
                        class="doc-thumb m-1"
                        style="max-width:150px; max-height:150px; object-fit:cover; cursor:pointer; border:1px solid #ddd; padding:2px;"
                        data-bs-toggle="modal"
                        data-bs-target="#docModal"
                        data-src="{{ asset($path) }}"
                      />
                    @endforeach
                  </div>
                @else
                  <p class="form-control-plaintext">No business documents uploaded.</p>
                @endif
            </div>
        @endif

        {{-- Common fields --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Country</label>
            <input type="text" class="form-control mb-3" 
                   value="{{ $identity->country }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Listing Type</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->listing_type }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Vehicle Make & Model</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->vehicle_make_model }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Year of Manufacture</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->year_of_manufacture }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Chassis VIN</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->chassis_vin }}" readonly>
        </div>

        @php
          $vehDocs = $identity->vehicle_documents;
          if (is_string($vehDocs)) {
              $vehDocs = json_decode($vehDocs, true) ?: [];
          }
          if (is_null($vehDocs)) {
              $vehDocs = [];
          }
        @endphp

        {{-- Vehicle Documents --}}
        <div class="form-group mb-4">
            <label class="fw-bold">Vehicle Documents</label>
            @if(count($vehDocs))
              <div class="d-flex flex-wrap">
                @foreach($vehDocs as $path)
                  <img
                    src="{{ asset($path) }}"
                    alt="Vehicle Document"
                    class="doc-thumb m-1"
                    style="max-width:150px; max-height:150px; object-fit:cover; cursor:pointer; border:1px solid #ddd; padding:2px;"
                    data-bs-toggle="modal"
                    data-bs-target="#docModal"
                    data-src="{{ asset($path) }}"
                  />
                @endforeach
              </div>
            @else
              <p class="form-control-plaintext">No vehicle documents uploaded.</p>
            @endif
        </div>

        {{-- Property Info --}}
        <div class="form-group mb-3">
            <label class="fw-bold">Property Type</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->property_type }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Property Address</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->property_address }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label class="fw-bold">Title Deed Number</label>
            <input type="text" class="form-control" 
                   value="{{ $identity->title_deed_number }}" readonly>
        </div>

        @php
          $propDocs = $identity->property_documents;
          if (is_string($propDocs)) {
              $propDocs = json_decode($propDocs, true) ?: [];
          }
          if (is_null($propDocs)) {
              $propDocs = [];
          }
        @endphp

        {{-- Property Documents --}}
        <div class="form-group mb-4">
            <label class="fw-bold">Property Documents</label>
            @if(count($propDocs))
              <div class="d-flex flex-wrap">
                @foreach($propDocs as $path)
                  <img
                    src="{{ asset($path) }}"
                    alt="Property Document"
                    class="doc-thumb m-1"
                    style="max-width:150px; max-height:150px; object-fit:cover; cursor:pointer; border:1px solid #ddd; padding:2px;"
                    data-bs-toggle="modal"
                    data-bs-target="#docModal"
                    data-src="{{ asset($path) }}"
                  />
                @endforeach
              </div>
            @else
              <p class="form-control-plaintext">No property documents uploaded.</p>
            @endif
        </div>

        {{-- Save Button --}}
        {{-- ACTION BUTTONS --}}
      <div id="action-buttons" class="mt-4">
       <button 
  type="submit" 
  name="action" 
  value="accept"
  formnovalidate 
  class="btn btn-info me-2"
>
  Approve
</button>
        <button type="button" id="decline-btn" class="btn btn-primary">
          Decline
        </button>
      </div>
       {{-- DECLINE REASON — hidden until “Decline” clicked --}}
      <div id="decline-area" class="mt-4" style="display:none;">
        <div class="form-group mb-3">
          <label class="fw-bold">Decline Reason</label>
          <textarea name="decline_reason"  id="decline-reason" class="form-control" rows="4" ></textarea>
        </div>
        <button type="submit" name="action" value="decline" class="btn btn-primary">
          Send
        </button>
      </div>


        <button type="submit" class="d-none btn btn-primary">Update Status</button>
    </form>

    {{-- Shared Modal for all docs --}}
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
  const declineBtn    = document.getElementById('decline-btn');
  const actionButtons = document.getElementById('action-buttons');
  const declineArea   = document.getElementById('decline-area');
  const reasonField   = document.getElementById('decline-reason');

  if (declineBtn && actionButtons && declineArea) {
    declineBtn.addEventListener('click', function() {
      actionButtons.style.display = 'none';
      declineArea.style.display   = 'block';
      // yahan add karo:
      if (reasonField) reasonField.required = true;
    });
  }

  document.querySelectorAll('.doc-thumb').forEach(function(img) {
    img.addEventListener('click', function() {
      document.getElementById('modalImage').src = this.getAttribute('data-src');
    });
  });
});
</script>
@endpush
