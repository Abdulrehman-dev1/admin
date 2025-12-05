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
</style>
<div class="container">
    <div class="mb-4">
        <a href="{{ route('payment-verifications.index') }}" class="btn btn-secondary">← Back to Payment Verification</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Order Details - {{ $order->order_number }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Billing Information</h5>
                    <p><strong>Name:</strong> {{ $order->billing_name }}</p>
                    <p><strong>Email:</strong> {{ $order->billing_email }}</p>
                    <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
                    <p><strong>Address:</strong> {{ $order->billing_address_line1 }}</p>
                    @if($order->billing_address_line2)
                        <p>{{ $order->billing_address_line2 }}</p>
                    @endif
                    <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}</p>
                    <p>{{ $order->billing_country }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Shipping Information</h5>
                    <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                    <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    <p><strong>Address:</strong> {{ $order->shipping_address_line1 }}</p>
                    @if($order->shipping_address_line2)
                        <p>{{ $order->shipping_address_line2 }}</p>
                    @endif
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    <p>{{ $order->shipping_country }}</p>
                </div>
            </div>

            <hr>

            <h5>Order Items</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->auction->title ?? 'Product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Subtotal:</th>
                        <th>${{ number_format($order->subtotal, 2) }}</th>
                    </tr>
                    @if($order->tax > 0)
                    <tr>
                        <th colspan="3" class="text-end">Tax:</th>
                        <th>${{ number_format($order->tax, 2) }}</th>
                    </tr>
                    @endif
                    @if($order->shipping_cost > 0)
                    <tr>
                        <th colspan="3" class="text-end">Shipping:</th>
                        <th>${{ number_format($order->shipping_cost, 2) }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th>${{ number_format($order->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h5>Payment Information</h5>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Payment Status:</strong> 
                        <span class="badge bg-{{ $order->payment_status === 'approved' ? 'success' : ($order->payment_status === 'declined' ? 'danger' : 'warning') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p><strong>Order Status:</strong> 
                        <span class="badge bg-{{ $order->status === 'processing' ? 'info' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                @if($order->receipt_image)
                <div class="col-md-6">
                    <h5>Receipt Image</h5>
                    @php
                        $receiptFilename = basename($order->receipt_image);
                    @endphp
                    <img src="{{ route('receipts.show', $receiptFilename) }}" 
                         alt="Receipt" 
                         style="max-width: 300px; height: auto; border-radius: 8px; cursor: pointer;"
                         data-bs-toggle="modal" 
                         data-bs-target="#receiptModal">
                </div>
                @endif
            </div>

            @if($order->payment_status === 'pending')
            <hr>
            <div class="mt-4">
                <button type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal" 
                        data-bs-target="#approveModal">
                    Approve Payment
                </button>
                <button type="button" 
                        class="btn btn-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#declineModal">
                    Decline Payment
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Receipt Image Modal -->
@if($order->receipt_image)
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Receipt - {{ $order->order_number }}</h5>
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
@if($order->payment_status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Payment</h5>
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
<div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Decline Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('payment-verifications.decline', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to decline the payment for order <strong>{{ $order->order_number }}</strong>?</p>
                    <p class="text-muted">An email will be sent to the customer informing them that their order and payment have been rejected.</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason (Optional)</label>
                        <textarea class="form-control" 
                                  id="reason" 
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
@endif
@endsection
