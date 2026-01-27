<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $query = Payment::with(['user', 'payable']);

        // Filter by status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.payments.index', compact('payments', 'status', 'search', 'perPage'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing payments
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $payment->load(['user', 'payable']);
        $users = User::orderBy('name')->get();
        return view('admin.payments.edit', compact('payment', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'payment_method' => 'required|in:razorpay,stripe,wallet,coupon',
            'payment_gateway' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'paid_at' => 'nullable|date',
            'refund_amount' => 'nullable|numeric|min:0',
            'refunded_at' => 'nullable|date',
            'refund_reason' => 'nullable|string|max:1000',
        ]);

        // Convert datetime-local to proper datetime format
        if ($request->filled('paid_at')) {
            $validated['paid_at'] = \Carbon\Carbon::parse($request->paid_at);
        } else {
            $validated['paid_at'] = null;
        }

        if ($request->filled('refunded_at')) {
            $validated['refunded_at'] = \Carbon\Carbon::parse($request->refunded_at);
        } else {
            $validated['refunded_at'] = null;
        }

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index');
    }

    public function pending(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $query = Payment::with(['user', 'payable'])->where('status', 'pending');

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.payments.pending', compact('payments', 'search', 'perPage'));
    }

    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $query = Payment::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Total statistics
        $totalRevenue = (clone $query)->where('status', 'completed')->sum('total_amount');
        $totalPending = (clone $query)->where('status', 'pending')->sum('total_amount');
        $totalFailed = (clone $query)->where('status', 'failed')->sum('total_amount');
        $totalRefunded = (clone $query)->where('status', 'refunded')->sum('refund_amount') ?? 0;

        // Count statistics
        $totalPayments = (clone $query)->count();
        $completedCount = (clone $query)->where('status', 'completed')->count();
        $pendingCount = (clone $query)->where('status', 'pending')->count();
        $failedCount = (clone $query)->where('status', 'failed')->count();
        $refundedCount = (clone $query)->where('status', 'refunded')->count();

        // Payment method statistics
        $paymentMethods = (clone $query)
            ->where('status', 'completed')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('payment_method')
            ->get();

        // Daily revenue for chart
        $dailyRevenue = (clone $query)
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent payments
        $recentPayments = Payment::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.payments.reports', compact(
            'totalRevenue',
            'totalPending',
            'totalFailed',
            'totalRefunded',
            'totalPayments',
            'completedCount',
            'pendingCount',
            'failedCount',
            'refundedCount',
            'paymentMethods',
            'dailyRevenue',
            'recentPayments',
            'startDate',
            'endDate'
        ));
    }

    public function refund(Payment $payment)
    {
        $payment->update(['status' => 'refunded']);
        return redirect()->back();
    }
}
