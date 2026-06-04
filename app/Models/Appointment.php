<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\TherapistEarning;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Flag to prevent double processing in observer
     */
    protected static $processingCompletion = false;

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::updating(function ($appointment) {
            // Skip if we're already processing completion
            if (self::$processingCompletion) {
                return;
            }

            // If status is being changed to 'completed' directly (not via complete() method),
            // and payment hasn't been processed, use complete() method instead
            if ($appointment->isDirty('status') 
                && $appointment->status === 'completed' 
                && $appointment->getOriginal('status') !== 'completed'
                && (!$appointment->payment || $appointment->payment->status !== 'completed')) {
                // Set flag to prevent recursion
                self::$processingCompletion = true;
                
                // Use complete() method to handle wallet deduction and payment processing
                $appointment->complete();
                
                // Reset flag
                self::$processingCompletion = false;
                
                return false; // Prevent the direct update since complete() already saves
            }
        });
    }

    protected $fillable = [
        'client_id',
        'therapist_id',
        'appointment_type',
        'session_mode',
        'appointment_date',
        'appointment_time',
        'duration_minutes',
        'status',
        'meeting_link',
        'meeting_id',
        'meeting_password',
        'session_notes',
        'prescription',
        'cancellation_reason',
        'cancelled_by',
        'cancelled_at',
        'payment_id',
        'is_activated_by_admin',
        'activated_by',
        'activated_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'datetime',
            'cancelled_at' => 'datetime',
            'is_activated_by_admin' => 'boolean',
            'activated_at' => 'datetime',
        ];
    }

    /**
     * Get the client.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the therapist.
     */
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    /**
     * Get the payment.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function consultationFeeAmount(): float
    {
        $profile = $this->therapist?->therapistProfile;
        if (! $profile) {
            return 0;
        }

        return match ($this->appointment_type) {
            'couple' => (float) ($profile->couple_consultation_fee ?: $profile->consultation_fee),
            'family' => (float) ($profile->family_consultation_fee ?: $profile->consultation_fee),
            default => (float) $profile->consultation_fee,
        };
    }

    /**
     * Get the therapist earning.
     */
    public function therapistEarning()
    {
        return $this->hasOne(TherapistEarning::class);
    }

    /**
     * Get the participants.
     */
    public function participants()
    {
        return $this->hasMany(AppointmentParticipant::class);
    }

    /**
     * Get the review.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the conversation.
     */
    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    /**
     * Get the session note for this appointment.
     */
    public function sessionNote()
    {
        return $this->hasOne(SessionNote::class, 'appointment_id');
    }

    /**
     * Get the cancelled by user.
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Scope for upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->whereIn('status', ['scheduled', 'confirmed']);
    }

    /**
     * Scope for completed appointments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for therapist appointments.
     */
    public function scopeForTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }

    /**
     * Scope for client appointments.
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Generate meeting link.
     */
    public function generateMeetingLink()
    {
        // This would integrate with video calling service (Agora, Twilio, etc.)
        $meetingId = 'meeting_' . $this->id . '_' . time();
        $this->meeting_id = $meetingId;
        $this->meeting_link = config('app.url') . '/session/' . $meetingId;
        $this->meeting_password = Str::random(8);
        $this->save();
    }

    /**
     * Normalized session start time in Asia/Kolkata.
     */
    public function appointmentStartsAt(): Carbon
    {
        $timeString = is_string($this->appointment_time)
            ? $this->appointment_time
            : (is_object($this->appointment_time)
                ? $this->appointment_time->format('H:i:s')
                : $this->appointment_time);

        if (strlen($timeString) > 8 || str_contains($timeString, '-')) {
            try {
                $timeString = Carbon::parse($timeString, 'Asia/Kolkata')->format('H:i:s');
            } catch (\Exception $e) {
                if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                    $timeString = $matches[1];
                } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                    $timeString = $matches[1] . ':00';
                }
            }
        }

        if (strlen($timeString) <= 5) {
            $timeString .= ':00';
        }

        return Carbon::parse(
            $this->appointment_date->format('Y-m-d') . ' ' . $timeString,
            'Asia/Kolkata'
        )->setTimezone('Asia/Kolkata');
    }

    /**
     * Check if appointment can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        $hoursUntilAppointment = $this->appointmentStartsAt()->diffInHours(Carbon::now('Asia/Kolkata'), false);

        return in_array($this->status, ['scheduled', 'confirmed'], true)
            && $hoursUntilAppointment > 2;
    }

    /**
     * Whether the assigned therapist may decline before the session starts.
     */
    public function canBeDeclinedByTherapist(): bool
    {
        if (! in_array($this->status, ['scheduled', 'confirmed'], true)) {
            return false;
        }

        return Carbon::now('Asia/Kolkata')->lessThan($this->appointmentStartsAt());
    }

    /**
     * Cancel the appointment.
     */
    public function cancel($reason, $userId): void
    {
        $this->status = 'cancelled';
        $this->cancellation_reason = $reason;
        $this->cancelled_by = $userId;
        $this->cancelled_at = now();
        $this->save();
    }

    /**
     * Therapist declines the session; refunds the client when payment was completed.
     */
    public function declineByTherapist(string $reason, int $therapistId): void
    {
        if ($this->therapist_id !== $therapistId) {
            throw new \RuntimeException('You are not assigned to this session.');
        }

        if (! $this->canBeDeclinedByTherapist()) {
            throw new \RuntimeException('This session can no longer be declined.');
        }

        DB::transaction(function () use ($reason, $therapistId) {
            $payment = $this->payment()->lockForUpdate()->first();

            if ($payment && $payment->status === 'completed') {
                $client = $this->client;
                if ($client) {
                    $wallet = $client->wallet;
                    if (! $wallet) {
                        $wallet = Wallet::create([
                            'user_id' => $client->id,
                            'balance' => 0,
                            'currency' => 'INR',
                        ]);
                    }

                    $wallet->addMoney(
                        (float) $payment->total_amount,
                        'Refund: session declined by therapist (Appointment #' . $this->id . ')',
                        self::class,
                        $this->id
                    );
                }

                $payment->processRefund((float) $payment->total_amount, $reason);

                $earning = TherapistEarning::where('payment_id', $payment->id)->first();
                if ($earning && (float) $earning->disbursed_amount <= 0) {
                    $earning->delete();
                }
            }

            $this->cancel($reason, $therapistId);
        });
    }

    /**
     * Declined by the therapist (cancelled with therapist as cancelled_by).
     */
    public function wasDeclinedByTherapist(): bool
    {
        return $this->status === 'cancelled'
            && $this->cancelled_by
            && (int) $this->cancelled_by === (int) $this->therapist_id;
    }

    /**
     * Complete the appointment and process payment from wallet.
     */
    public function complete()
    {
        // If already completed, don't process again
        if ($this->status === 'completed') {
            return;
        }

        // Set flag to prevent observer from interfering
        self::$processingCompletion = true;

        try {
            DB::beginTransaction();

            // Get client wallet
            $client = $this->client;
            if (!$client) {
                throw new \Exception('Client not found for this appointment');
            }

            // Get or create wallet for client
            $wallet = $client->wallet;
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id' => $client->id,
                    'balance' => 0,
                    'currency' => 'INR',
                ]);
            }

            // Calculate payment amount
            $therapist = $this->therapist;
            $consultationFee = $this->consultationFeeAmount();

            if ($consultationFee <= 0) {
                throw new \Exception('Consultation fee not set for this therapist');
            }

            $taxAmount = $consultationFee * 0.18; // 18% GST
            $totalAmount = $consultationFee + $taxAmount;

            // Check if payment already exists
            $payment = $this->payment;

            if (!$payment) {
                // Check wallet balance
                if (!$wallet->hasSufficientBalance($totalAmount)) {
                    throw new \Exception('Insufficient wallet balance. Required: ₹' . number_format($totalAmount, 2) . ', Available: ₹' . number_format($wallet->balance, 2));
                }

                // Deduct from wallet
                $wallet->deductMoney(
                    $totalAmount,
                    "Payment for appointment #{$this->id} with {$therapist->name}",
                    Appointment::class,
                    $this->id
                );

                // Create payment record
                $payment = Payment::create([
                    'user_id' => $client->id,
                    'payable_type' => Appointment::class,
                    'payable_id' => $this->id,
                    'amount' => $consultationFee,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                    'currency' => 'INR',
                    'payment_method' => 'wallet',
                    'status' => 'completed',
                    'paid_at' => now(),
                    'transaction_id' => 'wallet_' . $this->id . '_' . time(),
                ]);

                // Update appointment with payment ID
                $this->payment_id = $payment->id;

                // Create therapist earning
                $this->createTherapistEarning($payment);
            } else {
                // Payment exists, just ensure it's completed
                if ($payment->status !== 'completed') {
                    // If payment exists but not completed, check wallet balance
                    if (!$wallet->hasSufficientBalance($payment->total_amount)) {
                        throw new \Exception('Insufficient wallet balance. Required: ₹' . number_format($payment->total_amount, 2) . ', Available: ₹' . number_format($wallet->balance, 2));
                    }

                    // Deduct from wallet
                    $wallet->deductMoney(
                        $payment->total_amount,
                        "Payment for appointment #{$this->id} with {$therapist->name}",
                        Appointment::class,
                        $this->id
                    );

                    // Update payment status
                    $payment->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'payment_method' => 'wallet',
                    ]);

                    // Create therapist earning if not exists
                    if (!$this->therapistEarning) {
                        $this->createTherapistEarning($payment);
                    }
                }
            }

            // Mark appointment as completed
            $this->status = 'completed';
            $this->save();

            DB::commit();
            
            // Reset flag after successful completion
            self::$processingCompletion = false;
        } catch (\Exception $e) {
            DB::rollBack();
            self::$processingCompletion = false;
            throw $e;
        }
    }

    /**
     * Create therapist earning record
     */
    private function createTherapistEarning(Payment $payment)
    {
        // Check if earning already exists
        if (TherapistEarning::where('payment_id', $payment->id)->exists()) {
            return;
        }

        // Get commission percentage
        $commissionPercentage = \App\Models\Setting::getCommissionPercentage();
        
        // Calculate therapist earning
        $therapistAmount = ($payment->total_amount * $commissionPercentage) / 100;
        
        // Create therapist earning record
        TherapistEarning::create([
            'therapist_id' => $this->therapist_id,
            'appointment_id' => $this->id,
            'payment_id' => $payment->id,
            'due_amount' => $therapistAmount,
            'available_amount' => $therapistAmount,
            'disbursed_amount' => 0,
            'status' => 'available',
            'description' => "Commission from payment #{$payment->id} - {$commissionPercentage}% of ₹{$payment->total_amount}",
        ]);
    }

    /**
     * Get the appointment date and time.
     */
    public function getAppointmentDateTimeAttribute()
    {
        // Handle appointment_time - extract just time portion
        $timeString = is_string($this->appointment_time) 
            ? $this->appointment_time 
            : (is_object($this->appointment_time) 
                ? $this->appointment_time->format('H:i:s') 
                : $this->appointment_time);
        
        // Extract just time if it's a full datetime string
        if (strlen($timeString) > 8) {
            $timeString = \Carbon\Carbon::parse($timeString)->format('H:i:s');
        }
        
        return $this->appointment_date->format('Y-m-d') . ' ' . $timeString;
    }

    /**
     * Get the formatted appointment time.
     */
    public function getFormattedTimeAttribute()
    {
        return date('g:i A', strtotime($this->appointment_time));
    }

    /**
     * Get the formatted appointment date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('M d, Y');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-100 text-blue-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'no_show' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if therapist has an active session (in_progress)
     * 
     * @param int $therapistId
     * @param int|null $excludeAppointmentId Optional appointment ID to exclude from check
     * @return bool
     */
    public static function therapistHasActiveSession($therapistId, $excludeAppointmentId = null)
    {
        $query = static::where('therapist_id', $therapistId)
            ->where('status', 'in_progress')
            ->whereIn('session_mode', ['video', 'audio']); // Only check video/audio sessions
        
        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }
        
        return $query->exists();
    }

    /**
     * Get active session for a therapist
     * 
     * @param int $therapistId
     * @return Appointment|null
     */
    public static function getActiveSessionForTherapist($therapistId)
    {
        return static::where('therapist_id', $therapistId)
            ->where('status', 'in_progress')
            ->whereIn('session_mode', ['video', 'audio'])
            ->first();
    }
}