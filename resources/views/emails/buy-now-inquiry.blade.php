<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 30px; text-align: center; }
        .body { padding: 30px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 18px; font-weight: bold; color: #28a745; margin-bottom: 10px; border-bottom: 2px solid #28a745; padding-bottom: 5px; }
        .info { padding: 10px; background: #f8f9fa; margin-bottom: 10px; border-radius: 4px; }
        .label { font-weight: bold; color: #555; width: 120px; display: inline-block; }
        .message-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
        .button { display: inline-block; padding: 12px 24px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 New Buy Now Inquiry</h1>
            <p>Someone wants to buy an item!</p>
        </div>
        
        <div class="body">
            <div class="section">
                <div class="section-title">👤 Customer Information</div>
                <div class="info">
                    <span class="label">Name:</span> {{ $inquiry->full_name }}
                </div>
                <div class="info">
                    <span class="label">Email:</span> <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>
                </div>
                <div class="info">
                    <span class="label">Phone:</span> <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                </div>
                @if($inquiry->user_id)
                <div class="info">
                    <span class="label">User ID:</span> #{{ $inquiry->user_id }} (Registered Member)
                </div>
                @endif
            </div>
            
            <div class="section">
                <div class="section-title">🏷️ Product Information</div>
                <div class="info">
                    <span class="label">Product ID:</span> #{{ $inquiry->auction_id }}
                </div>
                <div class="info">
                    <span class="label">Title:</span> <strong>{{ $inquiry->auction_title }}</strong>
                </div>
                <div class="info">
                    <span class="label">Date:</span> {{ $inquiry->created_at->format('F j, Y - g:i A') }}
                </div>
            </div>
            
            @if($inquiry->message)
            <div class="section">
                <div class="section-title">💬 Customer Message</div>
                <div class="message-box">
                    {{ $inquiry->message }}
                </div>
            </div>
            @endif
            
            <div style="text-align: center; margin-top: 30px;">
                <p><strong>Contact this customer as soon as possible!</strong></p>
                <a href="mailto:{{ $inquiry->email }}?subject=Re: Buy Now Inquiry - {{ $inquiry->auction_title }}" class="button">📧 Reply to Customer</a>
                <a href="tel:{{ $inquiry->phone }}" class="button" style="background: #17a2b8;">📞 Call Customer</a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>XpertBid Auction Platform</strong></p>
            <p>This is an automated notification from your Buy Now inquiry system.</p>
        </div>
    </div>
</body>
</html>