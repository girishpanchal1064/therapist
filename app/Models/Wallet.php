<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wallet transactions.
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Add money to wallet.
     */
    public function addMoney($amount, $description = null, $referenceType = null, $referenceId = null)
    {
        $this->balance += $amount;
        $this->save();

        // Create transaction record
        $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description ?? 'Money added to wallet',
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'balance_after' => $this->balance,
        ]);
    }

    /**
     * Deduct money from wallet.
     */
    public function deductMoney($amount, $description = null, $referenceType = null, $referenceId = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        $this->balance -= $amount;
        $this->save();

        // Create transaction record
        $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description ?? 'Money deducted from wallet',
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'balance_after' => $this->balance,
        ]);
    }

    /**
     * Check if wallet has sufficient balance.
     */
    public function hasSufficientBalance($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * Get formatted balance.
     */
    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance, 2) . ' ' . $this->currency;
    }
}