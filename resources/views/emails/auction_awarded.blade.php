<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Awarded</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; border-radius: 10px;">
        <h2 style="color: #28a745; margin-top: 0;">
            @if($recipientType === 'admin')
                Auction Awarded - Notification
            @else
                🎉 Congratulations! You Won the Auction! 🎉
            @endif
        </h2>
        
        @if($recipientType === 'winner')
            <p>Dear {{ $highestBid->user->name ?? 'Winner' }},</p>
            
            <p style="font-size: 18px; color: #28a745; font-weight: bold;">
                Congratulations! You have successfully won the auction for the following item on XpertBid:
            </p>
            
            <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #23262F;">Auction Details</h3>
                <p><strong>Listing:</strong> {{ $auction->title }}</p>
                <p><strong>Winning Bid Amount:</strong> AED {{ number_format($highestBid->bid_amount, 2) }}</p>
                <p><strong>Auction Ended:</strong> {{ \Carbon\Carbon::parse($auction->end_date)->format('F d, Y h:i A') }}</p>
                <p><strong>Reserve Price:</strong> AED {{ number_format($auction->reserve_price ?? 0, 2) }}</p>
            </div>
            
            <p style="background-color: #d4edda; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;">
                <strong>Next Steps:</strong> Our team will contact you shortly to complete the transaction. Please ensure your payment method is ready and your shipping address is up to date in your account.
            </p>
            
            <p>To view your winning bid and complete the purchase, please log in to your XpertBid account.</p>
            
            <p>For any queries or assistance, please reach out to our support team at <a href="mailto:xpertbidofficial@gmail.com">xpertbidofficial@gmail.com</a>.</p>
        @else
            <p>Dear Admin,</p>
            
            <p>An auction has been automatically awarded to the highest bidder by the system.</p>
            
            <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3 style="margin-top: 0;">Auction Details</h3>
                <p><strong>Auction ID:</strong> {{ $auction->id }}</p>
                <p><strong>Auction Title:</strong> {{ $auction->title }}</p>
                <p><strong>Seller:</strong> {{ $auction->user->name ?? 'N/A' }} ({{ $auction->user->email ?? 'N/A' }})</p>
                <p><strong>Winner:</strong> {{ $highestBid->user->name ?? 'N/A' }} ({{ $highestBid->user->email ?? 'N/A' }})</p>
                <p><strong>Winning Bid Amount:</strong> AED {{ number_format($highestBid->bid_amount, 2) }}</p>
                <p><strong>Reserve Price:</strong> AED {{ number_format($auction->reserve_price ?? 0, 2) }}</p>
                <p><strong>Auction Ended:</strong> {{ \Carbon\Carbon::parse($auction->end_date)->format('F d, Y h:i A') }}</p>
                <p><strong>Status:</strong> Awarded</p>
            </div>
            
            <p style="background-color: #d4edda; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;">
                <strong>Action Required:</strong> Please coordinate with both the seller and winner to complete the transaction.
            </p>
        @endif
        
        <p style="margin-top: 30px;">
            Best regards,<br>
            <strong>XpertBid Team</strong>
        </p>
    </div>
</body>
</html>

