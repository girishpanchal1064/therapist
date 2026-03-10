<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletTransactionResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Get the authenticated user's wallet details and recent transactions.
     */
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $wallet = $user->wallet;

        if (! $wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'INR',
            ]);
        }

        $recentTransactions = $wallet->transactions()
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'wallet' => [
                    'id' => $wallet->id,
                    'balance' => $wallet->balance,
                    'formatted_balance' => $wallet->formatted_balance,
                    'currency' => $wallet->currency,
                ],
                'recent_transactions' => WalletTransactionResource::collection($recentTransactions),
            ],
        ]);
    }

    /**
     * List wallet transactions for the authenticated user with pagination and optional filters.
     */
    public function transactions(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $wallet = $user->wallet;

        if (! $wallet) {
            return response()->json([
                'success' => true,
                'data' => [
                    'wallet' => null,
                    'items' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 1,
                        'per_page' => (int) $request->get('per_page', 15),
                        'total' => 0,
                    ],
                ],
            ]);
        }

        $query = $wallet->transactions()->orderByDesc('id');

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }

        $perPage = (int) $request->get('per_page', 15);
        $transactions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'wallet' => [
                    'id' => $wallet->id,
                    'balance' => $wallet->balance,
                    'formatted_balance' => $wallet->formatted_balance,
                    'currency' => $wallet->currency,
                ],
                'items' => WalletTransactionResource::collection($transactions),
                'pagination' => [
                    'current_page' => $transactions->currentPage(),
                    'last_page' => $transactions->lastPage(),
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                ],
            ],
        ]);
    }

    /**
     * Create a simple top-up on the wallet (expects that the payment is already processed by gateway).
     * This endpoint should be called only after successful payment confirmation on the client or backend.
     */
    public function confirmTopup(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'string', 'max:50'],
            'transaction_id' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $wallet = $user->wallet;

        if (! $wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'INR',
            ]);
        }

        $beforeBalance = $wallet->balance;
        $amount = (float) $validated['amount'];

        $wallet->addMoney(
            $amount,
            $validated['description'] ?? 'Wallet top-up',
            null,
            null
        );

        // Update last transaction with payment meta if needed
        $transaction = $wallet->transactions()->latest('id')->first();
        if ($transaction) {
            $transaction->payment_method = $validated['payment_method'];
            $transaction->transaction_id = $validated['transaction_id'];
            $transaction->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Wallet topped up successfully.',
            'data' => [
                'wallet' => [
                    'id' => $wallet->id,
                    'balance_before' => $beforeBalance,
                    'balance_after' => $wallet->balance,
                    'formatted_balance' => $wallet->formatted_balance,
                    'currency' => $wallet->currency,
                ],
                'transaction' => $transaction ? new WalletTransactionResource($transaction) : null,
            ],
        ]);
    }
}

