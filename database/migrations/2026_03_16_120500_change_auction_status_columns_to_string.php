<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE auctions MODIFY COLUMN status VARCHAR(50) NULL');
        DB::statement('ALTER TABLE auctions_1 MODIFY COLUMN status VARCHAR(50) NULL');
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE auctions MODIFY COLUMN status ENUM('active','inactive','decline','resubmit','closed','awarded','completed','draft') NULL");
        DB::statement("ALTER TABLE auctions_1 MODIFY COLUMN status ENUM('active','inactive','decline','resubmit','closed','awarded','completed','draft') NULL");
    }
};
