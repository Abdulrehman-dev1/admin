@extends('layouts.app')

@section('content')
<style>
    /* Compact Pagination Styles */
    .pagination {
      display: flex;
      padding-left: 0;
      list-style: none;
      justify-content: center;
      gap: 4px;
    }
    .page-item .page-link {
      width: 34px;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px !important;
      border: 1px solid #eee;
      color: #5356FB;
      font-weight: 600;
      font-size: 13px;
      transition: all 0.3s;
      background: #fff;
    }
    .page-item.active .page-link {
      background: #5356FB !important;
      color: #fff !important;
      border-color: #5356FB !important;
    }
    .page-item.disabled .page-link {
      color: #ccc;
    }
    .page-link:hover:not(.active) {
      background: #f8f9ff;
    }
    /* Hide internal pagination text to avoid duplication */
    nav .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:first-child,
    nav .d-flex.justify-content-between.flex-fill.d-sm-none {
        display: none !important;
    }
    /* Ensure the pagination nav itself doesn't add extra space */
    nav[role="navigation"] {
        width: auto !important;
    }

    /* Modern & Compact Filter Card */
    .nftmax-filter-card {
      background: #ffffff;
      border: 1px solid #f0f0f0;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.02);
      margin-bottom: 20px;
    }
    .filter-group-label {
      font-size: 11px;
      font-weight: 700;
      color: #878F9A;
      margin-bottom: 6px;
      display: block;
      text-transform: uppercase;
      letter-spacing: 0.8px;
    }
    .nftmax-filter-input {
      height: 40px;
      border-radius: 8px;
      border: 1px solid #E3E4E8;
      padding: 8px 12px;
      font-size: 13px;
      color: #374557;
      transition: all 0.2s;
      background-color: #FAFAFB;
      width: 100%;
    }
    .nftmax-filter-input:focus {
      border-color: #5356FB;
      background-color: #fff;
      box-shadow: 0 0 0 3px rgba(83, 86, 251, 0.05);
      outline: none;
    }
    select.nftmax-filter-input {
       appearance: none;
       background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%235356FB' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
       background-repeat: no-repeat;
       background-position: right 12px center;
    }
    
    .btn-filter-submit {
      height: 40px;
      background: #5356FB;
      border: none;
      color: white;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 12px;
      padding: 0 24px;
    }
    .btn-filter-submit:hover {
      background: #4245e0;
      box-shadow: 0 4px 8px rgba(83, 86, 251, 0.2);
    }
    .btn-filter-reset {
      height: 40px;
      background: #F3F4F6;
      border: none;
      color: #374557;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 12px;
      text-decoration: none;
      padding: 0 20px;
    }
    .btn-filter-reset:hover {
      background: #E5E7EB;
    }

    /* Advanced Table Styles */
    .nftmax-table {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        background: transparent !important;
        border: none !important;
    }
    .nftmax-table thead th {
        background: transparent !important;
        border: none !important;
        color: #878F9A;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        padding: 12px 20px !important;
    }
    .nftmax-table tbody tr {
        background: #fff !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .nftmax-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        background: #fcfcfd !important;
    }
    .nftmax-table td {
        border: none !important;
        padding: 15px 20px !important;
        vertical-align: middle !important;
        color: #1A1D2F;
        font-weight: 600;
        font-size: 14px;
    }
    .nftmax-table td:first-child {
        border-radius: 10px 0 0 10px !important;
    }
    .nftmax-table td:last-child {
        border-radius: 0 10px 10px 0 !important;
    }
    .auction-img-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }
    .auction-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Premium Action Icons */
    .action-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        margin-right: 5px;
        color: #5356FB;
        background: #F4F7FF;
        border: none;
    }
    .action-icon:hover {
        background: #5356FB;
        color: #fff;
    }
    .action-icon.edit { color: #FFB800; background: rgba(255, 184, 0, 0.1); }
    .action-icon.edit:hover { background: #FFB800; color: #fff; }

    /* Glassmorphism Badges */
    .custom-badge {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }
    .custom-badge.inactive { background: rgba(107, 114, 128, 0.1); color: #6b7280; }
    .custom-badge.resubmit { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .custom-badge.decline { background: rgba(220, 38, 38, 0.1); color: #dc2626; }
    .custom-badge.active { background: rgba(34, 197, 94, 0.1); color: #22c55e; }

    /* Flatpickr Premium */
    .flatpickr-calendar {
        background: #fff !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        border: 1px solid #E3E4E8 !important;
    }
    .flatpickr-calendar.rangeMode {
        width: 560px !important;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
        background: #5356FB !important;
        border-color: #5356FB !important;
        color: #fff !important;
    }
    .flatpickr-day.inRange {
        background: rgba(83, 86, 251, 0.08) !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h1 class="h4 mb-0" style="font-weight: 800; color: #1A1D2F;">Lot Verification</h1>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <a
            href="{{ route('auctionstatus.index', ['tab' => 'regular']) }}"
            class="btn {{ ($verificationTab ?? 'regular') === 'regular' ? 'btn-primary' : 'btn-outline-primary' }}"
            style="border-radius: 10px; font-weight: 600;"
        >
            Lot Verification
        </a>
        <a
            href="{{ route('auctionstatus.index', ['tab' => 'private']) }}"
            class="btn {{ ($verificationTab ?? 'regular') === 'private' ? 'btn-primary' : 'btn-outline-primary' }}"
            style="border-radius: 10px; font-weight: 600;"
        >
            Private Auction Verification
        </a>
    </div>

    <!-- Compact Filter Form -->
    <div class="card nftmax-filter-card">
        <div class="card-body p-3">
            <form id="filterForm" action="{{ route('auctionstatus.index') }}" method="GET">
                <input type="hidden" name="tab" value="{{ $verificationTab ?? 'regular' }}">
                <div class="row g-2 mb-3">
                    <div class="col-lg col-md-4">
                        <label class="filter-group-label">Search</label>
                        <input type="text" name="q" class="form-control nftmax-filter-input" placeholder="ID, Title, User..." value="{{ request('q') }}" autocomplete="off">
                    </div>
                    <div class="col-lg col-md-4">
                        <label class="filter-group-label">Sort By</label>
                        <select name="sort" class="form-select nftmax-filter-input">
                            <option value="newest_to_oldest" {{ request('sort') == 'newest_to_oldest' ? 'selected' : '' }}>Newest</option>
                            <option value="oldest_to_newest" {{ request('sort') == 'oldest_to_newest' ? 'selected' : '' }}>Oldest</option>
                            <option value="a_to_z" {{ request('sort') == 'a_to_z' ? 'selected' : '' }}>A-Z</option>
                            <option value="z_to_a" {{ request('sort') == 'z_to_a' ? 'selected' : '' }}>Z-A</option>
                        </select>
                    </div>
                    <div class="col-lg col-md-4">
                        <label class="filter-group-label">Category</label>
                        <select name="category_id" class="form-select nftmax-filter-input">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg col-md-6">
                        <label class="filter-group-label">Date Range</label>
                        <input type="text" id="date_range" name="date_range" class="form-control nftmax-filter-input" placeholder="Select Dates" value="{{ request('date_range') }}">
                    </div>
                    <div class="col-lg col-md-6">
                        <label class="filter-group-label">Status</label>
                        <select name="status" class="form-select nftmax-filter-input">
                            <option value="">All Statuses</option>
                            @foreach($allowedStatuses as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-filter-submit">Apply Filters</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('auctionstatus.index', ['tab' => $verificationTab ?? 'regular']) }}" class="btn btn-filter-reset">Reset Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div id="lot-table-container">
        <div class="table-responsive">
            @include('auctionstatus.table_partial')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        const container = $('#lot-table-container');

        // Manual Search/Filter on Form Submit
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchLots();
        });

        function fetchLots() {
            const formData = $('#filterForm').serialize();
            const url = "{{ route('auctionstatus.index') }}?" + formData;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    container.html(response);
                }
            });
        }

        // Handle pagination clicks via AJAX
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    container.html(response);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });

        // Initialize Flatpickr
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            onReady: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.classList.add('two-calendars');
            },
            showMonths: 2
        });
    });
</script>
@endsection
