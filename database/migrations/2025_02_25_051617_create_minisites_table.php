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
        Schema::create('minisites', function (Blueprint $table) {
            $table->id();
            $table->string('page_logo')->nullable();
            $table->string('page_title');
            $table->text('page_description')->nullable();
            $table->unsignedBigInteger('page_added_by');
            $table->unsignedBigInteger('team_id');
            $table->string('document')->nullable();
            $table->string('document_title')->nullable();
            $table->unsignedBigInteger('document_added_by')->nullable();
            $table->unsignedBigInteger('document_team_id')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('page_added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('document_added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('document_team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minisites');
    }
};
