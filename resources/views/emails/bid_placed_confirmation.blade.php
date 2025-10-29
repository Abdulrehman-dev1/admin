<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bid Placed Confirmation</title>
</head>
<body>
    <p>Dear {{ $firstName }},</p>

    <p>
        This email confirms that your bid of {{ $amount }} has been successfully placed on the following lot:
    </p>
    <p>
        📦 <strong>Listing:</strong> {{ $listingTitle }}
    </p>
    <p>
        📅 <strong>Auction Ends:</strong> {{ $auctionEnds }}
    </p>
    <p>
        📈 <strong>Current Highest Bid:</strong> {{ $currentHighestBid }}
    </p>

    <p>
        You will be notified if another bidder places a higher bid. To increase your chances of winning, you may revise your bid at any time before the auction ends.
    </p>

    <p>
        Track this and other bids through your My Bids Dashboard: <a href="{{ $dashboardLink }}">{{ $dashboardLink }}</a>
    </p>

    <p>Thank you for using XpertBid.</p>

    <p>Best regards,</p>
    <p>XpertBid Auctions Team</p>
</body>
</html>
