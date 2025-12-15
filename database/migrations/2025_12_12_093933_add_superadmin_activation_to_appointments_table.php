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
        Schema::table('appointments', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('appointments', 'is_activated_by_admin')) {
                $table->boolean('is_activated_by_admin')->default(false)->after('status');
            }
            if (!Schema::hasColumn('appointments', 'activated_by')) {
                $table->unsignedBigInteger('activated_by')->nullable()->after('is_activated_by_admin');
                $table->foreign('activated_by')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('appointments', 'activated_at')) {
                $table->timestamp('activated_at')->nullable()->after('activated_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'activated_at')) {
                $table->dropColumn('activated_at');
            }
            if (Schema::hasColumn('appointments', 'activated_by')) {
                $table->dropForeign(['activated_by']);
                $table->dropColumn('activated_by');
            }
            if (Schema::hasColumn('appointments', 'is_activated_by_admin')) {
                $table->dropColumn('is_activated_by_admin');
            }
        });
    }
};
