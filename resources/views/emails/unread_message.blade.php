<!DOCTYPE html>
<html>

<head>
    <title>New Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Message on XpertBid</h2>
        </div>
        <div class="content">
            <p>Hi {{ $recipient->name }},</p>
            <p><strong>{{ $sender->name }}</strong> sent you a message:</p>
            <blockquote style="border-left: 4px solid #ddd; padding-left: 10px; color: #555;">
                @if($messageContent->type === 'image')
                    [Image Attachment]
                @else
                    {{ Str::limit($messageContent->body, 100) }}
                @endif
            </blockquote>
            <p style="text-align: center;">
                <a href="{{ env('NEXT_PUBLIC_FRONTEND_URL', 'https://xpertbid.com') }}/chat?conversation_id={{ $messageContent->conversation_id }}"
                    class="button" style="color: #ffffff;">Reply Now</a>
            </p>
        </div>
        <div class="footer">
            <p>If you did not request this, please ignore this email.</p>
        </div>
    </div>
</body>

</html>