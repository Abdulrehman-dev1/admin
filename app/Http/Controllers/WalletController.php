<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\NewNotification;
use App\Models\Auction;       
use App\Models\Transactions as Transaction; // Ensure correct model import

class WalletController extends Controller
{
    public function getWallet(Request $request)
    {
        $wallet = Wallet::where('user_id', $request->user()->id)->first();
        
        if (!$wallet) {
            return response()->json(['error' => 'Wallet not found'], 200);
        }

        return response()->json(['balance' => $wallet->balance]);
    }

    public function addMoney(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $wallet = Wallet::firstOrCreate(['user_id' => $request->user()->id]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'type' => 'add',
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Simulate payment gateway processing
        $transaction->update(['status' => 'completed']);

        // Update wallet balance
        $wallet->increment('balance', $request->amount);

        return response()->json(['message' => 'Money added successfully']);
    }

    public function getTransactions(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)->get();
        return response()->json($transactions);
    }

    public function stripePayment(Request $request)
    {
        
     
    $request->validate(
    ['amount' => 'required|numeric|min:50'],
    [
        'amount.required' => 'Please enter an amount.',
        'amount.numeric'  => 'Amount must be a valid number.',
        'amount.min'      => 'Please enter an amount of at least $50 USD.',
    ]
);
        $user = $request->user();
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

        // Simulated Stripe Payment Processing
        $amount = $request->amount;

        // Update wallet balance
        $wallet->increment('balance', $amount);

        // Log transaction correctly
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'Stripe',
        ]);
     
   
        return response()->json(['message' => 'Payment successful', 'balance' => $wallet->balance]);
    }

    public function paypalPayment(Request $request)
    {
        $request->validate([
            'paypal_email' => 'required|email',
            'amount' => 'required|numeric|min:10'
        ]);

        $user = $request->user();
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

        $amount = $request->amount;

        // Update wallet balance
        $wallet->increment('balance', $amount);

        // Log transaction
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'PayPal',
        ]);

        return response()->json(['message' => 'Payment successful', 'balance' => $wallet->balance]);
    }
public function deductMoney(Request $request)
{
    $data = $request->validate([
        'amount'      => 'required|numeric|min:1',
        'product_id'  => 'required|integer|exists:auctions,id',
        'title'       => 'required|string|max:255',
        // 'category_id' => 'required|integer|exists:auction_categories,id', // <-- REMOVE THIS LINE
        'album'       => 'nullable|string',
    ]);

    $user   = $request->user();
    $wallet = Wallet::where('user_id', $user->id)->first();

    if (! $wallet) {
        return response()->json(['error' => 'Wallet not found'], 404);
    }

    if ($wallet->balance < $data['amount']) {
        return response()->json(['error' => 'Insufficient funds'], 400);
    }

    // 1) Log the transaction (remove category_id from here too)
    $transaction = Transaction::create([
        'user_id'     => $user->id,
        'type'        => 'deduction',
        'amount'      => $data['amount'],
        'status'      => 'completed',
        'product_id'  => $data['product_id'],
        'title'       => $data['title'],
        // 'category_id' => $data['category_id'], // <-- REMOVE THIS LINE
        'album'       => $data['album'] ?? null,
    ]);

    // 2) Set the auction's featured_name to home_featured (NO category check)
    $auction = \App\Models\Auction::find($data['product_id']);
    if ($auction) {
        $auction->featured_name = 'home_featured';
        $auction->save();
    }

    // 3) Deduct from wallet
    $wallet->decrement('balance', $data['amount']);

    return response()->json([
        'message'     => 'Amount deducted & auction updated successfully',
        'balance'     => $wallet->balance,
        'transaction' => $transaction,
    ]);
}
public function index()
    {
        $wallets = Wallet::with('user')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

        return view('wallet.index', compact('wallets'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        $data = $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);

        $wallet->balance = $data['balance'];
        $wallet->save();

        return response()->json([
            'message' => 'Balance updated successfully.',
            'balance' => $wallet->balance,
        ]);
    }


}
