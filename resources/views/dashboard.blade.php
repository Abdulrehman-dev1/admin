@extends('layouts.app')

@section('content')
<style>
    /* Premium Dashboard Styles from previous iteration + New Specifics */
    :root {
        --primary-indigo: #6366F1;
        --success-emerald: #10B981;
        --bg-color: #F3F4F6;
        --card-bg: #ffffff;
        --text-dark: #1F2937;
        --text-light: #6B7280;
    }
    
    body { background-color: var(--bg-color); }
    
    .dashboard-container { padding: 30px; }

    /* 6 Boxes Grid */
    .stat-box {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .stat-chart-container {
        height: 60px; /* Small height for mini graphs */
        width: 100%;
    }

    /* Top 3 Bids Product Card */
    .product-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s;
        border: 1px solid #E5E7EB;
        height: 100%;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-img-wrapper {
        height: 180px;
        position: relative;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        background: rgba(255,255,255,0.9);
        color: var(--primary-indigo);
    }
    .product-details { padding: 15px; }
    .product-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 5px;
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .highest-bid-label { font-size: 12px; color: var(--text-light); }
    .highest-bid-val { font-size: 18px; font-weight: 800; color: #10B981; }

    /* Large Graph Section */
    .large-graph-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-top: 30px;
    }
    .filter-btn-group .btn {
        border-radius: 20px;
        padding: 6px 20px;
        font-size: 13px;
        font-weight: 600;
        margin-right: 5px;
    }
    .filter-btn-group .btn-active {
        background-color: var(--primary-indigo);
        color: #fff;
    }
    .filter-btn-group .btn-inactive {
        background-color: #F3F4F6;
        color: var(--text-light);
    }
</style>

<div class="dashboard-container">
    
    <!-- Row 1: 6 Metric Boxes (3 per row) -->
    <div class="row g-4 mb-5">
        <!-- 1. Total Users -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                <div>
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">{{ $userCount }}</div>
                </div>
                <div id="chartUsers" class="stat-chart-container"></div>
            </div>
        </div>

        <!-- 2. Total Products (Auctions) -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                <div>
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">{{ $productCount }}</div>
                </div>
                <div id="chartProducts" class="stat-chart-container"></div>
            </div>
        </div>

        <!-- 3. Auction Listings -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                <div>
                    <div class="stat-title">Auction Listings</div>
                    <div class="stat-value">{{ $auctionListingCount }}</div>
                </div>
                 <div id="chartAuctions" class="stat-chart-container"></div>
            </div>
        </div>

        <!-- 4. Normal Listings -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                 <div>
                    <div class="stat-title">Normal Listings</div>
                    <div class="stat-value">{{ $normalListingCount }}</div>
                </div>
                 <div id="chartNormal" class="stat-chart-container"></div>
            </div>
        </div>

        <!-- 5. Verified Users -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                 <div>
                    <div class="stat-title">Verified Users</div>
                    <div class="stat-value">{{ $verifiedUserCount }}</div>
                </div>
                 <div id="chartVerified" class="stat-chart-container"></div>
            </div>
        </div>

        <!-- 6. Total Bids -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                 <div>
                    <div class="stat-title">Total Bids</div>
                    <div class="stat-value">{{ $totalBidsCount }}</div>
                </div>
                 <div id="chartBids" class="stat-chart-container"></div>
            </div>
        </div>
    </div>

    <!-- Row 2: Top 3 Highest Bids Product Cards -->
     <div class="mb-5">
        <h4 style="font-weight: 800; color: #111827; margin-bottom: 20px;">🔥 Top 3 Highest Bids</h4>
        <div class="row g-4">
            @foreach($topAuctions as $auction)
                 @php
                    $raw = $auction->image;
                    $firstImage = null;
                    if ($raw) {
                    if (str_starts_with($raw, '[')) {
                        $arr = json_decode($raw, true) ?: [];
                        $firstImage = $arr[0] ?? null;
                    } else {
                        $firstImage = $raw;
                    }
                    }
                    $imgUrl = $firstImage ? asset(ltrim($firstImage, '/')) : asset('img/default.png');
                @endphp
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ $imgUrl }}" alt="{{ $auction->title }}">
                            <span class="product-badge">{{ $auction->bids->count() }} Bids</span>
                        </div>
                        <div class="product-details">
                            <h5 class="product-title" title="{{ $auction->title }}">{{ $auction->title }}</h5>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <div>
                                    <div class="highest-bid-label">Highest Bid</div>
                                    <div class="highest-bid-val">${{ number_format($auction->bids_max_bid_amount, 2) }}</div>
                                </div>
                                <div class="text-end">
                                    <img src="{{ optional($auction->user)->profile_pic ? asset(ltrim($auction->user->profile_pic, '/')) : asset('img/default-profile.png') }}" class="rounded-circle" width="30" height="30" title="Seller: {{ optional($auction->user)->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Row 3: Large Graph with Filters -->
    <div class="large-graph-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 style="font-weight: 800; color: #111827;">User Overview</h4>
            <div class="filter-btn-group">
                <button class="btn btn-active" onclick="updateLargeGraph('year', this)">Year</button>
                <button class="btn btn-inactive" onclick="updateLargeGraph('month', this)">Month</button>
                <button class="btn btn-inactive" onclick="updateLargeGraph('week', this)">Week</button>
            </div>
        </div>
        <div id="largeAcquisitionChart" style="min-height: 400px;"></div>
    </div>

</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- Helper for small charts ---
        function createMiniChart(selector, name, data, color) {
            var options = {
                series: [{ name: name, data: data }],
                chart: { type: 'area', height: 60, sparkline: { enabled: true } },
                stroke: { curve: 'smooth', width: 2 },
                fill: { opacity: 0.2 },
                colors: [color],
                tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
            };
            new ApexCharts(document.querySelector(selector), options).render();
        }

        // 1. Render 6 Mini Charts
        createMiniChart("#chartUsers", "Users", @json($data), "#6366F1");
        createMiniChart("#chartProducts", "Products", @json($productData), "#10B981");
        createMiniChart("#chartAuctions", "Auctions", @json($auctionListingData), "#F59E0B");
        createMiniChart("#chartNormal", "Normal Listings", @json($normalListingData), "#EC4899");
        createMiniChart("#chartVerified", "Verified", @json($verifiedUserData), "#3B82F6");
        createMiniChart("#chartBids", "Bids", @json($totalBidsData), "#8B5CF6");

        // 2. Large Graph Logic
        var initialData = @json($largeGraphData);
        
        var largeChartOptions = {
            series: [
                { name: 'Registered Users', data: initialData.datasets.registered },
                { name: 'Verified Users', data: initialData.datasets.verified },
                { name: 'Referral Users', data: initialData.datasets.referral },
                { name: 'UTM Source', data: initialData.datasets.utm }
            ],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                stacked: false
            },
            colors: ['#6366F1', '#10B981', '#F59E0B', '#EC4899'],
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: initialData.labels,
            },
            yaxis: {
                title: { text: 'Count' }
            },
            fill: { opacity: 1 },
            tooltip: {
                y: { formatter: function (val) { return val + " users" } }
            },
            plotOptions: {
                bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 }
            }
        };

        var largeChart = new ApexCharts(document.querySelector("#largeAcquisitionChart"), largeChartOptions);
        largeChart.render();
        
        // --- Filter Update Function ---
        window.updateLargeGraph = function(filter, btn) {
            // Update buttons UI
            document.querySelectorAll('.filter-btn-group .btn').forEach(b => {
                b.classList.remove('btn-active');
                b.classList.add('btn-inactive');
            });
            btn.classList.remove('btn-inactive');
            btn.classList.add('btn-active');
            
            // AJAX Call to fetch new data
            fetch("{{ route('dashboard.graph-data') }}?filter=" + filter)
                .then(response => response.json())
                .then(data => {
                    largeChart.updateOptions({
                        xaxis: {
                            categories: data.labels
                        }
                    });
                    largeChart.updateSeries([
                        { name: 'Registered Users', data: data.datasets.registered },
                        { name: 'Verified Users', data: data.datasets.verified },
                        { name: 'Referral Users', data: data.datasets.referral },
                        { name: 'UTM Source', data: data.datasets.utm }
                    ]);
                })
                .catch(error => console.error('Error fetching graph data:', error));
        };
    });
</script>
@endsection