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
        Schema::create('interview_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_question_id')->constrained()->onDelete('cascade');
            $table->longText('answer_text')->nullable();
            $table->string('answer_audio_path', 512)->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->json('evaluation_json')->nullable();
            $table->float('score')->nullable();
            $table->timestamps();
            
            $table->index('interview_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_answers');
    }
};
