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
            if (!Schema::hasColumn('therapist_profiles', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('therapist_profiles', 'certifications')) {
                $table->text('certifications')->nullable()->after('profile_image');
            }
            if (!Schema::hasColumn('therapist_profiles', 'education')) {
                $table->text('education')->nullable()->after('certifications');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('therapist_profiles', 'profile_image')) {
                $table->dropColumn('profile_image');
            }
            if (Schema::hasColumn('therapist_profiles', 'certifications')) {
                $table->dropColumn('certifications');
            }
            if (Schema::hasColumn('therapist_profiles', 'education')) {
                $table->dropColumn('education');
            }
        });
    }
};
