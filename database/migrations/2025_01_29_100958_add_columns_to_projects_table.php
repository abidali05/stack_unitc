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
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('category', ['task', 'tweak', 'bug', 'custom'])->default('task');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('document')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['category', 'start_date', 'end_date', 'document', 'view_count']);
        });
    }
};
