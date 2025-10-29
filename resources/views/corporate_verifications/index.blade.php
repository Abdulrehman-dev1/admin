@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Corporate Verifications</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Entity Name</th>
          <th>Country</th>
          <th>Status</th>
          <th>Submitted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($verifications as $cv)
        <tr>
          <td>{{ $cv->id }}</td>
          <td>{{ optional($cv->user)->name }}</td>
          <td>{{ $cv->legal_entity_name }}</td>
          <td>{{ $cv->country }}</td>
          <td>
          @switch($cv->status)
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
          <td>{{ $cv->created_at->format('Y-m-d') }}</td>
          <td>
            <a href="{{ route('corporate-verifications.edit', $cv->id) }}" class="btn btn-sm btn-info">Edit</a>

            <!--@if($cv->status !== 'verified')-->
            <!--  <form action="{{ route('corporate-verifications.accept', $cv->id) }}" method="POST" style="display:inline">-->
            <!--    @csrf-->
            <!--    <button class="btn btn-sm btn-success">Accept</button>-->
            <!--  </form>-->
            <!--  <form action="{{ route('corporate-verifications.decline', $cv->id) }}" method="POST" style="display:inline">-->
            <!--    @csrf-->
            <!--    <button class="btn btn-sm btn-danger">Decline</button>-->
            <!--  </form>-->
            <!--@endif-->

            <form action="{{ route('corporate-verifications.destroy', $cv->id) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection
