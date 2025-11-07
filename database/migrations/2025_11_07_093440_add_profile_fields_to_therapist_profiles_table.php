<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('therapist_profiles', 'prefix')) {
                $table->string('prefix')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('therapist_profiles', 'first_name')) {
                $table->string('first_name')->nullable()->after('prefix');
            }
            if (!Schema::hasColumn('therapist_profiles', 'middle_name')) {
                $table->string('middle_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('therapist_profiles', 'last_name')) {
                $table->string('last_name')->nullable()->after('middle_name');
            }
            if (!Schema::hasColumn('therapist_profiles', 'category')) {
                $table->string('category')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('therapist_profiles', 'user_name')) {
                $table->string('user_name')->nullable()->after('category');
            }
            if (!Schema::hasColumn('therapist_profiles', 'brief_description')) {
                $table->text('brief_description')->nullable()->after('user_name');
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_address')) {
                $table->text('present_address')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_country')) {
                $table->string('present_country')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_state')) {
                $table->string('present_state')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_city')) {
                $table->string('present_city')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_district')) {
                $table->string('present_district')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'present_zip')) {
                $table->string('present_zip')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_address')) {
                $table->text('clinic_address')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'same_as_present_address')) {
                $table->boolean('same_as_present_address')->default(false);
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_country')) {
                $table->string('clinic_country')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_state')) {
                $table->string('clinic_state')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_city')) {
                $table->string('clinic_city')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_district')) {
                $table->string('clinic_district')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'clinic_zip')) {
                $table->string('clinic_zip')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'timezone')) {
                $table->string('timezone')->nullable();
            }
            if (!Schema::hasColumn('therapist_profiles', 'areas_of_expertise')) {
                $table->json('areas_of_expertise')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            $columns = [
                'prefix', 'first_name', 'middle_name', 'last_name', 'category', 'user_name', 'brief_description',
                'present_address', 'present_country', 'present_state', 'present_city', 'present_district', 'present_zip',
                'clinic_address', 'same_as_present_address', 'clinic_country', 'clinic_state', 'clinic_city', 'clinic_district', 'clinic_zip',
                'timezone', 'areas_of_expertise'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('therapist_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
