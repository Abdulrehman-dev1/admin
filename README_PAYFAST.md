# PayFast UAT Environment Setup

Add these keys to your `.env` file on `admin.xpertbid.com`.
DO NOT hardcode these in the codebase.

```ini
PAYFAST_MERCHANT_ID=14833
PAYFAST_SECURED_KEY=rPcy4T7GQkSCFsHBLdn26s
PAYFAST_MERCHANT_NAME="Xpertbid"
PAYFAST_TOKEN_URL="https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken"
PAYFAST_POST_URL="https://ipguat.apps.net.pk/Ecommerce/api/Transaction/PostTransaction"
PAYFAST_CURRENCY_CODE=PKR
PAYFAST_SUCCESS_URL="https://admin.xpertbid.com/payfast/success"
PAYFAST_FAILURE_URL="https://admin.xpertbid.com/payfast/failure"
PAYFAST_CHECKOUT_URL="https://admin.xpertbid.com/payfast/notify"
PAYFAST_TEST_ENABLED=true
```

After adding these, run:
```bash
php artisan config:clear
php artisan cache:clear
```
