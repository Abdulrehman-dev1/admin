<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<p><strong>Payment Method:</strong>
    @if($order->payment_method === 'cod')
        Cash on Delivery
    @elseif($order->payment_method === 'bank_transfer')
        XpertBid Bank Transfer
    @elseif($order->payment_method === 'stripe')
        Credit/Debit Card
    @else
        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
    @endif
</p>
<p><strong>Payment Status:</strong>
    <span style="color: {{ $order->payment_status === 'paid' ? '#27ae60' : '#f39c12' }};">
        {{ ucfirst($order->payment_status) }}
    </span>
</p>
</div>

<div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h3 style="margin-top: 0; color: #23262F;">Shipping Address</h3>
    <p>{{ $order->shipping_name }}</p>
    <p>{{ $order->shipping_address_line1 }}</p>
    @if($order->shipping_address_line2)
        <p>{{ $order->shipping_address_line2 }}</p>
    @endif
    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
    <p>{{ $order->shipping_country }}</p>
</div>

<p>For any queries or assistance, please reach out to our support team at <a
        href="mailto:xpertbidofficial@gmail.com">xpertbidofficial@gmail.com</a>.</p>

<p style="margin-top: 30px;">
    Best regards,<br>
    <strong>XpertBid Team</strong>
</p>
</div>
</body>

</html>