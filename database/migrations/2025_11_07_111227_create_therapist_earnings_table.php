<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->decimal('due_amount', 10, 2)->default(0); // Amount therapist should receive
            $table->decimal('available_amount', 10, 2)->default(0); // Amount available for withdrawal
            $table->decimal('disbursed_amount', 10, 2)->default(0); // Amount already paid out
            $table->enum('status', ['pending', 'available', 'disbursed', 'cancelled'])->default('pending');
            $table->timestamp('disbursed_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['therapist_id', 'status']);
            $table->index('appointment_id');
            $table->index('payment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_earnings');
    }
};
