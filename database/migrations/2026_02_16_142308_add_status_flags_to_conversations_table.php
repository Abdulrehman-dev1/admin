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
        Schema::table('conversations', function (Blueprint $table) {
            $table->boolean('user_one_deleted')->default(false);
            $table->boolean('user_two_deleted')->default(false);
            $table->boolean('user_one_important')->default(false);
            $table->boolean('user_two_important')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn(['user_one_deleted', 'user_two_deleted', 'user_one_important', 'user_two_important']);
        });
    }
};
