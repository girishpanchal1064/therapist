<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use App\Models\TherapistEarning;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPaymentForm($appointmentId)
    {
        $appointment = Appointment::with(['therapist.therapistProfile', 'client'])
            ->findOrFail($appointmentId);
        
        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if payment already exists
        if ($appointment->payment) {
            return redirect()->route('client.dashboard')
                ->with('info', 'Payment already completed for this appointment.');
        }

        return view('payment.create', compact('appointment'));
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'payment_method' => 'required|in:razorpay,stripe',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        
        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if payment already exists
        if ($appointment->payment) {
            return response()->json(['error' => 'Payment already exists for this appointment'], 400);
        }

        // Calculate amount
        $amount = $appointment->therapist->therapistProfile->consultation_fee;
        $taxAmount = $amount * 0.18; // 18% GST
        $totalAmount = $amount + $taxAmount;

        // Create payment record
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'payable_type' => Appointment::class,
            'payable_id' => $appointment->id,
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'INR',
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Update appointment with payment ID
        $appointment->update(['payment_id' => $payment->id]);

        // Generate payment data based on method
        if ($request->payment_method === 'razorpay') {
            return $this->createRazorpayPayment($payment);
        } elseif ($request->payment_method === 'stripe') {
            return $this->createStripePayment($payment);
        }

        return response()->json(['error' => 'Invalid payment method'], 400);
    }

    private function createRazorpayPayment(Payment $payment)
    {
        // In a real application, integrate with Razorpay API
        $razorpayData = [
            'amount' => $payment->total_amount * 100, // Convert to paise
            'currency' => $payment->currency,
            'receipt' => 'receipt_' . $payment->id,
            'payment_capture' => 1,
        ];

        // For demo purposes, we'll simulate a successful payment
        $payment->update([
            'transaction_id' => 'rzp_' . uniqid(),
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_response' => ['status' => 'success', 'method' => 'card'],
        ]);

        // Create therapist earning record
        $this->createTherapistEarning($payment);

        return response()->json([
            'success' => true,
            'payment_id' => $payment->id,
            'message' => 'Payment completed successfully',
        ]);
    }

    private function createStripePayment(Payment $payment)
    {
        // In a real application, integrate with Stripe API
        $stripeData = [
            'amount' => $payment->total_amount * 100, // Convert to cents
            'currency' => strtolower($payment->currency),
            'metadata' => [
                'appointment_id' => $payment->payable_id,
                'user_id' => $payment->user_id,
            ],
        ];

        // For demo purposes, we'll simulate a successful payment
        $payment->update([
            'transaction_id' => 'pi_' . uniqid(),
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_response' => ['status' => 'succeeded', 'method' => 'card'],
        ]);

        // Create therapist earning record
        $this->createTherapistEarning($payment);

        return response()->json([
            'success' => true,
            'payment_id' => $payment->id,
            'message' => 'Payment completed successfully',
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->get('payment_id');
        
        if (!$paymentId) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Payment ID is required.');
        }

        // Handle demo/test payment IDs
        if (str_starts_with($paymentId, 'demo_')) {
            // For demo payments, just show success message
            return redirect()->route('client.dashboard')
                ->with('success', 'Payment completed successfully! Your appointment has been confirmed.');
        }

        try {
            $payment = Payment::findOrFail($paymentId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Payment not found.');
        }

        // Update payment status if still pending
        if ($payment->status === 'pending') {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Create therapist earning record
            $this->createTherapistEarning($payment);
        }

        // Update appointment status
        if ($payment->payable_type === Appointment::class) {
            $appointment = $payment->payable;
            if ($appointment && $appointment->status !== 'confirmed') {
                $appointment->update(['status' => 'confirmed']);
            }
        }

        return redirect()->route('client.dashboard')
            ->with('success', 'Payment completed successfully! Your appointment has been confirmed.');
    }

    public function paymentFailure(Request $request)
    {
        $paymentId = $request->payment_id;
        $payment = Payment::findOrFail($paymentId);

        // Update payment status
        $payment->update([
            'status' => 'failed',
            'gateway_response' => ['status' => 'failed', 'reason' => $request->reason ?? 'Payment failed'],
        ]);

        return redirect()->route('client.dashboard')
            ->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Create therapist earning record when payment is completed
     */
    private function createTherapistEarning(Payment $payment)
    {
        // Only process if payment is for an appointment
        if ($payment->payable_type !== Appointment::class) {
            return;
        }

        $appointment = $payment->payable;
        if (!$appointment || !$appointment->therapist_id) {
            return;
        }

        // Check if earning already exists
        $existingEarning = TherapistEarning::where('payment_id', $payment->id)->first();
        if ($existingEarning) {
            return;
        }

        // Get commission percentage (default 50%)
        $commissionPercentage = Setting::getCommissionPercentage();
        
        // Calculate therapist earning (commission percentage of total amount)
        $therapistAmount = ($payment->total_amount * $commissionPercentage) / 100;
        
        // Create therapist earning record
        TherapistEarning::create([
            'therapist_id' => $appointment->therapist_id,
            'appointment_id' => $appointment->id,
            'payment_id' => $payment->id,
            'due_amount' => $therapistAmount,
            'available_amount' => $therapistAmount,
            'disbursed_amount' => 0,
            'status' => 'available',
            'description' => "Commission from payment #{$payment->id} - {$commissionPercentage}% of ₹{$payment->total_amount}",
        ]);
    }

    public function refundPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'refund_reason' => 'required|string|max:500',
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        
        // Check if payment can be refunded
        if ($payment->status !== 'completed') {
            return response()->json(['error' => 'Payment cannot be refunded'], 400);
        }

        // Process refund (simplified)
        $refundAmount = $payment->total_amount;
        
        $payment->update([
            'status' => 'refunded',
            'refund_amount' => $refundAmount,
            'refund_reason' => $request->refund_reason,
            'refunded_at' => now(),
        ]);

        // Update appointment status
        if ($payment->payable_type === Appointment::class) {
            $appointment = $payment->payable;
            $appointment->update(['status' => 'cancelled']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Refund processed successfully',
            'refund_amount' => $refundAmount,
        ]);
    }
}
