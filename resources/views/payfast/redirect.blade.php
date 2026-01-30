<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to PayFast...</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding-top: 3rem; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 2s linear infinite; margin: 0 auto 1rem; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="loader"></div>
    <h2>Redirecting to PayFast...</h2>
    <p>Please wait while we transfer you to the secure payment gateway.</p>

    <form id="pf" method="POST" action="{{ $postUrl }}">
        @foreach ($fields as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        setTimeout(function() {
            document.getElementById('pf').submit();
        }, 500);
    </script>

    <!-- Debug Info (Optional, remove in production if needed) -->
    <!--
    <div style="margin-top:50px; text-align:left; font-size:12px; color:#999;">
        <h4>Debug Data:</h4>
        <pre>{{ json_encode($fields, JSON_PRETTY_PRINT) }}</pre>
    </div>
    -->
</body>
</html>
