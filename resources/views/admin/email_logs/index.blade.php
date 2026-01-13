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

        .custom-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            white-space: nowrap;
        }
        
        /* Flatpickr Premium */
        .flatpickr-calendar {
            background: #fff !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #E3E4E8 !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h1 class="h4 mb-0" style="font-weight: 800; color: #1A1D2F;">Email Logs</h1>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card nftmax-filter-card">
            <div class="card-body p-3">
                <form action="{{ route('email-logs.index') }}" method="GET">
                    <div class="row g-2 mb-3">
                        <div class="col-lg-5 col-md-6">
                            <label class="filter-group-label">Search</label>
                            <input type="text" name="search" class="form-control nftmax-filter-input"
                                placeholder="Recipient, Subject..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="filter-group-label">Date Range</label>
                            <input type="text" id="date_range" name="date_range" class="form-control nftmax-filter-input"
                                placeholder="Select Dates" value="{{ request('date_range') }}">
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-filter-submit">Apply Filters</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('email-logs.index') }}" class="btn btn-filter-reset">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table nftmax-table">
                <thead>
                    <tr>
                        <th>Sent At</th>
                        <th>Recipient Details</th>
                        <th>Subject</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td style="white-space: nowrap;">
                                <div style="font-size: 12px; color: #374557; font-weight: 700;">
                                    {{ $log->sent_at ? \Carbon\Carbon::parse($log->sent_at)->format('Y-m-d') : '' }}
                                </div>
                                <small style="color: #878F9A; font-size: 11px;">
                                    {{ $log->sent_at ? \Carbon\Carbon::parse($log->sent_at)->format('H:i:s') : '' }}
                                </small>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #374557;">{{ $log->recipient_email }}</div>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #374557;">{{ Str::limit($log->subject, 50) }}</div>
                            </td>
                            <td>
                                @if($log->user)
                                    <div style="font-weight: 700; color: #5356FB;">{{ $log->user->name }}</div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <code style="background: rgba(83, 86, 251, 0.05); color: #5356FB; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px;">
                                    {{ $log->type ?? 'N/A' }}
                                </code>
                            </td>
                            <td>
                                @if($log->status === 'sent')
                                    <span class="custom-badge approved" style="color:#10B981; background:rgba(16, 185, 129, 0.1);">Sent</span>
                                @else
                                    <span class="custom-badge pending">{{ ucfirst($log->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-5">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
            <div class="small text-muted">
                Showing {{ $logs->firstItem() ?? 0 }}-{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() ?? 0 }} results
            </div>
            <div>
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
        });
    </script>
@endsection
