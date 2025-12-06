<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; border-radius: 10px;">
        <h2 style="color: #28a745; margin-top: 0;">🎉 Order Confirmed!</h2>
        
        <p>Dear {{ $order->billing_name }},</p>
        
        <p style="font-size: 18px; color: #28a745; font-weight: bold;">
            Thank you for your order! Your order has been successfully placed.
        </p>
        
        <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #23262F;">Order Details</h3>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y h:i A') }}</p>
            <p><strong>Total Amount:</strong> {{ number_format($order->total, 2) }}</p>
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
    
    <p>For any queries or assistance, please reach out to our support team at <a href="mailto:xpertbidofficial@gmail.com">xpertbidofficial@gmail.com</a>.</p>
        
        <p style="margin-top: 30px;">
            Best regards,<br>
            <strong>XpertBid Team</strong>
        </p>
    </div>
</body>
</html>
