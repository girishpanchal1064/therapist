<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_single_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id')->index();
            $table->date('date');
            // up to 4 slots; store as json array of {start,end}
            $table->json('slots');
            $table->enum('mode', ['online', 'offline'])->default('online');
            $table->enum('type', ['once'])->default('once');
            $table->string('timezone')->nullable();
            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['therapist_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_single_availabilities');
    }
};
