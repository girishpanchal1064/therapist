<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'reference_type' => $this->reference_type,
            'reference_id' => $this->reference_id,
            'balance_after' => $this->balance_after,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'formatted_amount' => $this->formatted_amount,
            'created_at' => $this->created_at,
        ];
    }
}

