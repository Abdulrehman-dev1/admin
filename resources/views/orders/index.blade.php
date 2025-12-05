@extends('layouts.app')

@section('content')
<style>
    .nftmax-body {
        background: transparent !important;
        padding: 30px;
        padding-top: 0px !important;
        border-radius: 15px;
        box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.00);
        margin-top: 0px !important;
    }
    .table-wrapper {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 9px 95px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }
    table.nftmax-table {
        width: 100% !important;
        border-collapse: collapse;
        margin-top: 0;
    }
    table.nftmax-table thead {
        background-color: transparent;
        border-bottom: 2px solid rgba(83, 86, 251, 0.16);
    }
    table.nftmax-table thead th {
        padding: 15px !important;
        text-align: left !important;
        font-weight: 500 !important;
        color: #878F9A !important;
        font-size: 14px !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none !important;
        white-space: nowrap;
        background: transparent !important;
    }
    table.nftmax-table tbody td {
        padding: 18px 15px !important;
        color: #374557 !important;
        font-size: 14px !important;
        border-bottom: 1px solid #e5e7eb !important;
        vertical-align: middle !important;
    }
    table.nftmax-table tbody tr {
        transition: background-color 0.2s ease;
    }
    table.nftmax-table tbody tr:hover {
        background-color: #F9FAFB !important;
    }
    table.nftmax-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .status-select {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        min-width: 130px;
    }
    .status-select.pending {
        background-color: #FEF3C7;
        color: #92400E;
        border-color: #FCD34D;
    }
    .status-select.processing {
        background-color: #DBEAFE;
        color: #1E40AF;
        border-color: #93C5FD;
    }
    .status-select.completed {
        background-color: #D1FAE5;
        color: #065F46;
        border-color: #6EE7B7;
    }
    .status-select.cancelled {
        background-color: #FEE2E2;
        color: #991B1B;
        border-color: #FCA5A5;
    }
    .btn-action-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .btn-action-group .btn {
        padding: 6px 15px;
        border-radius: 6px;
        font-size: 13px;
        white-space: nowrap;
        font-weight: 500;
    }
</style>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Orders Management</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table nftmax-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $key + 1 }}</td>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->billing_name }}</td>
                        <td>{{ $order->billing_email }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'paid' || $order->payment_status === 'approved' ? 'success' : ($order->payment_status === 'failed' || $order->payment_status === 'declined' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" 
                                        class="status-select {{ $order->status }}" 
                                        onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <div class="btn-action-group">
                                <a href="{{ route('orders.show', $order->id) }}" 
                                   class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            paging: false, // We're using Laravel pagination
            info: true,
            searching: true,
            order: [[0, 'desc']],
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [8] } // Disable sorting on Actions column
            ],
            language: {
                search: "Search:",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>
@endsection
