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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();  // Tipe BIGINT AUTO_INCREMENT
            $table->foreignId('folder_id')->constrained()->onDelete('cascade');  // Relasi ke folder
            $table->string('name');
            $table->string('path');  // Path file di server (jika diperlukan)
            $table->string('google_drive_id');  // ID file di Google Drive
            $table->text('description')->nullable();
            $table->timestamps();  // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
