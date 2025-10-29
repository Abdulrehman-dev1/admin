@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Vehicle Verifications</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Make & Model</th>
        <th>Year</th>
        <th>VIN</th>
        <th>Country</th>
        <th>Status</th>
        <th>Requested At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($verifications as $v)
        <tr>
          <td>{{ $v->id }}</td>
          <td>{{ $v->vehicle_make_model }}</td>
          <td>{{ $v->year_of_manufacture }}</td>
          <td>{{ $v->chassis_vin }}</td>
          <td>{{ $v->country }}</td>
          <td>
           @switch($v->status)
  @case('verified')   <span class="badge bg-success">Verified</span>        @break
  @case('not_verified')<span class="badge bg-warning text-dark">Not Verified</span>@break
  @case('declined')   <span class="badge bg-danger">Declined</span>         @break
  @case('resubmit')   <span class="badge bg-info text-dark">Resubmit</span>  @break
  @default            <span class="badge bg-secondary">Unknown</span>
@endswitch
          </td>
          <td>{{ $v->created_at->format('Y-m-d H:i') }}</td>
          <td>
            <a href="{{ route('vehicle-verifications.edit', $v->id) }}" class="btn btn-sm btn-info">Edit</a>
           
  <form action="{{ route('vehicle-verifications.destroy', $v->id) }}"
        method="POST"
        style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure you want to delete this request?')">
      Delete
    </button>
  </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    @foreach($verifications as $v)
      document.getElementById('decline-btn-{{ $v->id }}')
        .addEventListener('click', () => {
          document.getElementById('decline-form-{{ $v->id }}').style.display = 'block';
        });
    @endforeach
  });
</script>
@endpush
@endsection
