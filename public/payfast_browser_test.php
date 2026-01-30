<?php
/**
 * PayFast Browser Test
 * URL: http://localhost:8000/payfast_browser_test.php
 *
 * Step1: GetAccessToken (server-side)
 * Step2: Redirect to PostTransaction (browser form POST)
 *
 * IMPORTANT: TXNAMT, BASKET_ID, CURRENCY_CODE must be EXACTLY SAME in both steps.
 */

declare(strict_types=1);

$root = realpath(__DIR__ . '/..');
if ($root && file_exists($root . '/vendor/autoload.php')) {
    require $root . '/vendor/autoload.php';
    if (class_exists(\Dotenv\Dotenv::class) && file_exists($root . '/.env')) {
        \Dotenv\Dotenv::createImmutable($root)->safeLoad();
    }
}

function envv(string $k, $d=null){ return $_ENV[$k] ?? $_SERVER[$k] ?? getenv($k) ?: $d; }
function rand_str(int $len=10): string {
    $c='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $o=''; for($i=0;$i<$len;$i++) $o.=$c[random_int(0, strlen($c)-1)];
    return $o;
}
function mask(string $s,int $a=6,int $b=4): string {
    if(strlen($s)<=($a+$b)) return str_repeat('*',strlen($s));
    return substr($s,0,$a).str_repeat('*',strlen($s)-($a+$b)).substr($s,-$b);
}
function log_line(string $m,array $d=[]): void {
    $root = realpath(__DIR__ . '/..');
    $path = $root ? ($root.'/storage/logs/payfast_browser_test.log') : (sys_get_temp_dir().'/payfast_browser_test.log');
    @file_put_contents($path,"[".date('Y-m-d H:i:s')."] $m ".json_encode($d).PHP_EOL,FILE_APPEND);
}

$merchantId   = (string) envv('PAYFAST_MERCHANT_ID', '14833');
$securedKey   = (string) envv('PAYFAST_SECURED_KEY', '');
$merchantName = (string) envv('PAYFAST_MERCHANT_NAME', 'XpertBid');

$tokenUrl = (string) envv('PAYFAST_TOKEN_URL', 'https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken');
$postUrl  = (string) envv('PAYFAST_POST_URL',  'https://ipguat.apps.net.pk/Ecommerce/api/Transaction/PostTransaction');

$ngrokBase = (string) envv('PAYFAST_PUBLIC_BASE_URL', ''); // optional: https://xxxx.ngrok-free.dev
$defaultCurrency = (string) envv('PAYFAST_CURRENCY_CODE', 'PKR');

$action = $_POST['action'] ?? '';

if ($action !== 'start') {
    $basketId = 'ITEM-' . rand_str(6);
    ?>
    <!doctype html><html><head><meta charset="utf-8"><title>PayFast Test</title>
    <style>
      body{font-family:Arial;max-width:900px;margin:30px auto}
      label{display:block;margin-top:12px;font-weight:700}
      input{width:100%;padding:10px}
      button{margin-top:16px;padding:12px 16px;cursor:pointer}
      .note{background:#fff7e6;padding:12px;border:1px solid #f3d19c;margin-bottom:16px}
      code{background:#f3f3f3;padding:2px 6px}
    </style></head><body>

    <div class="note">
      ✅ <b>Tip:</b> <b>TXNAMT</b>, <b>BASKET_ID</b>, <b>CURRENCY_CODE</b> must match exactly in token + post step.<br>
      ✅ <b>CHECKOUT_URL</b> must be public (use ngrok) so PayFast can call it.
    </div>

    <h2>PayFast Browser Test</h2>
    <form method="post">
      <input type="hidden" name="action" value="start">

      <label>Basket ID</label>
      <input name="BASKET_ID" value="<?=htmlspecialchars($basketId)?>">

      <label>Amount (TXNAMT) — use 100.00 format</label>
      <input name="TXNAMT" value="100.00">

      <label>Currency (CURRENCY_CODE)</label>
      <input name="CURRENCY_CODE" value="<?=htmlspecialchars($defaultCurrency)?>">

      <label>SUCCESS_URL</label>
      <input name="SUCCESS_URL" value="<?=htmlspecialchars($ngrokBase ? $ngrokBase.'/payfast_success.php' : 'http://localhost:3000/payfast/success')?>">

      <label>FAILURE_URL</label>
      <input name="FAILURE_URL" value="<?=htmlspecialchars($ngrokBase ? $ngrokBase.'/payfast_failure.php' : 'http://localhost:3000/payfast/failure')?>">

      <label>CHECKOUT_URL (public)</label>
      <input name="CHECKOUT_URL" value="<?=htmlspecialchars($ngrokBase ? $ngrokBase.'/payfast_notify_dummy.php' : 'http://localhost:8000/payfast_notify_dummy.php')?>">

      <label>Customer Email</label>
      <input name="CUSTOMER_EMAIL_ADDRESS" value="test@example.com">

      <label>Customer Mobile</label>
      <input name="CUSTOMER_MOBILE_NO" value="03001234567">

      <button type="submit">Start PayFast Checkout</button>
    </form>

    <p style="color:#666;margin-top:14px">Logs: <code>storage/logs/payfast_browser_test.log</code></p>
    </body></html>
    <?php
    exit;
}

if (!$securedKey) { http_response_code(500); exit("Missing PAYFAST_SECURED_KEY in .env"); }

$basketId   = (string)($_POST['BASKET_ID'] ?? '');
$amount     = (string)($_POST['TXNAMT'] ?? '');
$currency   = (string)($_POST['CURRENCY_CODE'] ?? 'PKR');
$successUrl = (string)($_POST['SUCCESS_URL'] ?? '');
$failureUrl = (string)($_POST['FAILURE_URL'] ?? '');
$checkoutUrl= (string)($_POST['CHECKOUT_URL'] ?? '');
$email      = (string)($_POST['CUSTOMER_EMAIL_ADDRESS'] ?? '');
$mobile     = (string)($_POST['CUSTOMER_MOBILE_NO'] ?? '');

log_line("Starting", compact('basketId','amount','currency','successUrl','failureUrl','checkoutUrl'));

// Step 1: token
$tokenParams = [
  'MERCHANT_ID'   => $merchantId,
  'SECURED_KEY'   => $securedKey,
  'BASKET_ID'     => $basketId,
  'TXNAMT'        => $amount,
  'CURRENCY_CODE' => $currency,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenParams));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'CURL/PHP PayFast Example');
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

$res = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err  = curl_error($ch);
curl_close($ch);

if ($http !== 200 || !$res) {
  log_line("Token failed", ['http'=>$http,'err'=>$err,'res'=>$res]);
  http_response_code(500);
  exit("Token failed HTTP=$http ERR=$err");
}

$payload = json_decode($res, true);
$token = $payload['ACCESS_TOKEN'] ?? '';
log_line("Token ok", ['token'=>$token ? mask($token) : null, 'raw'=>$payload]);

if (!$token) { http_response_code(500); exit("ACCESS_TOKEN missing: ".htmlspecialchars($res)); }

// Step 2: form fields (SIGNATURE/VERSION random strings per sample)
$fields = [
  'CURRENCY_CODE'          => $currency,
  'MERCHANT_ID'            => $merchantId,
  'MERCHANT_NAME'          => $merchantName,
  'TOKEN'                  => $token,
  'BASKET_ID'              => $basketId,
  'TXNAMT'                 => $amount,
  'ORDER_DATE'             => date('Y-m-d H:i:s'),
  'SUCCESS_URL'            => $successUrl,
  'FAILURE_URL'            => $failureUrl,
  'CHECKOUT_URL'           => $checkoutUrl,
  'CUSTOMER_EMAIL_ADDRESS' => $email,
  'CUSTOMER_MOBILE_NO'     => $mobile,
  'SIGNATURE'              => 'SOMERANDOM-' . rand_str(12),
  'VERSION'                => 'XPERTBID-0.1',
  'TXNDESC'                => 'Item Purchased from Cart',
  'PROCCODE'               => '00',
  'TRAN_TYPE'              => 'ECOMM_PURCHASE',
  'STORE_ID'               => '',
];

log_line("Redirecting", ['postUrl'=>$postUrl, 'preview'=>[
  'MERCHANT_ID'=>$merchantId,'BASKET_ID'=>$basketId,'TXNAMT'=>$amount,'CURRENCY_CODE'=>$currency,
  'SUCCESS_URL'=>$successUrl,'FAILURE_URL'=>$failureUrl,'CHECKOUT_URL'=>$checkoutUrl,'TOKEN'=>mask($token),
]]);

?>
<!doctype html><html><head><meta charset="utf-8"><title>Redirecting…</title></head>
<body style="font-family:Arial;max-width:900px;margin:30px auto">
  <h3>Redirecting to PayFast…</h3>
  <form id="pf" method="post" action="<?=htmlspecialchars($postUrl)?>">
    <?php foreach($fields as $k=>$v): ?>
      <input type="hidden" name="<?=htmlspecialchars($k)?>" value="<?=htmlspecialchars((string)$v)?>">
    <?php endforeach; ?>
    <button type="submit">Continue</button>
  </form>
  <script>setTimeout(()=>document.getElementById('pf').submit(),500);</script>
</body></html>
