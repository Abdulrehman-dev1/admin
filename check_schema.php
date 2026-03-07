<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$columns = Schema::getColumnListing('auction_categories');
print_r($columns);

try {
    $sample = DB::table('auction_categories')->first();
    print_r($sample);
} catch (\Exception $e) {
    echo "Error fetching sample: " . $e->getMessage();
}
