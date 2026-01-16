<!DOCTYPE html>
<html>

<head>
    <title>Your Product is Featured on XpertBid</title>
</head>

<body>
    <p>Dear {{ $firstName }},</p>
    <p>Congratulations! Your product, <strong>{{ $listingTitle }}</strong>, has been added to the featured listings on
        XpertBid.</p>
    <p>You can view it on our home page here: <a href="{{ $homeUrl }}">{{ $homeUrl }}</a></p>
    <p>Thank you for using XpertBid!</p>
</body>

</html>