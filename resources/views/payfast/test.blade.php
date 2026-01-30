<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayFast Live Test</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input { padding: 0.5rem; width: 100%; max-width: 400px; }
        button { padding: 0.75rem 1.5rem; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .note { margin-top: 2rem; color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
    <h1>PayFast Live Test Checkout</h1>
    
    @if ($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/payfast/start') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>BASKET_ID</label>
            <input type="text" name="basket_id" value="{{ $basketId }}" readonly>
        </div>

        <div class="form-group">
            <label>TXNAMT (String, e.g. "100.00")</label>
            <input type="text" name="txnamt" value="100.00">
        </div>

        <div class="form-group">
            <label>CURRENCY_CODE</label>
            <input type="text" name="currency_code" value="PKR" readonly>
        </div>

        <div class="form-group">
            <label>CUSTOMER_EMAIL_ADDRESS</label>
            <input type="email" name="customer_email_address" value="test@example.com">
        </div>

        <div class="form-group">
            <label>CUSTOMER_MOBILE_NO</label>
            <input type="text" name="customer_mobile_no" value="03001234567">
        </div>

        <button type="submit">Start PayFast Checkout</button>
    </form>

    <div class="note">
        <p><strong>Note:</strong> After payment, check <code>storage/logs/laravel.log</code> for callback details.</p>
        <p>Ensure your <code>.env</code> has <code>PAYFAST_TEST_ENABLED=true</code>.</p>
    </div>
</body>
</html>
