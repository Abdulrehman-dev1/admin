<table class="table nftmax-table" id="ordersTable">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Payment</th>
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
                    <span class="custom-badge {{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline order-status-form">
                        @csrf
                        @method('PUT')
                        <select name="status" 
                                class="status-select-premium {{ $order->status }}" 
                                onchange="this.form.submit()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $order->created_at->format('d M Y') }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $order->created_at->format('h:i A') }}</small>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="action-icon view" title="View Details"><i class="fas fa-eye"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted p-5">No orders found based on your filters.</td>
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
