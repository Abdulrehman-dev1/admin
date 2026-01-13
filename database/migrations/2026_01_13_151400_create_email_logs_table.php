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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('recipient_email');
            $table->string('subject');
            $table->string('type')->nullable(); // e.g. "BidOutbidNotification" or class name
            $table->timestamp('sent_at')->useCurrent();
            $table->string('status')->default('sent');
            $table->timestamps();

            // Setup foreign key to users if you want strict integrity, 
            // but often logs are kept even if user is deleted, so maybe just index.
            // Let's add an index for performance.
            $table->index('user_id');
            $table->index('recipient_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
