<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('coupon_code')->unique();
            $table->decimal('discount_percentage', 5, 2)->nullable(); // e.g., 25.00 for 25%
            $table->decimal('discount_amount', 10, 2)->nullable(); // Fixed discount amount
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->text('terms_conditions')->nullable();
            $table->enum('applicable_for', ['therapist', 'client', 'both'])->default('both');
            $table->enum('applicable_on', ['all', 'specific'])->default('all');
            $table->boolean('can_use_multiple_times')->default(true);
            $table->integer('max_uses_per_user')->nullable(); // null = unlimited
            $table->integer('total_max_uses')->nullable(); // null = unlimited
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['applicable_for', 'is_active', 'valid_from', 'valid_until']);
        });

        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reward_id')->constrained('rewards')->onDelete('cascade');
            $table->string('coupon_code');
            $table->enum('status', ['claimed', 'used', 'expired'])->default('claimed');
            $table->timestamp('claimed_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['reward_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
        Schema::dropIfExists('rewards');
    }
};
