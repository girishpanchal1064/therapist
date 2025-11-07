<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_profile_id')->constrained('therapist_profiles')->onDelete('cascade');
            $table->string('designation');
            $table->string('hospital_organisation');
            $table->date('starting_date');
            $table->date('last_date')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_experiences');
    }
};
