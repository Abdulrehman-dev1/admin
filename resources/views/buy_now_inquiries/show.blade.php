@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Buy Now Inquiry Details</h3>
        <a href="{{ route('buy-now-inquiries.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <!-- Inquiry Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Inquiry Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Full Name:</strong>
                            <p class="mb-0">{{ $inquiry->full_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p class="mb-0">{{ $inquiry->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Phone:</strong>
                            <p class="mb-0">{{ $inquiry->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Status:</strong>
                            <div>
                                <form action="{{ route('buy-now-inquiries.update-status', $inquiry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                        <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Message:</strong>
                            <div class="border p-3 bg-light rounded">
                                {{ $inquiry->message ?? 'No message provided' }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Created At:</strong>
                            <p class="mb-0">{{ $inquiry->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Updated At:</strong>
                            <p class="mb-0">{{ $inquiry->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auction Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Auction Information</h5>
                </div>
                <div class="card-body">
                    @if($inquiry->auction)
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <strong>Auction Title:</strong>
                                <p class="mb-0">{{ $inquiry->auction->title }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Minimum Bid:</strong>
                                <p class="mb-0">${{ number_format($inquiry->auction->minimum_bid ?? 0, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Reserve Price:</strong>
                                <p class="mb-0">${{ number_format($inquiry->auction->reserve_price ?? 0, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Auction ID:</strong>
                                <p class="mb-0">{{ $inquiry->auction->id }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Auction Status:</strong>
                                <p class="mb-0">
                                    <span class="badge {{ $inquiry->auction->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($inquiry->auction->status ?? 'N/A') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <strong>Auction Not Found:</strong> The auction associated with this inquiry may have been deleted.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Listed By User Information Card -->
            @if($inquiry->auction && $inquiry->auction->user)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Listed By User Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>Name:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Email:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Phone:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>User ID:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>User Status:</strong>
                            <p class="mb-0">
                                <span class="badge {{ ($inquiry->auction->user->status ?? '') == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($inquiry->auction->user->status ?? 'N/A') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Referral Information Card -->
            @if($inquiry->auction && $inquiry->auction->user && $inquiry->auction->user->referrer)
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Referral Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>Referrer Name:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->referrer->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Referrer Email:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->referrer->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Referrer Phone:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->referrer->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Referrer ID:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->referrer->id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Referral Code:</strong>
                            <p class="mb-0">{{ $inquiry->auction->user->referrer->referral_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Referral Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-muted">This user did not come through a referral.</p>
                </div>
            </div>
            @endif

            <!-- Actions Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('buy-now-inquiries.index') }}" class="btn btn-secondary">Back to List</a>
                        <form action="{{ route('buy-now-inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline delete-form" id="delete-form-{{ $inquiry->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger delete-button" data-id="{{ $inquiry->id }}">
                                Delete Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${inquiryId}`).submit();
                }
            });
        });
    });
});
</script>

@endsection

