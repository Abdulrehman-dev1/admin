<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Listing Is Now Live on XpertBid</title>
    <style>
        .boost-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <p>Dear {{ $firstName }},</p>

    <p>
        We’re pleased to inform you that your auction listing has been successfully published on XpertBid:
    </p>

    <p>
        📦 <strong>Listing:</strong> {{ $listingTitle }}
    </p>
    <p>
        📅 <strong>Auction Ends On:</strong> {{ $auctionEnds }}
    </p>

    <p>
        You can track real-time views, bids, and performance metrics via your Seller Dashboard.
    </p>

    <p>
        🚀 Want more visibility? Consider using a <strong>Boosted Listing</strong> to feature your lot at the top of search results.
    </p>

    <p>
        <a href="https://www.xpertbid.com/MyListings" class="btn-primary">Boost Now</a>
    </p>

    <p>
        We wish you a successful sale. For support, contact us at <a href="mailto:support@xpertbid.com">support@xpertbid.com</a>.
    </p>

    <p>Best regards,</p>
    <p>XpertBid Seller Support</p>
</body>
</html>
