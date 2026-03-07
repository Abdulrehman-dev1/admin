<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AuctionCategoryController;
use Illuminate\Http\Request;

$controller = new AuctionCategoryController();
try {
    // Testing with ID 11 which we know exists
    $response = $controller->getChildern(11);
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response body: " . $response->getContent() . "\n";
    
    // Testing getChildren alias
    $responseAlias = $controller->getChildren(11);
    echo "Alias status: " . $responseAlias->getStatusCode() . "\n";
} catch (\Exception $e) {
    echo "Error calling getChildern: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
