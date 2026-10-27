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
        Schema::create('resume_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->longText('extracted_text')->nullable();
            $table->json('skills_json')->nullable();
            $table->unsignedInteger('ats_score')->nullable();
            $table->float('readability_score')->nullable();
            $table->longText('suggestions')->nullable();
            $table->timestamps();
            
            $table->index('resume_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_analyses');
    }
};
