@extends('layouts.app')
@section('content')
<style>
    .nftmax-body {
     background: transparent  !important; 
    padding: 30px;
    padding-top:0px !important;
    border-radius: 15px;
     box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.00); 
     margin-top:0px !important;
}
.fs{
    font-size:40px !important;
}
</style>
	<div class="row nftmax-gap-30">
											<div class="col-lg-3 col-md-6 col-12">
											    	<div class="nftmax-history mg-top-40">
  <div class="nftmax-history__main">
    <div class="nftmax-history__content">
      <div class="nftmax-history__icon nftmax-history__icon-three">
        <img src="{{ asset('img/history-icon-3.png') }}" alt="#">
      </div>
      <div class="nftmax-history__text">
        <h4 class="nftmax-history__number">
          <span class="number">{{ $userCount }}</span>
        </h4>
        <p class="nftmax-history__text">Total Users</p>
        <p class="nftmax-history__amount">
    {{ $changeCount >= 0 ? '+' : '' }}{{ $changeCount }}
    ({{ $changePercent }}%)
  </p>
      </div>
    </div>
    <div class="nftmax-history__canvas">
      <div class="charts-main__one">
        <canvas id="myChart_history_three"></canvas>
      </div>
    </div>
  </div>
</div>
									

											</div>
											<div class="col-lg-3 col-md-6 col-12">
											    
										
	<div class="nftmax-history mg-top-40">
  <div class="nftmax-history__main">
    <div class="nftmax-history__content">
      <div class="nftmax-history__icon nftmax-history__icon-two">
        <img src="{{ asset('img/history-icon-2.png') }}" alt="#">
      </div>
      <div class="nftmax-history__text">
        <h4 class="nftmax-history__number">
          <span class="number">{{ $productCount }}</span> <!-- dynamic count -->
        </h4>
        <p class="nftmax-history__text">Total Products</p>
        <p class="nftmax-history__amount">
  {{ $productChangeCount >= 0 ? '+' : '' }}{{ $productChangeCount }}
  ({{ $productChangePercent }}%)
</p>
      </div>
    </div>
    <div class="nftmax-history__canvas">
      <div class="charts-main__one">
        <canvas id="myChart_history_two"></canvas>
      </div>
    </div>
  </div>
</div>
											</div>
											<div class="col-lg-3 col-md-6 col-12">
										
		<div class="nftmax-history mg-top-40">
  <div class="nftmax-history__main">
    <div class="nftmax-history__content">
      <div class="nftmax-history__icon nftmax-history__icon-one">
        <img src="{{ asset('img/history-icon-1.png') }}" alt="#">
      </div>
      <div class="nftmax-history__text">
        <h4 class="nftmax-history__number">
          <span class="number">{{ $featuredCount }}</span>
        </h4>
        <p class="nftmax-history__text">Total Featured</p>
        <p class="nftmax-history__amount">
          {{ $featuredChangeCount >= 0 ? '+' : '' }}{{ $featuredChangeCount }}
          ({{ $featuredChangePercent }}%)
        </p>
      </div>
    </div>
    <div class="nftmax-history__canvas">
      <div class="charts-main__one">
        <canvas id="myChart_history_one"></canvas>
      </div>
    </div>
  </div>
</div>
											</div>
											<div class="col-lg-3 col-md-6 col-12">
										<div class="nftmax-history mg-top-40">
  <div class="nftmax-history__main">
    <div class="nftmax-history__content">
      <div class="nftmax-history__icon nftmax-history__icon-four">
        <img src="{{ asset('img/history-icon-4.png') }}" alt="#">
      </div>
      <div class="nftmax-history__text">
        <h4 class="nftmax-history__number">
          <span class="number">{{ $walletTotal }}</span>
        </h4>
        <p class="nftmax-history__text">Total Balance</p>
        <p class="nftmax-history__amount nftmax-history__amount-debit">
          {{ $walletChangeCount >= 0 ? '+' : '' }}{{ $walletChangeCount }}
          ({{ $walletChangePercent }}%)
        </p>
      </div>
    </div>
    <div class="nftmax-history__canvas">
      <div class="charts-main__one">
        <canvas id="myChart_history_four"></canvas>
      </div>
    </div>
  </div>
</div>


										</div>
										</div>
							<div class="row nftmax-gap-sq30 mt-3">
							    
							    <h2 class="fs">Top 3 Highest Bids</h2>
							    
  @foreach($topAuctions as $auction)
    @php
        $raw = $auction->image;       // could be JSON or plain string
        $firstImage = null;

        if ($raw) {
            if (str_starts_with($raw, '[')) {
                // JSON array: decode and grab first element
                $arr = json_decode($raw, true) ?: [];
                $firstImage = $arr[0] ?? null;
            } else {
                // plain string path
                $firstImage = $raw;
            }
        }

        // Build URL: strip leading "/" then asset()
        $imgUrl = $firstImage
            ? asset(ltrim($firstImage, '/'))
            : asset('img/default.png');
    @endphp

    <div class="col-lg-4 col-md-6 col-12">
      <!-- Marketplace Single Item -->
      <div class="trending-action__single trending-action__single--v2">
        <div class="nftmax-trendmeta">
          <div class="nftmax-trendmeta__main">
            <div class="nftmax-trendmeta__author">
               {{-- USER PROFILE IMAGE --}}
            @php
              $userPic = optional($auction->user)->profile_pic
                  ? asset(''.ltrim($auction->user->profile_pic, '/'))
                  : asset('img/default-profile.png');
            @endphp
            <div class="nftmax-trendmeta__img">
              <img src="{{ $userPic }}" alt="{{ optional($auction->user)->name }}">
            </div>
              <div class="nftmax-trendmeta__content">
                <span class="nftmax-trendmeta__small">Created by</span>
                <h4 class="nftmax-trendmeta__title">
                  {{ optional($auction->user)->name ?? '—' }}
                </h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Trending Head -->
        <div class="trending-action__head">
          <div class="trending-action__badge">
           
          </div>
          <img src="{{ $imgUrl }}" alt="{{ $auction->title }}">
        </div>

        <!-- Trending Body -->
        <div class="trending-action__body trending-marketplace__body">
          <h2 class="trending-action__title">
         <a 
  href="https://www.xpertbid.com/product/{{ $auction->id }}" 
  target="_blank" 
  rel="noopener noreferrer"
>
  {{ $auction->title }}
</a>
          </h2>
          <div class="dashboard-banner__bid dashboard-banner__bid-v2">
            <!-- Current Bid -->
            <div class="dashboard-banner__group dashboard-banner__group-v2">
              <p class="dashboard-banner__group-small">Current Bid</p>
              <h3 class="dashboard-banner__group-title">
                {{ number_format($auction->bids_max_bid_amount, 2) }} ETH
              </h3>
            </div>
            <div class="dashboard-banner__middle-border"></div>
            <!-- Remaining Time -->
            <div class="dashboard-banner__group dashboard-banner__group-v2">
              <p class="dashboard-banner__group-small">Remaining Time</p>
              <h3 
                class="dashboard-banner__group-title" 
                data-countdown="{{ \Carbon\Carbon::parse($auction->end_date)->format('Y/m/d') }}">
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!-- End Marketplace Item -->
    </div>
  @endforeach
</div>

														

											<div class="row">
											<div class="col-12">
												<!-- Charts One -->
												<div class="charts-main  mg-top-40">
													<div class="charts-main__heading">
														<h4 class="charts-main__title">Auction By Status</h4>
														<div class="charts-main__middle">
															<div class="charts-main__middle-single">
																<p class="charts-main__middle-text">Won</p>
															</div>
															<div class="charts-main__middle-single">
																<p class="charts-main__middle-text nftmax-total__sales">Active</p>
															</div>
															<div class="charts-main__middle-single">
																<p class="charts-main__middle-text nftmax-last__sales">Closed</p>
															</div>
														</div>
														
														<div class="nftmax-chart__dropdown">
															<ul  class="nav nav-tabs nftmax-dropdown__list" id="nav-tab">
																<li class="nav-item dropdown">
																	<a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">Last 30 days </a>
																
																</li>
															</ul>
														</div>
													</div>
													<div class="charts-main__three">
														<div class="tab-content" id="nav-tabContent">
															<div class="tab-pane fade show active" id="s_history" role="tabpanel" aria-labelledby="nav-home-tab">
																<canvas id="myChart_three"></canvas>
															</div>
															<div class="tab-pane fade" id="s_history" role="tabpanel" aria-labelledby="nav-home-tab">
																<canvas id="myChart_three"></canvas>
															</div>
														</div>
													</div>
												</div>
												<!-- End Charts One -->
											</div>
										</div>
										<script src="js/jquery.min.js"></script>
		<script src="js/jquery-migrate.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slickslider.min.js"></script>
		<script src="js/charts.js"></script>
		<script src="js/countdown.min.js"></script>
		<script src="js/final-countdown.min.js"></script>
		<script src="js/circle-progress.min.js"></script>
		<script src="js/main.js"></script>
										
										<script>
		
		// Grab the canvas and inject PHP arrays
const ctxOne = document.getElementById('myChart_history_one').getContext('2d');
const featLabels = @json($labels);
const featData   = @json($featuredData);

new Chart(ctxOne, {
  type: 'line',
  data: {
    labels: featLabels,
    datasets: [{
      label: 'Featured Items',
      data: featData,
      borderColor: '#5356FB',
      tension: 0.5,
      borderWidth: 4,
      pointRadius: 5,
      pointBackgroundColor: '#5356FB',
      pointBorderColor: '#d5dff54f',
    }]
  },
  options: {
    responsive: true,
    scales: {
      x: {
        grid: { display: false, drawBorder: false },
        ticks: { display: false }
      },
      y: {
        grid: { display: false, drawBorder: false },
        ticks: { display: false }
      },
    },
    plugins: {
      legend: { display: false },
      title:  { display: false }
    }
  }
});
		const ctxTwo = document
  .getElementById('myChart_history_two')
  .getContext('2d');

const prodLabels = @json($labels);
const prodData   = @json($productData);

new Chart(ctxTwo, {
  type: 'line',
  data: {
    labels: prodLabels,
    datasets: [{
      label: 'Products',
      data: prodData,
      borderColor: '#F539F8',
      tension: 0.5,
      borderWidth: 4,
      pointRadius: 5,
      pointBackgroundColor: '#F539F8',
      pointBorderColor: '#d5dff54f',
    }]
  },
  options: {
    responsive: true,
    scales: {
      x: { grid: { display: false, drawBorder: false }, ticks: { display: false } },
      y: { grid: { display: false, drawBorder: false }, ticks: { display: false } },
    },
    plugins: {
      legend: { display: false },
      title:  { display: false }
    }
  }
});
			const chartLabels = @json($labels);
            const chartData   = @json($data);
			const ctx_history_three = document.getElementById('myChart_history_three').getContext('2d');
			const myChart_history_three = new Chart(ctx_history_three, {
				type: 'line',
				data: {
					labels: chartLabels,
					datasets: [{
						label: 'User',
						data: chartData,
						borderColor:'#27AE60',
						tension: 0.5,
						borderWidth:4,
						pointRadius: 5,
						pointBackgroundColor: '#27AE60',
						pointBorderColor: '#d5dff54f',
					}]
				},
				
				 options: {
					responsive: true,
					scales: {
						x:{
							grid:{
								display:false,
								drawBorder: false,
							},
							ticks:{
								display:false
							}
						},
						y:{
							grid:{
								display:false,
								drawBorder: false,
							},
							ticks:{
								display:false
							}
						},
					},
					
					plugins: {
					  legend: {
						position: 'top',
						display: false,
					  },
					  title: {
						display: false,
						text: 'Visitor: 2k'
					  }
					}
				}
			});
			
		// Grab the canvas
const ctxFour = document
  .getElementById('myChart_history_four')
  .getContext('2d');

// Inject labels and wallet‑data arrays from PHP
const walletLabels = @json($labels);      // same month labels ['Jan', …]
const walletData   = @json($walletData);  // your 12‑month wallet sums

new Chart(ctxFour, {
  type: 'line',
  data: {
    labels: walletLabels,
    datasets: [{
      label: 'Wallet Balance',
      data: walletData,
      borderColor: '#EB5757',
      tension: 0.5,
      borderWidth: 4,
      pointRadius: 5,
      pointBackgroundColor: '#EB5757',
      pointBorderColor: '#d5dff54f',
    }]
  },
  options: {
    responsive: true,
    scales: {
      x: {
        grid: { display: false, drawBorder: false },
        ticks: { display: false }
      },
      y: {
        grid: { display: false, drawBorder: false },
        ticks: { display: false }
      },
    },
    plugins: {
      legend: { display: false },
      title:  { display: false }
    }
  }
});
  const ctx = document
    .getElementById('myChart_three')
    .getContext('2d');

const labels         = @json($auctionLabels);
const activeData     = @json($activeSeries);
const wonData        = @json($wonSeries);
const inactiveData   = @json($inactiveSeries);

new Chart(ctx, {
  type: 'line',
  data: {
    labels,
    datasets: [
      {
        label: 'Active',
        data: activeData,
        borderColor: '#F539F8',
        backgroundColor: 'transparent',
        borderWidth: 4,
        tension: 0.5,
        pointRadius: 3,
        pointBackgroundColor: '#F539F8',
      },
      {
        label: 'Won',
        data: wonData,
        borderColor: '#5356FB',
        backgroundColor: 'transparent',
        borderWidth: 4,
        tension: 0.5,
        pointRadius: 3,
        pointBackgroundColor: '#5356FB',
      },
      {
        label: 'Closed',
        data: inactiveData,
        borderColor: '#F2994A',
        backgroundColor: 'transparent',
        borderWidth: 4,
        tension: 0.5,
        pointRadius: 3,
        pointBackgroundColor: '#F2994A',
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      x: { grid: { display: false, drawBorder: false }, ticks: { display: true } },
      y: { grid: { drawBorder: false }, ticks: { display: true } }
    },
    plugins: {
      legend: { display: false },       // ← hide the dataset labels
      title:  { display: false }        // ← no chart title, as before
    }
  }
});


			
			
			</script>
@endsection