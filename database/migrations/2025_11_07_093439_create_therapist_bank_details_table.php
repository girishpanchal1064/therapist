<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_profile_id')->constrained('therapist_profiles')->onDelete('cascade');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('ifsc_code');
            $table->string('branch_name')->nullable();
            $table->enum('account_type', ['savings', 'current'])->default('savings');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_bank_details');
    }
};
