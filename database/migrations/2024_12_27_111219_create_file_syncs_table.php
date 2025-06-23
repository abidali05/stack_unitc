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
        Schema::create('file_syncs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->enum('type', ['file', 'folder']);
            $table->bigInteger('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('file_syncs')->onDelete('cascade'); // Optional parent folder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_syncs');
    }
};
