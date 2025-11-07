<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_availability_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id')->index();
            // Either a date range OR single date+slots; represent both
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('date')->nullable();
            // optional blocked slots for a date; json array of {start,end}
            $table->json('blocked_slots')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['date']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_availability_blocks');
    }
};
