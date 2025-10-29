<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // — Core dashboard metrics —
        $userCount              = $this->getUserCount();
        $changeCount            = $this->getUserChangeCount();
        $changePercent          = $this->getUserChangePercent();
        $labels                 = $this->getMonthlyLabels();
        $data                   = $this->getMonthlyRegistrationData();

        $productCount           = $this->getProductCount();
        $productData            = $this->getProductMonthlyData();
        $productChangeCount     = $this->getProductChangeCount();
        $productChangePercent   = $this->getProductChangePercent();

        $featuredCount          = $this->getFeaturedCount();
        $featuredData           = $this->getFeaturedMonthlyData();
        $featuredChangeCount    = $this->getFeaturedChangeCount();
        $featuredChangePercent  = $this->getFeaturedChangePercent();

        $walletTotal            = $this->getWalletTotal();
        $walletData             = $this->getWalletMonthlyData();
        $walletChangeCount      = $this->getWalletChangeCount();
        $walletChangePercent    = $this->getWalletChangePercent();

        $topAuctions            = $this->getTopAuctions();

        // — Last‑15‑day auction status series —
    $auctionLabels  = [];
$activeSeries   = [];
$wonSeries      = [];
$inactiveSeries = [];

for ($i = 29; $i >= 0; $i--) {
    $day   = Carbon::today()->subDays($i);
    $date  = $day->toDateString();
    $auctionLabels[] = $day->format('M j');

    // 1) Active by status
    $activeSeries[] = Auction::whereDate('created_at', $date)
                             ->where('status', 'active')
                             ->count();

    // 2) Won whenever winner_id is not null
    $wonSeries[]    = Auction::whereDate('created_at', $date)
                             ->whereNotNull('winner_id')
                             ->count();

    // 3) Inactive = not active AND no winner
    $inactiveSeries[] = Auction::whereDate('created_at', $date)
                               ->where('status', '!=', 'active')
                               ->whereNull('winner_id')
                               ->count();
}

        return view('dashboard', [
            // user
            'userCount'          => $userCount,
            'changeCount'        => $changeCount,
            'changePercent'      => $changePercent,
            'labels'             => $labels,
            'data'               => $data,

            // products
            'productCount'       => $productCount,
            'productData'        => $productData,
            'productChangeCount' => $productChangeCount,
            'productChangePercent' => $productChangePercent,

            // featured
            'featuredCount'        => $featuredCount,
            'featuredData'         => $featuredData,
            'featuredChangeCount'  => $featuredChangeCount,
            'featuredChangePercent'=> $featuredChangePercent,

            // wallet
            'walletTotal'          => $walletTotal,
            'walletData'           => $walletData,
            'walletChangeCount'    => $walletChangeCount,
            'walletChangePercent'  => $walletChangePercent,

            // top auctions
            'topAuctions'          => $topAuctions,

            // auction status series
             'auctionLabels'   => $auctionLabels,
                'activeSeries'    => $activeSeries,
                'wonSeries'       => $wonSeries,
                'inactiveSeries'  => $inactiveSeries,
        ]);
    }

    // ────── User metrics ──────

    protected function getUserCount(): int
    {
        return User::count();
    }

    protected function getMonthlyLabels(): array
    {
        return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    }

    protected function getMonthlyRegistrationData(): array
    {
        $year = Carbon::now()->year;
        $regs = User::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('count','month')
                ->toArray();

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = $regs[$m] ?? 0;
        }
        return $data;
    }

    protected function getUserChangeCount(): int
    {
        $data = $this->getMonthlyRegistrationData();
        $now  = Carbon::now()->month;
        $curr = $data[$now - 1] ?? 0;
        $prev = $now > 1 ? ($data[$now - 2] ?? 0) : 0;
        return $curr - $prev;
    }

    protected function getUserChangePercent(): float
    {
        $change = $this->getUserChangeCount();
        $now    = Carbon::now()->month;
        $prev   = $now > 1 ? ($this->getMonthlyRegistrationData()[$now - 2] ?? 0) : 0;
        return $prev > 0 ? round(($change / $prev) * 100, 1) : 0;
    }

    // ────── Product metrics ──────

    protected function getProductCount(): int
    {
        return Auction::count();
    }

    protected function getProductMonthlyData(): array
    {
        $year = Carbon::now()->year;
        $prods = Auction::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('count','month')
                ->toArray();

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = $prods[$m] ?? 0;
        }
        return $data;
    }

    protected function getProductChangeCount(): int
    {
        $data = $this->getProductMonthlyData();
        $now  = Carbon::now()->month;
        $curr = $data[$now - 1] ?? 0;
        $prev = $now > 1 ? ($data[$now - 2] ?? 0) : 0;
        return $curr - $prev;
    }

    protected function getProductChangePercent(): float
    {
        $change = $this->getProductChangeCount();
        $now    = Carbon::now()->month;
        $prev   = $now > 1 ? ($this->getProductMonthlyData()[$now - 2] ?? 0) : 0;
        return $prev > 0 ? round(($change / $prev) * 100, 1) : 0;
    }

    // ────── Featured metrics ──────

    protected function getFeaturedCount(): int
    {
        return Auction::whereNotNull('featured_name')->count();
    }

    protected function getFeaturedMonthlyData(): array
    {
        $year = Carbon::now()->year;
        $feats = Auction::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereNotNull('featured_name')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('count','month')
                ->toArray();

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = $feats[$m] ?? 0;
        }
        return $data;
    }

    protected function getFeaturedChangeCount(): int
    {
        $data = $this->getFeaturedMonthlyData();
        $now  = Carbon::now()->month;
        $curr = $data[$now - 1] ?? 0;
        $prev = $now > 1 ? ($data[$now - 2] ?? 0) : 0;
        return $curr - $prev;
    }

    protected function getFeaturedChangePercent(): float
    {
        $change = $this->getFeaturedChangeCount();
        $now    = Carbon::now()->month;
        $prev   = $now > 1 ? ($this->getFeaturedMonthlyData()[$now - 2] ?? 0) : 0;
        return $prev > 0 ? round(($change / $prev) * 100, 1) : 0;
    }

    // ────── Wallet metrics ──────

    protected function getWalletTotal(): float
    {
        return Wallet::sum('balance');
    }

    protected function getWalletMonthlyData(): array
    {
        $year = Carbon::now()->year;
        $raw  = Wallet::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(balance)     as total')
                )
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total','month')
                ->toArray();

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = $raw[$m] ?? 0;
        }
        return $data;
    }

    protected function getWalletChangeCount(): float
    {
        $data = $this->getWalletMonthlyData();
        $now  = Carbon::now()->month;
        $curr = $data[$now - 1] ?? 0;
        $prev = $now > 1 ? ($data[$now - 2] ?? 0) : 0;
        return $curr - $prev;
    }

    protected function getWalletChangePercent(): float
    {
        $change = $this->getWalletChangeCount();
        $now    = Carbon::now()->month;
        $prev   = $now > 1 ? ($this->getWalletMonthlyData()[$now - 2] ?? 0) : 0;
        return $prev > 0 ? round(($change / $prev) * 100, 1) : 0;
    }

    // ────── Top 3 auctions by max bid ──────

    protected function getTopAuctions()
    {
        return Auction::with('user')
            ->withMax('bids', 'bid_amount')
            ->orderByDesc('bids_max_bid_amount')
            ->take(3)
            ->get();
    }
}
