@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Buy Now Inquiries</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped datatable" id="inquiriesTable">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Auction Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $key => $inquiry)
                <tr>
                    <td>{{ $key + 1 + ($inquiries->currentPage() - 1) * $inquiries->perPage() }}</td>
                    <td>{{ $inquiry->full_name }}</td>
                    <td>{{ $inquiry->email }}</td>
                    <td>{{ $inquiry->phone }}</td>
                    <td>
                        @if($inquiry->auction)
                            <a href="{{ route('buy-now-inquiries.show', $inquiry->id) }}">{{ $inquiry->auction->title }}</a>
                        @else
                            <span class="text-muted">Auction Not Found</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('buy-now-inquiries.update-status', $inquiry->id) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('buy-now-inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline delete-form" id="delete-form-{{ $inquiry->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $inquiry->id }}">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $inquiries->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#inquiriesTable').DataTable({
        order: [[0, 'desc']],
        pageLength: 20,
        responsive: true
    });

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

