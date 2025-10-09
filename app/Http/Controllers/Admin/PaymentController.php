<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user'])->paginate(15);
        return view('admin.payments.index', compact('payments'));
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
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        // Implementation for updating payments
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index');
    }

    public function pending()
    {
        $payments = Payment::where('status', 'pending')->paginate(15);
        return view('admin.payments.pending', compact('payments'));
    }

    public function reports()
    {
        return view('admin.payments.reports');
    }

    public function refund(Payment $payment)
    {
        $payment->update(['status' => 'refunded']);
        return redirect()->back();
    }
}
