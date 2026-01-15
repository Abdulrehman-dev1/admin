<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\ProductVariation;
use Illuminate\Support\Str;

class ShopifyProductImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:shopify {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from Shopify CSV into auctions and variations tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        $allRowsByHandle = [];
        $targetHandles = [];

        while (($row = fgetcsv($file)) !== false) {
            $data = [];
            foreach ($header as $i => $h) {
                $data[$h] = $row[$i] ?? null;
            }

            $handle = $data['Handle'];
            if (empty($handle)) continue;

            if (!isset($allRowsByHandle[$handle])) {
                $allRowsByHandle[$handle] = [];
            }
            $allRowsByHandle[$handle][] = $data;

            // If any row has the target type, mark the handle as a target
            if (($data['Type'] ?? '') === 'Dinnerware Sets') {
                $targetHandles[$handle] = true;
            }
        }
        fclose($file);

        // Filter products to only include target handles
        $products = array_intersect_key($allRowsByHandle, $targetHandles);

        $this->info("Found " . count($products) . " unique products of type 'Dinnerware Sets' to process.");

        $storagePath = public_path('/assets/images/auction/');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        foreach ($products as $handle => $rows) {
            // The first row of the handle usually contains the main info (Title, Body, etc.)
            // But sometimes subsequent rows have images but no title. We need to inherit.
            $mainInfo = $rows[0];
            foreach ($rows as $row) {
                if (!empty($row['Title'])) {
                    $mainInfo = $row;
                    break;
                }
            }

            $this->info("Importing Product: " . $mainInfo['Title']);

            // Delete if already exists to ensure a clean re-import (as requested to fix images/variants)
            $existingAuctions = Auction::where('title', $mainInfo['Title'])->where('user_id', 349)->get();
            foreach ($existingAuctions as $existing) {
                $this->warn("Product exists (ID: {$existing->id}), deleting for clean re-import: " . $mainInfo['Title']);
                $existing->variations()->delete();
                $existing->delete();
            }

            // 1. Handle Images (Download and Store Locally)
            $localImages = [];
            foreach ($rows as $row) {
                if (!empty($row['Image Src'])) {
                    $url = $row['Image Src'];
                    $localPath = $this->downloadImage($url, $storagePath);
                    if ($localPath) {
                        $localImages[] = $localPath;
                    }
                }
            }

            $mainImage = !empty($localImages) ? $localImages[0] : null;
            $album = count($localImages) > 0 ? json_encode($localImages) : json_encode([]);

            // 2. Create or Update Auction
            // (Using handle as a unique reference if we want to avoid duplicates later, 
            // but here we just create a new one as requested)
            $auction = Auction::create([
                'title' => $mainInfo['Title'],
                'description' => $mainInfo['SEO Description'] ?? $mainInfo['Title'],
                'user_id' => 349,
                'category_id' => 574,
                'sub_category_id' => 576,
                'image' => $mainImage,
                'album' => $album,
                'list_type' => 'normal_list',
                'product_condition' => 'new',
                'reserve_price' => floatval($mainInfo['Variant Price'] ?: 0),
                'minimum_bid' => floatval($mainInfo['Variant Price'] ?: 0),
                'status' => 'active',
                'featured_name' => 'home_featured',
                'product_year' => date('Y'), // Added default year as per controller rules
                'discount_type' => 'percent',
                'discount_value' => 10,
            ]);

            // 3. Create Variations
            // We iterate through all rows because each row in Shopify CSV with variant info is a variant
            foreach ($rows as $row) {
                $optionValue = $row['Option1 Value'];

                if (!empty($optionValue)) {
                    // Use only the option value as the name (e.g. "4 Person Serving Dinner Set = 22 PCS")
                    $variationName = $optionValue;
                    
                    ProductVariation::create([
                        'auction_id' => $auction->id,
                        'name' => $variationName,
                        'price' => floatval($row['Variant Price'] ?: 0),
                        'discount_type' => 'percent',
                        'discount_value' => 10,
                    ]);
                }
            }
        }

        $this->info("Import completed successfully.");
        return 0;
    }

    /**
     * Download image from URL and save to local storage.
     *
     * @param string $url
     * @param string $storagePath
     * @return string|null
     */
    private function downloadImage($url, $storagePath)
    {
        try {
            $contents = file_get_contents($url);
            if ($contents === false) return null;

            // Extract file extension cleanly
            $path = parse_url($url, PHP_URL_PATH);
            $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg';
            
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $filePath = $storagePath . $filename;

            file_put_contents($filePath, $contents);

            return '/assets/images/auction/' . $filename;
        } catch (\Exception $e) {
            $this->error("Failed to download image: " . $url);
            return null;
        }
    }
}
