<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blast_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('participants')->onDelete('cascade');
            $table->foreignId('scheduled_reminder_id')->nullable()->constrained('scheduled_reminders')->onDelete('set null');
            $table->text('message_content');
            $table->enum('channel', ['email', 'whatsapp', 'sms']);
            $table->enum('status', ['sent', 'failed']);
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blast_histories');
    }
};
