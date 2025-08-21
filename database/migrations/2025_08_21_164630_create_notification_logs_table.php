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
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('channel')->default('email');
            $table->morphs('notifiable');
            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            // External receiver info
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();

            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('sent');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
