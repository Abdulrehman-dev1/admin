<table class="table nftmax-table" id="paymentVerificationTable">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Receipt</th>
            <th>Status</th>
            <th style="min-width: 140px;">Order Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ $order->billing_name }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $order->billing_email }}</small>
                </td>
                <td>
                    <div style="font-weight: 800; color: #1A1D2F; font-size: 15px;">
                        ${{ number_format($order->total, 2) }}
                    </div>
                </td>
                <td>
                    @if($order->receipt_image)
                        @php
                            $receiptFilename = basename($order->receipt_image);
                        @endphp
                        <div class="receipt-preview-wrapper" style="width: 80px; height: 60px; overflow: hidden; border-radius: 8px; border: 1px solid #eee; cursor: pointer;">
                            <img src="{{ route('receipts.show', $receiptFilename) }}" 
                                 alt="Receipt" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#receiptModal{{ $order->id }}">
                        </div>
                    @else
                        <span class="text-muted small">No receipt</span>
                    @endif
                </td>
                <td>
                    <span class="custom-badge {{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $order->created_at->format('d M Y') }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $order->created_at->format('h:i A') }}</small>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        @if($order->payment_status === 'pending')
                            <button type="button" class="action-icon view" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;" 
                                    data-bs-toggle="modal" data-bs-target="#approveModal{{ $order->id }}" title="Approve">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="action-icon view" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;" 
                                    data-bs-toggle="modal" data-bs-target="#declineModal{{ $order->id }}" title="Decline">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        <a href="{{ route('payment-verifications.show', $order->id) }}" class="action-icon view" title="View Details"><i class="fas fa-eye"></i></a>
                    </div>
                </td>
            </tr>

            {{-- Modals remain inside the loop for dynamic functionality --}}
            <!-- Receipt Image Modal -->
            @if($order->receipt_image)
            <div class="modal fade" id="receiptModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title" style="font-weight: 800;">Receipt - {{ $order->order_number }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            @php $receiptFilename = basename($order->receipt_image); @endphp
                            <img src="{{ route('receipts.show', $receiptFilename) }}" alt="Receipt" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Approve Modal -->
            <div class="modal fade" id="approveModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title" style="font-weight: 800;">Approve Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <p style="color: #374557;">Are you sure you want to approve the payment for order <strong>{{ $order->order_number }}</strong>?</p>
                            <p class="text-muted small">An email will be sent to the customer confirming payment approval.</p>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-filter-reset" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('payment-verifications.approve', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-filter-submit" style="background: #22c55e;">Approve Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decline Modal -->
            <div class="modal fade" id="declineModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title" style="font-weight: 800;">Decline Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('payment-verifications.decline', $order->id) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <p style="color: #374557;">Are you sure you want to decline the payment for order <strong>{{ $order->order_number }}</strong>?</p>
                                <div class="mb-3">
                                    <label class="filter-group-label">Reason (Optional)</label>
                                    <textarea class="form-control nftmax-filter-input" style="height: auto;" name="reason" rows="3" placeholder="Enter reason for declining..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-filter-reset" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-filter-submit" style="background: #dc2626;">Decline Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted p-5">No payment verifications found based on your filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() ?? 0 }} results
    </div>
    <div>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
