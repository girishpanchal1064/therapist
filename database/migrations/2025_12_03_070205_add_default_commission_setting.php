<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert default commission percentage (50%)
        DB::table('settings')->insert([
            'key' => 'therapist_commission_percentage',
            'value' => '50',
            'type' => 'number',
            'description' => 'Therapist commission percentage (0-100). Default is 50%, meaning therapist gets 50% of payment and platform keeps 50%.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('key', 'therapist_commission_percentage')->delete();
    }
};
