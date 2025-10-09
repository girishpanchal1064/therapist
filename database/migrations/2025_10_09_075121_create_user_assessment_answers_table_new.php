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
        Schema::create('user_assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_assessment_id')->constrained('user_assessments')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('assessment_questions')->onDelete('cascade');
            $table->text('answer_text')->nullable();
            $table->integer('answer_value')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_assessment_answers');
    }
};
