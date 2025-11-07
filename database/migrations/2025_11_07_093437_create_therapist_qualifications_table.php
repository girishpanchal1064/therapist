<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_profile_id')->constrained('therapist_profiles')->onDelete('cascade');
            $table->string('name_of_degree');
            $table->string('degree_in');
            $table->string('institute_university');
            $table->year('year_of_passing');
            $table->string('percentage_cgpa')->nullable();
            $table->string('certificate')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_qualifications');
    }
};
