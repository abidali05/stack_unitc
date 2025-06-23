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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('event_title');
            $table->date('event_date');
            $table->boolean('all_day')->default(false);
            $table->time('event_start_time')->nullable();
            $table->time('event_end_time')->nullable();
            $table->string('event_location')->nullable();
            $table->text('event_description')->nullable();
            $table->string('event_shared')->nullable();

            $table->integer('reminder_value')->nullable();
            $table->enum('reminder_unit', ['minutes', 'hours', 'days', 'weeks'])->nullable();

            $table->enum('recurrence_mode',['never','on','after'])->default('never');
            $table->date('recurrence_end_date')->nullable();
            $table->integer('recurrence_count')->nullable();
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->json('recurrence_days')->nullable();

            $table->boolean('send_notification')->default(false);
            $table->json('notification_type', ['system', 'email']);
            $table->timestamps();
        });

        Schema::create('event_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id')->constrained('calendars')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_users');
        Schema::dropIfExists('calendars');
    }
};
