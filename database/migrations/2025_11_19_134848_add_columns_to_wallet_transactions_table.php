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
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->foreignId('wallet_id')->after('id')->constrained('wallets')->onDelete('cascade');
            $table->enum('type', ['credit', 'debit'])->after('wallet_id');
            $table->decimal('amount', 10, 2)->after('type');
            $table->text('description')->nullable()->after('amount');
            $table->string('reference_type')->nullable()->after('description');
            $table->unsignedBigInteger('reference_id')->nullable()->after('reference_type');
            $table->decimal('balance_after', 10, 2)->after('reference_id');
            $table->string('payment_method')->nullable()->after('balance_after');
            $table->string('transaction_id')->nullable()->after('payment_method');
            
            $table->index(['wallet_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropIndex(['wallet_id', 'type']);
            $table->dropIndex(['reference_type', 'reference_id']);
            $table->dropColumn([
                'wallet_id',
                'type',
                'amount',
                'description',
                'reference_type',
                'reference_id',
                'balance_after',
                'payment_method',
                'transaction_id'
            ]);
        });
    }
};
