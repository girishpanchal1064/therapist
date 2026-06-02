<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('therapist_profiles', 'family_consultation_fee')) {
                $table->decimal('family_consultation_fee', 10, 2)->default(0)->after('couple_consultation_fee');
            }
        });
    }

    public function down(): void
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('therapist_profiles', 'family_consultation_fee')) {
                $table->dropColumn('family_consultation_fee');
            }
        });
    }
};
