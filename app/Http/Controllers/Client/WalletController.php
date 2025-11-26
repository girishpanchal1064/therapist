<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->wallet ?? Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'currency' => 'INR'
        ]);

        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('client.wallet.index', compact('wallet', 'transactions'));
    }

    public function recharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:card,netbanking,upi,google_pay,paytm,wallet'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Ensure wallet exists first
        $wallet = $user->wallet ?? Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'currency' => 'INR'
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'payable_type' => Wallet::class,
            'payable_id' => $wallet->id,
            'amount' => $amount,
            'tax_amount' => 0,
            'total_amount' => $amount,
            'currency' => 'INR',
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // For demo purposes, simulate successful payment
        // In production, integrate with payment gateway
        $payment->update([
            'transaction_id' => 'txn_' . uniqid(),
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_response' => [
                'status' => 'success',
                'method' => $request->payment_method,
                'gateway' => $this->getGatewayName($request->payment_method)
            ],
        ]);

        // Add money to wallet
        $wallet->addMoney($amount, 'Wallet recharge via ' . ucfirst(str_replace('_', ' ', $request->payment_method)), Payment::class, $payment->id);

        return redirect()->route('client.dashboard')
            ->with('success', 'Wallet recharged successfully! ₹' . number_format($amount, 2) . ' added to your wallet.');
    }

    public function transactions()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return redirect()->route('client.dashboard')
                ->with('info', 'You don\'t have a wallet yet. Recharge to create one.');
        }

        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('client.wallet.transactions', compact('wallet', 'transactions'));
    }

    private function getGatewayName($method)
    {
        $gateways = [
            'card' => 'Razorpay/Stripe',
            'netbanking' => 'Razorpay',
            'upi' => 'UPI Gateway',
            'google_pay' => 'Google Pay',
            'paytm' => 'Paytm',
            'wallet' => 'Wallet Gateway'
        ];

        return $gateways[$method] ?? 'Payment Gateway';
    }
}
