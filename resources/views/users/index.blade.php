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

        nav .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between>div:first-child,
        nav .d-flex.justify-content-between.flex-fill.d-sm-none {
            display: none !important;
        }

        nav[role="navigation"] {
            width: auto !important;
        }

        /* Modern & Compact Filter Card */
        .nftmax-filter-card {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
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

        /* Advanced Table Styles */
        .nftmax-table {
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
            background: transparent !important;
            border: none !important;
            width: 100% !important;
        }

        .nftmax-table thead th {
            background: transparent !important;
            border: none !important;
            color: #878F9A;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 12px 20px !important;
        }

        .nftmax-table tbody tr {
            background: #fff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .nftmax-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background: #fcfcfd !important;
        }

        .nftmax-table td {
            border: none !important;
            padding: 15px 20px !important;
            vertical-align: middle !important;
        }

        .nftmax-table td:first-child {
            border-radius: 10px 0 0 10px !important;
        }

        .nftmax-table td:last-child {
            border-radius: 0 10px 10px 0 !important;
        }

        /* Action Icons */
        .action-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            color: #5356FB;
            background: rgba(83, 86, 251, 0.1);
            border: none;
        }

        .action-icon:hover {
            background: #5356FB;
            color: #fff;
        }

        .action-icon.edit {
            color: #FFB800;
            background: rgba(255, 184, 0, 0.1);
        }

        .action-icon.edit:hover {
            background: #FFB800;
            color: #fff;
        }

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

        .custom-badge.approved {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .custom-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        /* Flatpickr Premium */
        .flatpickr-calendar {
            background: #fff !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #E3E4E8 !important;
            z-index: 9999 !important; /* Fix for modal overlap */
        }

        /* Add Button Premium */
        .btn-add-premium {
            height: 40px;
            background: linear-gradient(135deg, #5356FB 0%, #6366F1 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            padding: 0 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(83, 86, 251, 0.2);
            text-decoration: none;
            font-size: 13px;
        }

        .btn-add-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(83, 86, 251, 0.3);
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h1 class="h4 mb-0" style="font-weight: 800; color: #1A1D2F;">{{ $pageTitle ?? 'User Management' }}</h1>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="button" class="btn-add-premium" data-bs-toggle="modal" data-bs-target="#exportModal"
                    style="background: #10B981; border: none;">
                    <i class="fas fa-file-csv me-2"></i> Export CSV
                </button>
                <a href="{{ route('users.create') }}" class="btn-add-premium">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            </div>
        </div>

        <!-- Compact Filter Form -->
        <div class="card nftmax-filter-card">
            <div class="card-body p-3">
                <form id="filterForm" action="{{ $filterRoute ?? route('users.index') }}" method="GET">
                    <div class="row g-2 mb-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="filter-group-label">Search Users</label>
                            <input type="text" name="search" class="form-control nftmax-filter-input"
                                placeholder="ID, Name, Email, Phone..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="filter-group-label">Sort By</label>
                            <select name="sort" class="form-select nftmax-filter-input">
                                <option value="newest_to_oldest" {{ request('sort') == 'newest_to_oldest' ? 'selected' : '' }}>Newest Joined</option>
                                <option value="oldest_to_newest" {{ request('sort') == 'oldest_to_newest' ? 'selected' : '' }}>Oldest Joined</option>
                                <option value="a_to_z" {{ request('sort') == 'a_to_z' ? 'selected' : '' }}>Name: A to Z
                                </option>
                                <option value="z_to_a" {{ request('sort') == 'z_to_a' ? 'selected' : '' }}>Name: Z to A
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <label class="filter-group-label">Joined Date Range</label>
                            <input type="text" id="date_range" name="date_range" class="form-control nftmax-filter-input"
                                placeholder="Select Dates" value="{{ request('date_range') }}">
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-filter-submit">Apply Filters</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ $filterRoute ?? route('users.index') }}" class="btn btn-filter-reset">Reset
                                Filters</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="border-radius: 10px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="users-table-container">
            <div class="table-responsive">
                @include('users.table_partial')
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f0f0f0;">
                    <h5 class="modal-title" id="exportModalLabel" style="font-weight: 700; color: #1a1d2f;">Export Users CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.export') }}" method="GET">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="export_date_range" class="form-label"
                                style="font-weight: 600; color: #374557;">Select Date Range</label>
                            <input type="text" id="export_date_range" name="export_date_range" class="form-control"
                                placeholder="Select dates..."
                                style="border-radius: 8px; height: 45px; border: 1px solid #E3E4E8;">
                            <small class="text-muted">Leave empty to export all records.</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #f0f0f0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success"
                            style="border-radius: 8px; font-weight: 600; background: #10B981; border: none;">Download
                            CSV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function () {
            const container = $('#users-table-container');

            // Manual Filter on Form Submit
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                fetchUsers();
            });

            function fetchUsers() {
                const formData = $('#filterForm').serialize();
                const url = "{{ $filterRoute ?? route('users.index') }}?" + formData;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        container.html(response);
                    }
                });
            }

            // Handle pagination clicks via AJAX
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
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
                onReady: function (selectedDates, dateStr, instance) {
                    instance.calendarContainer.classList.add('two-calendars');
                },
                showMonths: 2
            });

            // Initialize Flatpickr for Export Modal
            flatpickr("#export_date_range", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
                showMonths: 2
            });
        });
</script>

<style>
    /* Force Flatpickr to be on top of Bootstrap Modal (z-index 1055) */
    .flatpickr-calendar {
        z-index: 100000 !important;
    }
</style>
@endsection