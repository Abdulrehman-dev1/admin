@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Email Logs</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Sent Emails</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('email-logs.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by email, subject, type..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="date_range" class="form-control" placeholder="Date Range (YYYY-MM-DD to YYYY-MM-DD)" value="{{ request('date_range') }}">
                                <small class="text-muted">Format: YYYY-MM-DD to YYYY-MM-DD</small>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('email-logs.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sent At</th>
                                    <th>Recipient</th>
                                    <th>Subject</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailLogs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                    <td>{{ $log->recipient_email }}</td>
                                    <td>{{ $log->subject }}</td>
                                    <td>
                                        @if($log->user)
                                            <a href="{{ route('users.show', $log->user->id) }}">{{ $log->user->name }}</a>
                                        @else
                                            <span class="text-muted">Guest / Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{ $log->type ?? 'N/A' }}</td>
                                    <td>
                                        @if($log->status === 'sent')
                                            <span class="text-success font-weight-bold">Sent</span>
                                        @else
                                            <span class="text-warning font-weight-bold">{{ ucfirst($log->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No email logs found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $emailLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
