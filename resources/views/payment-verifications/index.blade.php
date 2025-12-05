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
    .receipt-img {
        max-width: 100px;
        max-height: 100px;
        border-radius: 8px;
        cursor: pointer;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    .receipt-img:hover {
        transform: scale(1.05);
        transition: transform 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-color: #5356FB;
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
    /* Override DataTables styling */
    #paymentVerificationTable_wrapper {
        width: 100%;
    }
    #paymentVerificationTable_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }
    #paymentVerificationTable_wrapper .dataTables_length {
        margin-bottom: 15px;
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
        <h3>Payment Verification</h3>
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
            <table class="table nftmax-table" id="paymentVerificationTable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Order Number</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Receipt Image</th>
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
                    @if($order->receipt_image)
                        @php
                            $receiptFilename = basename($order->receipt_image);
                        @endphp
                        <img src="{{ route('receipts.show', $receiptFilename) }}" 
                             alt="Receipt" 
                             class="receipt-img"
                             data-bs-toggle="modal" 
                             data-bs-target="#receiptModal{{ $order->id }}">
                    @else
                        <span class="text-muted">No receipt</span>
                    @endif
                </td>
                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    <div class="btn-action-group">
                        <button type="button" 
                                class="btn btn-success btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#approveModal{{ $order->id }}">
                            Approve
                        </button>
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#declineModal{{ $order->id }}">
                            Decline
                        </button>
                        <a href="{{ route('payment-verifications.show', $order->id) }}" 
                           class="btn btn-info btn-sm">
                            View Details
                        </a>
                    </div>
                </td>
            </tr>

            <!-- Receipt Image Modal -->
            @if($order->receipt_image)
            <div class="modal fade" id="receiptModal{{ $order->id }}" tabindex="-1" aria-labelledby="receiptModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel{{ $order->id }}">Receipt - {{ $order->order_number }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            @php
                                $receiptFilename = basename($order->receipt_image);
                            @endphp
                            <img src="{{ route('receipts.show', $receiptFilename) }}" 
                                 alt="Receipt" 
                                 style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Approve Modal -->
            <div class="modal fade" id="approveModal{{ $order->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel{{ $order->id }}">Approve Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve the payment for order <strong>{{ $order->order_number }}</strong>?</p>
                            <p class="text-muted">An email will be sent to the customer confirming payment approval and that their order is now processing.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('payment-verifications.approve', $order->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve Payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decline Modal -->
            <div class="modal fade" id="declineModal{{ $order->id }}" tabindex="-1" aria-labelledby="declineModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="declineModalLabel{{ $order->id }}">Decline Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('payment-verifications.decline', $order->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>Are you sure you want to decline the payment for order <strong>{{ $order->order_number }}</strong>?</p>
                                <p class="text-muted">An email will be sent to the customer informing them that their order and payment have been rejected.</p>
                                <div class="mb-3">
                                    <label for="reason{{ $order->id }}" class="form-label">Reason (Optional)</label>
                                    <textarea class="form-control" 
                                              id="reason{{ $order->id }}" 
                                              name="reason" 
                                              rows="3" 
                                              placeholder="Enter reason for declining payment..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Decline Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#paymentVerificationTable').DataTable({
            paging: true,
            info: true,
            searching: true,
            order: [[0, 'desc']],
            pageLength: 15,
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [4, 5, 7] } // Disable sorting on Amount, Receipt Image, and Actions columns
            ],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>
@endsection
