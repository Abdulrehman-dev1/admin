<?php
namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use App\Models\Wallet;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use App\Models\NewNotification;


class PaymentController extends Controller
{
    private $_apiContext;

        public function __construct()
        {
            $paypalConfig = config('paypal');
            $this->_apiContext = new ApiContext(
                new OAuthTokenCredential(
                    $paypalConfig['client_id'],
                    $paypalConfig['client_secret']
                )
            );
            $this->_apiContext->setConfig($paypalConfig['settings']);
        }
        public function stripePayment(Request $request)
        {
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'stripeToken' => 'required',
            ]);

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $charge = Charge::create([
                'amount' => $request->amount*3, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Wallet Deposit',
            ]);
            // Update wallet balance
            $user = User::find($userId);
            $amount = $result->getTransactions()[0]->getAmount()->getTotal();

            $user->wallet->balance += $amount;
            $user->wallet->save();

            // Save transaction
            Transactions::create([
                'user_id' => $userId,
                'amount' => $amount,
                'transaction_id' =>$paymentId,
                'type' => 'Paypal',
                'status' => 'success',
            ]);

            return response()->json(['balance' => $wallet->balance]);
        }

        public function createPaymentIntent(Request $request)
        {
          $request->validate(
    ['amount' => 'required|numeric|min:50'],
    [
        'amount.required' => 'Please enter an amount.',
        'amount.numeric'  => 'Amount must be a valid number.',
        'amount.min'      => 'Please enter an amount of at least $50 USD.',
    ]
);

            try {
                Stripe::setApiKey('sk_test_6fErHC2ev2jizSKlYJozlfb500CPZYW2La');

                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->amount, // Amount in cents
                    'currency' => 'usd',
                    'payment_method_types' => ['card'],
                ]);
                //dd('sdf');
                $userId = $request->user()->id;

                // Update wallet balance
                $user = User::find($userId);
                $amount = $request->amount;
				$wallet_check = Wallet::where("user_id", $user->id)->first();
				if(empty($wallet_check)){
					$user->wallet()->create([
                        'balance' => 0, // Default balance
                    ]);
				}
                $add_amount = ($user->wallet->balance) ? $user->wallet->balance + $amount : $amount;
                $user->wallet->balance = $add_amount;
                $user->wallet->save();

                // Save transaction
                Transactions::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                    'transaction_id' =>$paymentIntent->id,
                    'type' => 'Stripe',
                    'status' => 'success',
                ]);
                NewNotification::create([
    'user_id' => $request->user()->id, // ✅ Correct way to get authenticated user ID
    'title' => 'Wallet Recharge',
    'message' => 'Your wallet has been credited with $' . $request->amount,
    'is_read' => false,
     'type' => 'wallet',
        'image_url' => NewNotification::getImageForType('wallet'),
]);


                return response()->json([
                    'clientSecret' => $paymentIntent->client_secret,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        public function processPayPalPayment(Request $request)
        {
            //dd($request);
            $request->validate(['amount' => 'required|numeric|min:1']);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('USD')->setTotal($request->amount);

            $transaction = new Transaction();
            $transaction->setAmount($amount)->setDescription('Wallet Recharge');
            //dd($transaction);
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('paypal.success'))
                ->setCancelUrl(route('paypal.cancel'));

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);
            //dd($payment->create($this->_apiContext));
            $payment->create($this->_apiContext);
            //dd($payment);
            return response()->json(['approval_url' => $payment->getApprovalLink()]);
        }

        public function paypalCancel()
        {
            return response()->json(['message' => 'Payment cancelled'], 200);
        }

        public function paypalSuccess(Request $request)
            {
                $paymentId = $request->get('paymentId');
                $payerId = $request->get('PayerID');
                $userId = $request->get('userId');

                if (!$paymentId || !$payerId || !$userId) {
                    return response()->json(['message' => 'Invalid payment data'], 400);
                }

                $payment = Payment::get($paymentId, $this->_apiContext);
                $execution = new PaymentExecution();
                $execution->setPayerId($payerId);

                try {
                    $result = $payment->execute($execution, $this->_apiContext);

                    if ($result->getState() === 'approved') {
                        // Update wallet balance
                        $user = User::find($userId);
                        $amount = $result->getTransactions()[0]->getAmount()->getTotal();

                        $user->wallet->balance += $amount;
                        $user->wallet->save();

                        // Save transaction
                        Transactions::create([
                            'user_id' => $userId,
                            'amount' => $amount,
                            'transaction_id' =>$paymentId,
                            'type' => 'Paypal',
                            'status' => 'success',
                        ]);

                        return response()->json(['message' => 'Payment successful']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Payment execution failed', 'error' => $e->getMessage()], 500);
                }

                return response()->json(['message' => 'Payment not approved'], 400);
            }
public function savePaymentMethod(Request $request)
{
    // 1) Rules
    $rules = [
        'paymentMethod' => 'required'
    ];

    if ($request->paymentMethod === "Paypal") {
        $rules['paypal_id'] = 'required|email';
    } elseif ($request->paymentMethod === "Bank Transfer") {
        $rules['bank_name']    = 'required|string';
        $rules['iban_number']  = 'required|string';
        $rules['swift_code']   = 'required|string';
        $rules['account_title']= 'required|string';
    }

    // 2) Custom messages
    $messages = [
        'paymentMethod.required'    => 'Please select a payment method.',
        
        // PayPal
        'paypal_id.required'        => 'Please enter your PayPal email address.',
        'paypal_id.email'           => 'Please enter a valid PayPal email address.',
        
        // Bank Transfer
        'bank_name.required'        => 'Please enter your bank’s name.',
        'bank_name.string'          => 'Bank name must be valid text.',
        'iban_number.required'      => 'Please enter your IBAN number.',
        'iban_number.string'        => 'IBAN number must be valid text.',
        'swift_code.required'       => 'Please enter your SWIFT code.',
        'swift_code.string'         => 'SWIFT code must be valid text.',
        'account_title.required'    => 'Please enter the account title.',
        'account_title.string'      => 'Account title must be valid text.',
    ];

    // 3) Validate with custom messages
    $request->validate($rules, $messages);

    // Agar yahan tak pohanch gaya, to data valid hai
    $user = Auth::user();

    $paymentMethod = PaymentMethod::create([
        'user_id'        => $user->id,
        'paymentMethod'  => $request->paymentMethod,
        'token'          => $request->token,
        'bank_name'      => $request->bank_name,
        'iban_number'    => $request->iban_number,
        'swift_code'     => $request->swift_code,
        'account_title'  => $request->account_title,
        'country_id'     => $request->country_id,
        'paypal_id'      => $request->paypal_id,
        'branch_address' => $request->branch_address,
        'is_default'     => PaymentMethod::where('user_id', $user->id)->count() === 0,
    ]);

    return response()->json([
        'message'       => 'Payment method saved successfully.',
        'paymentMethod' => $paymentMethod
    ]);
}


public function deletePaymentMethod($id)
{
    $user = Auth::user();
    
    // Find the payment method by ID and ensure it belongs to the authenticated user
    $paymentMethod = PaymentMethod::where('id', $id)->where('user_id', $user->id)->first();

    if (!$paymentMethod) {
        return response()->json(['error' => 'Payment method not found or unauthorized'], 403);
    }

    // Delete the payment method
    $paymentMethod->delete();

    return response()->json(['message' => 'Payment method deleted successfully']);
}
    // get Payment Methods
    public function getPaymentMethods()
    {
        $user = Auth::user();
        $methods = PaymentMethod::where('user_id', $user->id)->get();

        return response()->json($methods);
    }

    // Set Default Payment Method
    public function setDefaultPaymentMethod(Request $request)
    {
        $request->validate(['payment_method_id' => 'required|exists:payment_methods,id']);

        $user = Auth::user();

        // Reset previous default method
        PaymentMethod::where('user_id', $user->id)->update(['is_default' => false]);

        // Set new default
        PaymentMethod::where('id', $request->payment_method_id)->update(['is_default' => true]);

        return response()->json(['message' => 'Default payment method updated']);
    }

    // rocess Payment (Dynamic)
    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $user = Auth::user();
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        $paymentMethod = PaymentMethod::find($request->payment_method_id);

        if ($paymentMethod->type === 'Stripe') {
            return $this->stripePayment($request, $paymentMethod);
        } elseif ($paymentMethod->type === 'PayPal') {
            return $this->processPayPalPayment($request);
        }

        return response()->json(['error' => 'Invalid payment method'], 400);
    }
public function updatePaymentMethod(Request $request, $id)
{
    $user = Auth::user();

    $paymentMethod = PaymentMethod::where('id', $id)->where('user_id', $user->id)->first();

    if (!$paymentMethod) {
        return response()->json(['error' => 'Payment method not found or unauthorized'], 403);
    }

    // Validation rules same as save
    $rules = [
        'paymentMethod' => 'required'
    ];

    if ($request->paymentMethod === "Paypal") {
        $rules['paypal_id'] = 'required|email';
    } elseif ($request->paymentMethod === "Bank Transfer") {
        $rules['bank_name']    = 'required|string';
        $rules['iban_number']  = 'required|string';
        $rules['swift_code']   = 'required|string';
        $rules['account_title']= 'required|string';
    }

    $messages = [
        'paymentMethod.required'    => 'Please select a payment method.',
        'paypal_id.required'        => 'Please enter your PayPal email address.',
        'paypal_id.email'           => 'Please enter a valid PayPal email address.',
        'bank_name.required'        => 'Please enter your bank’s name.',
        'bank_name.string'          => 'Bank name must be valid text.',
        'iban_number.required'      => 'Please enter your IBAN number.',
        'iban_number.string'        => 'IBAN number must be valid text.',
        'swift_code.required'       => 'Please enter your SWIFT code.',
        'swift_code.string'         => 'SWIFT code must be valid text.',
        'account_title.required'    => 'Please enter the account title.',
        'account_title.string'      => 'Account title must be valid text.',
    ];

    $request->validate($rules, $messages);

    // Update fields accordingly
    $paymentMethod->paymentMethod = $request->paymentMethod;
    $paymentMethod->paypal_id = $request->paypal_id;
    $paymentMethod->bank_name = $request->bank_name;
    $paymentMethod->iban_number = $request->iban_number;
    $paymentMethod->swift_code = $request->swift_code;
    $paymentMethod->account_title = $request->account_title;
    $paymentMethod->country_id = $request->country_id;
    $paymentMethod->branch_address = $request->branch_address;
    // ... add any more fields you want to update

    $paymentMethod->save();

    return response()->json([
        'message' => 'Payment method updated successfully.',
        'paymentMethod' => $paymentMethod
    ]);
}


}
