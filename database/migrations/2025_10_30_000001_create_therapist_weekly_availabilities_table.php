<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_weekly_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id')->index();
            // store weekdays as json array of strings ["monday","tuesday",...]
            $table->json('days');
            // up to 4 slots; store as json array of {start,end}
            $table->json('slots');
            $table->enum('mode', ['online', 'offline'])->default('online');
            $table->enum('type', ['repeat', 'once'])->default('repeat');
            $table->string('timezone')->nullable();
            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_weekly_availabilities');
    }
};
