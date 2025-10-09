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
        Schema::create('therapist_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->text('specialization');
            $table->text('qualification');
            $table->integer('experience_years');
            $table->decimal('consultation_fee', 10, 2);
            $table->decimal('couple_consultation_fee', 10, 2);
            $table->longText('bio');
            $table->string('video_intro_url')->nullable();
            $table->json('languages');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available')->default(true);
            $table->json('verification_documents')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('total_sessions')->default(0);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
            
            $table->index('license_number');
            $table->index('is_verified');
            $table->index('is_available');
            $table->index('rating_average');
            $table->index('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_profiles');
    }
};
