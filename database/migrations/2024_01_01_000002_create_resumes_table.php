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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path', 512);
            $table->string('original_filename');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('size_bytes')->default(0);
            $table->timestamp('uploaded_at')->nullable();
            $table->enum('status', ['uploaded', 'parsed', 'failed'])->default('uploaded');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
