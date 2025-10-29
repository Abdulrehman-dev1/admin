<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bid Outbid Notification</title>
</head>
<body>
    <p>Dear {{ $firstName }},</p>

    <p>
        We would like to inform you that your bid on the following listing has been outbid:
    </p>

    <p>
        📦 <strong>Listing:</strong> {{ $listingTitle }}
    </p>
    <p>
        💰 <strong>Your Bid:</strong> {{ $yourBidAmount }}
    </p>
    <p>
        📈 <strong>New Highest Bid:</strong> {{ $newHighestBid }}
    </p>

    <p>
        Please consider revising your bid if you wish to remain competitive.
    </p>

    <p>
        Track this and other bids through your My Bids Dashboard: <a href="{{ $dashboardLink }}">{{ $dashboardLink }}</a>
    </p>

    <p>Thank you for using XpertBid.</p>

    <p>Best regards,</p>
    <p>XpertBid Auctions Team</p>
</body>
</html>
