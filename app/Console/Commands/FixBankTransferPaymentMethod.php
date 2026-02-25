<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fix Bank Transfer checkout SQL error.
 * The orders.payment_method column may be ENUM('stripe','cod') which rejects 'bank_transfer'.
 * This command changes it to VARCHAR(50) so bank_transfer and future methods work.
 */
class FixBankTransferPaymentMethod extends Command
{
    protected $signature = 'bank-transfer:fix';
    protected $description = 'Fix payment_method column to allow bank_transfer (changes ENUM to VARCHAR)';

    public function handle(): int
    {
        if (!Schema::hasTable('orders')) {
            $this->error('orders table does not exist.');
            return 1;
        }

        try {
            $columnType = DB::selectOne("
                SELECT COLUMN_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'orders'
                AND COLUMN_NAME = 'payment_method'
            ");
        } catch (\Throwable $e) {
            $this->error('Could not read column type: ' . $e->getMessage());
            return 1;
        }

        if (!$columnType || empty($columnType->COLUMN_TYPE)) {
            $this->error('payment_method column not found in orders table.');
            return 1;
        }

        $type = (string) $columnType->COLUMN_TYPE;
        if (stripos($type, 'varchar') !== false) {
            $this->info('payment_method is already VARCHAR. No change needed.');
            return 0;
        }

        try {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method VARCHAR(50) NOT NULL DEFAULT 'cod'");
            $this->info('Successfully updated payment_method to VARCHAR(50). Bank transfer should now work.');
            return 0;
        } catch (\Throwable $e) {
            $this->error('Failed: ' . $e->getMessage());
            return 1;
        }
    }
}
