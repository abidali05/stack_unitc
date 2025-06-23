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
        Schema::create('file_sync_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('file_syncs')->onDelete('cascade');
            $table->foreignId('share_with_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('share_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sync_shares');
    }
};
