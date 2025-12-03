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
        Schema::create('session_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->date('session_date')->nullable();
            $table->time('start_time')->nullable();
            $table->text('chief_complaints')->nullable();
            $table->text('observations')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('reason')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->boolean('user_didnt_turn_up')->default(false);
            $table->boolean('no_follow_up_required')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_notes');
    }
};
