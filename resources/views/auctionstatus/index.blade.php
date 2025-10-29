@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Auction Status List</h1>

    {{-- Filters --}}
    <form method="GET" action="{{ route('auctionstatus.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Search by Title, ID, User, Category">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All statuses</option>
                @foreach($allowedStatuses as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="per_page" class="form-control">
                @foreach([10,25,50,100] as $n)
                  <option value="{{ $n }}" @selected((int)request('per_page',10) === $n)>{{ $n }} / page</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('auctionstatus.index') }}" class="btn btn-primary"
">Reset</a>
        </div>
    </form>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-bordered align-middle">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Auction Title</th>
                  <th>Auction Category</th>
                  <th>Status</th>
                  <th style="width:110px;">Action</th>
              </tr>
          </thead>
          <tbody>
          @forelse($auctions as $auction)
              <tr>
                  <td>{{ $auction->id }}</td>
                  <td>{{ $auction->user->name ?? '-' }}</td>
                  <td>{{ $auction->title }}</td>
                  <td>{{ $auction->category->name ?? '-' }}</td>
                  <td>
                      @php
                          $status = strtolower($auction->status);
                          $badges = [
                              'active'   => 'success',
                              'inactive' => 'secondary',
                              'resubmit' => 'warning',
                              'decline'  => 'danger',
                          ];
                          $badgeClass = $badges[$status] ?? 'info';
                      @endphp
                      <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($auction->status) }}</span>
                  </td>
                  <td>
                      <a href="{{ route('auctionstatus.edit', $auction->id) }}" class="btn btn-sm btn-primary">Edit</a>
                  </td>
              </tr>
          @empty
              <tr>
                  <td colspan="6" class="text-center text-muted">No auctions found.</td>
              </tr>
          @endforelse
          </tbody>
      </table>
    </div>

    {{-- Pagination footer --}}
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">
            @if($auctions->total() > 0)
              Showing {{ $auctions->firstItem() }}–{{ $auctions->lastItem() }} of {{ $auctions->total() }}
            @else
              Showing 0 of 0
            @endif
        </small>
        {{ $auctions->links() }}
    </div>
</div>
@endsection
