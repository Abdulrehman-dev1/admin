@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Property Verifications</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Property Type</th>
        <th>Address</th>
        <th>Country</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($verifications as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->property_type }}</td>
          <td>{{ $item->property_address }}</td>
          <td>{{ $item->country }}</td>
          <td>
              @switch($item->status)
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
          </td>
          <td>{{ $item->created_at->format('Y-m-d') }}</td>
          <td>
            <a href="{{ route('property-verifications.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
            <form action="{{ route('property-verifications.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="btn btn-sm btn-danger"
                      onclick="return confirm('Delete this record?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
