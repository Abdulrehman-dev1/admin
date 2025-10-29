@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Auction Status</h1>

  <form action="{{ route('auctionstatus.update', $auction->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- — Hidden current status (we’ll overwrite via action buttons) --}}
    <input type="hidden" name="status" value="{{ $auction->status }}">

    {{-- — Display Auction details read-only --}}
    <div class="mb-3">
      <label class="fw-bold">Title</label>
      <p class="form-control-plaintext">{{ $auction->title }}</p>
    </div>

    <div class="mb-3">
      <label class="fw-bold">Reserve Price</label>
      <p class="form-control-plaintext">{{ $auction->reserve_price }}</p>
    </div>

    <div class="mb-3">
      <label class="fw-bold">Minimum Bid</label>
      <p class="form-control-plaintext">{{ $auction->minimum_bid }}</p>
    </div>

    <div class="mb-3">
      <label class="fw-bold">Start Date</label>
      <p class="form-control-plaintext">{{ $auction->start_date }}</p>
    </div>

    <div class="mb-3">
      <label class="fw-bold">End Date</label>
      <p class="form-control-plaintext">{{ $auction->end_date }}</p>
    </div>

    @if($auction->album)
      <div class="mb-3">
        <label class="fw-bold">Images</label>
        <div class="d-flex flex-wrap">
          @foreach(json_decode($auction->album, true) as $img)
            <img src="{{ asset($img) }}"
                 style="max-width:120px; margin:5px; object-fit:cover;">
          @endforeach
        </div>
      </div>
    @endif

    {{-- — Approve / Decline buttons --}}
    <div id="action-buttons" class="mt-4">
      <button
        type="submit"
        name="action"
        value="accept"
        class="btn btn-success me-2"
        formnovalidate
      >Approve</button>

      <button
        type="button"
        id="decline-btn"
        class="btn btn-danger"
      >Decline</button>
    </div>

    {{-- — Decline reason textarea (hidden until you click “Decline”) --}}
    <div id="decline-area" class="mt-4" style="display:none;">
      <div class="form-group mb-3">
        <label class="fw-bold">Decline Reason</label>
        <textarea
          id="decline-reason"
          name="decline_reason"
          class="form-control"
          rows="4"
        ></textarea>
      </div>
      <button
        type="submit"
        name="action"
        value="decline"
        class="btn btn-primary"
      >Send</button>
    </div>
  </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const declineBtn    = document.getElementById('decline-btn');
  const actionButtons = document.getElementById('action-buttons');
  const declineArea   = document.getElementById('decline-area');
  const reasonField   = document.getElementById('decline-reason');

  declineBtn.addEventListener('click', function() {
    actionButtons.style.display = 'none';
    declineArea.style.display   = 'block';
    reasonField.required        = true;
  });
});
</script>
@endpush
