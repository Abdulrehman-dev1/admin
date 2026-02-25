<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fix Bank Transfer SQL error: payment_method ENUM only had 'stripe','cod'.
 * Change to VARCHAR so bank_transfer, free_promotion and future methods work.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }
        // Use VARCHAR instead of ENUM - accepts any payment method (cod, stripe, bank_transfer, free_promotion)
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method VARCHAR(50) NOT NULL DEFAULT 'cod'");
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('stripe', 'cod') NOT NULL DEFAULT 'cod'");
    }
};
