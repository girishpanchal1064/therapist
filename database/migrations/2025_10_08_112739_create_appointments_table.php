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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('therapist_id')->constrained('users')->onDelete('cascade');
            $table->enum('appointment_type', ['individual', 'couple', 'family']);
            $table->enum('session_mode', ['video', 'audio', 'chat']);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('duration_minutes')->default(45);
            $table->enum('status', ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->string('meeting_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->longText('session_notes')->nullable();
            $table->longText('prescription')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');
            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained('payments');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['client_id', 'status'], 'appointments_client_status_index');
            $table->index(['therapist_id', 'status'], 'appointments_therapist_status_index');
            $table->index(['appointment_date', 'appointment_time'], 'appointments_datetime_index');
            $table->index('status');
            $table->index('appointment_type');
            $table->index('session_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
