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
        Schema::table('emails', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('description');
            $table->boolean('is_starred')->default(false)->after('is_read');
            $table->boolean('is_draft')->default(false)->after('is_starred');
            $table->softDeletes()->after('is_starred');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn(['is_read', 'is_starred', 'is_draft']);
            $table->dropSoftDeletes();
        });
    }
};
