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

        .action-icon.delete {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .action-icon.delete:hover {
            background: #ef4444;
            color: #fff;
        }

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

    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h1 class="h4 mb-0" style="font-weight: 800; color: #1A1D2F;">SEO Management</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('seo.create') }}" class="btn-add-premium">
                    <i class="fas fa-plus"></i> Add New SEO
                </a>
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
                        <th style="min-width: 50px;">ID</th>
                        <th>Slug</th>
                        <th>Meta Title</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #878F9A;">#{{ $row->id }}</div>
                            </td>
                            <td>
                                <code style="background: rgba(83, 86, 251, 0.05); color: #5356FB; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 12px;">
                                    /{{ $row->slug }}
                                </code>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #374557; font-weight: 600;">{{ Str::limit($row->meta_title, 50) }}</div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('seo.edit', $row->id) }}" class="action-icon edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seo.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-icon delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted p-5">No SEO records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
            <div class="small text-muted">
                Showing {{ $rows->firstItem() ?? 0 }}-{{ $rows->lastItem() ?? 0 }} of {{ $rows->total() ?? 0 }} results
            </div>
            <div>
                {{ $rows->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
