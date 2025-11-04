<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OlxScraperController extends Controller
{
    public function index()
    {
        // Get all users for dropdown
        $users = User::select('id', 'name', 'email', 'profile_pic')
            ->orderBy('name')
            ->get();

        // Get all categories for dropdown
        $categories = AuctionCategory::all();

        return view('olx-scraper.index', compact('users', 'categories'));
    }

    public function preview(Request $request)
    {
        set_time_limit(120);
        
        $request->validate([
            'url' => 'required|url'
        ]);

        // Run OLX scraper
        $script = env('SCRAPER_SCRIPT_PATH', base_path('tools/scraper/olx_scrape.py'));
        if (!file_exists($script)) {
            $script = base_path('admin/tools/scraper/olx_scrape.py');
        }
        $python = env('SCRAPER_PY_PATH', 'python');

        if (!file_exists($script)) {
            return view('olx-scraper.index', [
                'url' => $request->input('url'),
                'error' => 'OLX scraper script not found at: ' . $script,
                'users' => User::select('id', 'name', 'email', 'profile_pic')->orderBy('name')->get(),
                'categories' => AuctionCategory::all(),
            ]);
        }

        $cmd = escapeshellcmd($python) . ' ' . escapeshellarg($script) . ' ' . escapeshellarg($request->input('url'));

        $output = null;
        $returnVar = null;
        exec($cmd . ' 2>&1', $lines, $returnVar);
        $stdout = implode("\n", $lines);
        
        \Log::info('OLX Scraper exec result', ['returnVar' => $returnVar, 'stdout_length' => strlen($stdout), 'lines_count' => count($lines), 'first_500_chars' => substr($stdout, 0, 500)]);

        $data = null;
        $error = null;
        if ($returnVar === 0) {
            // Parse JSON output - find JSON in output
            $jsonStr = $stdout;
            // Try to find JSON object in output
            if (preg_match('/\{.*\}/s', $stdout, $matches)) {
                $jsonStr = $matches[0];
            }
            $json = json_decode($jsonStr, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $json;
            } else {
                $error = 'Failed to parse JSON output.';
            }
        } else {
            $error = 'Scraper error: ' . $stdout;
        }

        return view('olx-scraper.index', [
            'url' => $request->input('url'),
            'preview' => $data,
            'error' => $error,
            'raw' => $stdout,
            'exitCode' => $returnVar,
            'users' => User::select('id', 'name', 'email', 'profile_pic')->orderBy('name')->get(),
            'categories' => AuctionCategory::all(),
        ]);
    }

    public function save(Request $request)
    {
        set_time_limit(180);
        
        $request->validate([
            'url' => 'required|url',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:auction_categories,id',
            'sub_category_id' => 'nullable|exists:auction_categories,id',
            'child_category_id' => 'nullable|exists:auction_categories,id',
        ]);

        // Run OLX scraper
        $script = env('SCRAPER_SCRIPT_PATH', base_path('tools/scraper/olx_scrape.py'));
        if (!file_exists($script)) {
            $script = base_path('admin/tools/scraper/olx_scrape.py');
        }
        $python = env('SCRAPER_PY_PATH', 'python');

        if (!file_exists($script)) {
            return redirect()->route('olx-scraper.index')->with('error', 'OLX scraper script not found.');
        }

        $cmd = escapeshellcmd($python) . ' ' . escapeshellarg($script) . ' ' . escapeshellarg($request->input('url'));

        $output = null;
        $returnVar = null;
        exec($cmd . ' 2>&1', $lines, $returnVar);
        $stdout = implode("\n", $lines);
        
        Log::info('OLX Scraper exec result', [
            'returnVar' => $returnVar,
            'stdout_length' => strlen($stdout),
            'lines_count' => count($lines),
            'first_500_chars' => substr($stdout, 0, 500)
        ]);

        if ($returnVar === 0) {
            $jsonStr = $stdout;
            if (preg_match('/\{.*\}/s', $stdout, $matches)) {
                $jsonStr = $matches[0];
            }
            $json = json_decode($jsonStr, true);
            
            Log::info('OLX JSON parse result', [
                'json_error' => json_last_error(),
                'has_data' => !empty($json),
                'json_str_first_200' => substr($jsonStr, 0, 200)
            ]);
            
            if (json_last_error() === JSON_ERROR_NONE && !empty($json)) {
                Log::info('OLX Scraped data:', $json);
                
                try {
                    // Download and save images
                    $images = $json['images'] ?? [];
                    $savedImages = [];
                    $firstImage = null;
                    
                    foreach ($images as $idx => $imageUrl) {
                        try {
                            $response = Http::timeout(30)->get($imageUrl);
                            if ($response->successful()) {
                                $imageData = $response->body();
                                $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                                $fileName = time() . '_olx_' . uniqid() . '_' . $idx . '.' . $extension;
                                $savePath = public_path('/assets/images/auction/');
                                
                                if (!file_exists($savePath)) {
                                    mkdir($savePath, 0755, true);
                                }
                                
                                file_put_contents($savePath . $fileName, $imageData);
                                $localPath = '/assets/images/auction/' . $fileName;
                                $savedImages[] = $localPath;
                                
                                if ($idx === 0) {
                                    $firstImage = $localPath;
                                }
                            }
                        } catch (\Exception $e) {
                            Log::warning('OLX: Failed to download image: ' . $imageUrl, ['error' => $e->getMessage()]);
                        }
                    }
                    
                    $albumJson = json_encode($savedImages);
                    
                    // Truncate title
                    $title = $json['title'] ?? 'No title';
                    if (strlen($title) > 255) {
                        $title = substr($title, 0, 252) . '...';
                    }
                    
                    // Create auction
                    Auction::create([
                        'title' => $title,
                        'user_id' => $request->input('user_id'),
                        'category_id' => $request->input('category_id'),
                        'sub_category_id' => $request->input('sub_category_id'),
                        'child_category_id' => $request->input('child_category_id'),
                        'reserve_price' => $json['reserve_price'] ?? 0,
                        'minimum_bid' => $json['minimum_bid'] ?? 0,
                        'description' => $json['description'] ?? '',
                        'image' => $firstImage,
                        'album' => $albumJson,
                        'amenities' => json_encode($json['amenities'] ?? []),
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => now()->addDays(7),
                    ]);
                    
                    return redirect()->route('olx-scraper.index')->with('status', 'Auction saved successfully!');
                } catch (\Exception $e) {
                    Log::error('OLX Save failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    return redirect()->route('olx-scraper.index')->with('error', 'Failed to save: ' . $e->getMessage());
                }
            }
            return redirect()->route('olx-scraper.index')->with('error', 'No data scraped. Check raw output.');
        }

        Log::error('OLX Scraper command failed', ['returnVar' => $returnVar, 'stdout' => $stdout]);
        return redirect()->route('olx-scraper.index')->with('error', 'Save failed: ' . $stdout);
    }
}

