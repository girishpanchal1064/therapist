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
        Schema::table('therapist_profiles', function (Blueprint $table) {
            $table->string('prefix')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('category')->nullable();
            $table->string('user_name')->nullable();
            $table->text('brief_description')->nullable();
            $table->string('present_address')->nullable();
            $table->string('present_country')->nullable();
            $table->string('present_state')->nullable();
            $table->string('present_city')->nullable();
            $table->string('present_district')->nullable();
            $table->string('present_zip')->nullable();
            $table->string('clinic_address')->nullable();
            $table->boolean('same_as_present_address')->default(false);
            $table->string('clinic_country')->nullable();
            $table->string('clinic_state')->nullable();
            $table->string('clinic_city')->nullable();
            $table->string('clinic_district')->nullable();
            $table->string('clinic_zip')->nullable();
            $table->string('timezone')->nullable();
            $table->json('areas_of_expertise')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'prefix', 'first_name', 'middle_name', 'last_name', 'category',
                'user_name', 'brief_description', 'present_address',
                'present_country', 'present_state', 'present_city', 'present_district', 'present_zip',
                'clinic_address', 'same_as_present_address',
                'clinic_country', 'clinic_state', 'clinic_city', 'clinic_district', 'clinic_zip',
                'timezone', 'areas_of_expertise'
            ]);
        });
    }
};
