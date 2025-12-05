<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Closed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; border-radius: 10px;">
        <h2 style="color: #e74c3c; margin-top: 0;">
            @if($recipientType === 'admin')
                Auction Closed - Notification
            @else
                Your Auction Has Been Closed
            @endif
        </h2>
        
        @if($recipientType === 'seller')
            <p>Dear {{ $auction->user->name ?? 'Seller' }},</p>
            
            <p>We are writing to inform you that your auction listing <strong>"{{ $auction->title }}"</strong> has been closed.</p>
            
            <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3 style="margin-top: 0;">Auction Details</h3>
                <p><strong>Auction Title:</strong> {{ $auction->title }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($auction->end_date)->format('F d, Y h:i A') }}</p>
                <p><strong>Reserve Price:</strong> AED {{ number_format($auction->reserve_price ?? 0, 2) }}</p>
            </div>
            
            <p style="background-color: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #f39c12;">
                <strong>Reason:</strong> The auction ended without receiving any bids that met the reserve price requirement, or no bids were placed.
            </p>
            
            <p>You can log in to your XpertBid account to view the auction details and create a new listing if you wish to relist this item.</p>
        @else
            <p>Dear Admin,</p>
            
            <p>An auction has been automatically closed by the system.</p>
            
            <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3 style="margin-top: 0;">Auction Details</h3>
                <p><strong>Auction ID:</strong> {{ $auction->id }}</p>
                <p><strong>Auction Title:</strong> {{ $auction->title }}</p>
                <p><strong>Seller:</strong> {{ $auction->user->name ?? 'N/A' }} ({{ $auction->user->email ?? 'N/A' }})</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($auction->end_date)->format('F d, Y h:i A') }}</p>
                <p><strong>Reserve Price:</strong> AED {{ number_format($auction->reserve_price ?? 0, 2) }}</p>
                <p><strong>Status:</strong> Closed</p>
            </div>
            
            <p style="background-color: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #f39c12;">
                <strong>Reason:</strong> The auction ended without receiving any valid bids that met the reserve price requirement.
            </p>
        @endif
        
        <p>If you have any questions or concerns, please feel free to contact our support team at <a href="mailto:xpertbidofficial@gmail.com">xpertbidofficial@gmail.com</a>.</p>
        
        <p style="margin-top: 30px;">
            Best regards,<br>
            <strong>XpertBid Team</strong>
        </p>
    </div>
</body>
</html>

