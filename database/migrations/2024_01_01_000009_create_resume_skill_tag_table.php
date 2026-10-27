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
        Schema::create('resume_skill_tag', function (Blueprint $table) {
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->primary(['resume_id', 'skill_tag_id']);
            $table->index('resume_id');
            $table->index('skill_tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_skill_tag');
    }
};
