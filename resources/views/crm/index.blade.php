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

        /* Form Controls inside Table */
        .table-input {
            border: 1px solid #E3E4E8;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 13px;
            color: #374557;
            width: 100%;
            background: #fff;
        }
        
        .table-input:focus {
            border-color: #5356FB;
            outline: none;
            box-shadow: 0 0 0 3px rgba(83, 86, 251, 0.1);
        }

        select.table-input {
            cursor: pointer;
        }

        /* Save Button */
        .btn-save-row {
            background: #10B981;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-save-row:hover {
            background: #059669;
            transform: translateY(-1px);
        }
    </style>

    <div class="container">
        <div class="row align-items-center mb-3">
             <div class="col">
                <h1 class="h4 mb-0" style="font-weight: 800; color: #1A1D2F;">CRM - Customer Outreach</h1>
            </div>
        </div>

        
        <!-- Filter Form -->
        <div class="card nftmax-filter-card">
            <div class="card-body p-3">
                <form action="{{ route('crm.index') }}" method="GET">
                    <div class="row g-2 mb-3">
                        <!-- Search -->
                        <div class="col-lg-4 col-md-6">
                            <label class="filter-group-label" style="font-size: 11px; font-weight: 700; color: #878F9A; display:block; margin-bottom: 6px; text-transform: uppercase;">Search Users</label>
                            <input type="text" name="search" class="form-control nftmax-filter-input" style="height: 40px; background-color: #FAFAFB; border: 1px solid #E3E4E8; border-radius: 8px; padding: 8px 12px; font-size: 13px;"
                                placeholder="Name, Email, Phone..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                        
                        <!-- Verification Status Filter -->
                        <div class="col-lg-4 col-md-6">
                            <label class="filter-group-label" style="font-size: 11px; font-weight: 700; color: #878F9A; display:block; margin-bottom: 6px; text-transform: uppercase;">Verification Status</label>
                            <select name="verification_status" class="form-select nftmax-filter-input" style="height: 40px; background-color: #FAFAFB; border: 1px solid #E3E4E8; border-radius: 8px; padding: 8px 12px; font-size: 13px;">
                                <option value="">All Statuses</option>
                                <option value="Verified" {{ request('verification_status') == 'Verified' ? 'selected' : '' }}>Verified</option>
                                <option value="Not Verified" {{ request('verification_status') == 'Not Verified' ? 'selected' : '' }}>Not Verified</option>
                                <option value="Declined" {{ request('verification_status') == 'Declined' ? 'selected' : '' }}>Declined</option>
                                <option value="Resubmit" {{ request('verification_status') == 'Resubmit' ? 'selected' : '' }}>Resubmit</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="col-lg-4 col-md-6">
                            <label class="filter-group-label" style="font-size: 11px; font-weight: 700; color: #878F9A; display:block; margin-bottom: 6px; text-transform: uppercase;">Sort By</label>
                            <select name="sort" class="form-select nftmax-filter-input" style="height: 40px; background-color: #FAFAFB; border: 1px solid #E3E4E8; border-radius: 8px; padding: 8px 12px; font-size: 13px;">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-filter-submit" style="height: 40px; background: #5356FB; color: white; border: none; border-radius: 8px; padding: 0 24px; font-size: 12px; font-weight: 600; text-transform: uppercase;">Apply Filters</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('crm.index') }}" class="btn btn-filter-reset" style="height: 40px; background: #F3F4F6; color: #374557; text-decoration: none; display: flex; align-items: center; justify-content: center; border-radius: 8px; padding: 0 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">Reset Filters</a>
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

        <div class="table-responsive">
            <table class="table nftmax-table">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">User Details</th>
                        <th style="min-width: 200px;">Email & Phone</th>
                        <th style="min-width: 150px;">Registered At</th>
                        <th style="min-width: 150px;">Verify Sub At</th>
                        <th style="min-width: 100px;">Status</th>
                        <th style="min-width: 160px;">Call Status</th>
                        <th style="min-width: 350px;">Feedback</th>
                        <th style="min-width: 200px;">Contract Date</th>
                        <th style="min-width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($outreaches as $row)
                        <tr>
                            <!-- User Details -->
                            <td>
                                <div style="font-weight: 700; color: #1A1D2F;">{{ $row->user ? $row->user->name : $row->name }}</div>
                                <small style="color: #878F9A; font-size: 11px;">#{{ $row->id }}</small>
                            </td>

                            <!-- Contact -->
                            <td>
                                @php
                                    $displayEmail = $row->user?->email
                                        ?: $row->user?->individualVerification?->email_address
                                        ?: $row->email;

                                    $displayPhone = $row->user?->phone
                                        ?: $row->user?->individualVerification?->contact_number
                                        ?: $row->phone;
                                @endphp
                                <div style="color: #374557; font-size: 13px;">{{ $displayEmail ?: '-' }}</div>
                                <small style="color: #878F9A; font-size: 11px;">{{ $displayPhone ?: '-' }}</small>
                            </td>

                            <!-- Registered At -->
                            <td>
                                @php
                                    $registeredAt = $row->user?->created_at ?: $row->created_at;
                                @endphp
                                <div style="color: #374557; font-size: 13px;">
                                    {{ \Carbon\Carbon::parse($registeredAt)->format('d M, Y') }}
                                </div>
                                <small style="color: #878F9A; font-size: 11px;">
                                    {{ \Carbon\Carbon::parse($registeredAt)->format('h:i A') }}
                                </small>
                            </td>

                            <td>
                                @php
                                    $verificationSubmittedAt = $row->user?->individualVerification?->created_at
                                        ?: $row->user?->corporateVerification?->created_at;
                                @endphp
                                @if($verificationSubmittedAt)
                                    <div style="color: #374557; font-size: 13px;">
                                        {{ \Carbon\Carbon::parse($verificationSubmittedAt)->format('d M, Y') }}
                                    </div>
                                    <small style="color: #878F9A; font-size: 11px;">
                                        {{ \Carbon\Carbon::parse($verificationSubmittedAt)->format('h:i A') }}
                                    </small>
                                @else
                                    <div style="color: #878F9A; font-size: 13px;">-</div>
                                @endif
                            </td>
                            
                             <!-- Verification Status -->
                            <td>
                                @php
                                    // Use 'individualVerification' (camelCase) as per relationship update
                                    $status = $row->user && $row->user->individualVerification ? $row->user->individualVerification->status : $row->verification_status;
                                    
                                    // Default to 'not_verified' if null
                                    if (empty($status)) {
                                        $status = 'not_verified';
                                    }

                                    // Normalize for badge logic
                                    $normalizedStatus = strtolower(str_replace(' ', '_', $status));
                                    
                                    $badgeClass = match($normalizedStatus) {
                                        'verified' => 'bg-success',
                                        'declined' => 'bg-danger', // Red for declined
                                        'resubmit' => 'bg-warning', // Yellow/Orange for resubmit
                                        'not_verified' => 'bg-dark', // Grey for not verified
                                        default => 'bg-secondary'
                                    };

                                    $displayStatus = ucwords(str_replace('_', ' ', $status));
                                @endphp
                                <span class="badge {{ $badgeClass }}" style="font-size: 11px;">
                                    {{ $displayStatus }}
                                </span>
                            </td>

                            <!-- Inline Form Inputs Linked via form attribute -->
                            <form id="form-row-{{ $row->id }}" action="{{ route('crm.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            </form>

                            <td>
                                <select name="call_status" form="form-row-{{ $row->id }}" class="table-input">
                                    <option value="Pending" {{ $row->call_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Call Pick" {{ $row->call_status == 'Call Pick' ? 'selected' : '' }}>Call Pick</option>
                                    <option value="Didn't Pick" {{ $row->call_status == "Didn't Pick" ? 'selected' : '' }}>Didn't Pick</option>
                                    <option value="Second Follow Up" {{ $row->call_status == 'Second Follow Up' ? 'selected' : '' }}>Second Follow Up</option>
                                    <option value="Third Follow Up" {{ $row->call_status == 'Third Follow Up' ? 'selected' : '' }}>Third Follow Up</option>
                                </select>
                            </td>

                            <td>
                                <textarea name="customer_feedback_summary" form="form-row-{{ $row->id }}" class="table-input" rows="1" placeholder="Add feedback...">{{ $row->customer_feedback_summary }}</textarea>
                            </td>

                            <td>
                                <input type="datetime-local" name="contract_date" form="form-row-{{ $row->id }}" class="table-input" value="{{ $row->contract_date ? \Carbon\Carbon::parse($row->contract_date)->format('Y-m-d\TH:i') : '' }}">
                            </td>

                            <td>
                                <button type="submit" form="form-row-{{ $row->id }}" class="btn-save-row">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
            <div class="small text-muted">
                Showing {{ $outreaches->firstItem() ?? 0 }}-{{ $outreaches->lastItem() ?? 0 }} of {{ $outreaches->total() ?? 0 }} results
            </div>
            <div>
                 {{ $outreaches->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Toast Container for Notifications -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    CRM Status Updated Successfully
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all save buttons
            const saveButtons = document.querySelectorAll('.btn-save-row');

            saveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default form submission via browser

                    const formId = this.getAttribute('form');
                    const form = document.getElementById(formId);
                    
                    if (!form) return;

                    // Add loading state
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                    this.disabled = true;

                    // Collect data from inputs linked to this form
                    const formData = new FormData(form);
                    
                    // Manually append inputs that are OUTSIDE the form tag but linked via 'form' attribute
                    // because FormData(form) only captures children of the form element unless specified otherwise
                    // NOTE: inputs with form="id" attribute are NOT automatically included in new FormData(element) unless the browser supports it fully or the inputs are children.
                    // Let's rely on manual collection for the linked inputs to be safe.
                    
                    const linkedInputs = document.querySelectorAll(`[form="${formId}"]`);
                    linkedInputs.forEach(input => {
                        // Check if it's a select, textarea, or input
                        if (input.name) {
                            formData.set(input.name, input.value);
                        }
                    });

                    fetch(form.action, {
                        method: 'POST', 
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json' // Explicitly ask for JSON
                        },
                        body: formData
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            // Handle validation errors or 500s
                            if (response.status === 422) {
                                let errorMsg = 'Validation Error:\n';
                                for (const [key, messages] of Object.entries(data.errors)) {
                                    errorMsg += `${messages.join(', ')}\n`;
                                }
                                throw new Error(errorMsg);
                            } else {
                                throw new Error(data.message || 'Server Error');
                            }
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            // Show Toast
                            const toastEl = document.getElementById('liveToast');
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        } else {
                            throw new Error(data.message || 'Unknown error occurred');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message); // Show actual error message
                    })
                    .finally(() => {
                        // Restore button state
                        this.innerHTML = originalContent;
                        this.disabled = false;
                    });
                });
            });
        });
    </script>
@endsection
