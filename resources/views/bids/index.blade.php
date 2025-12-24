@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Bids</h1>
    
    <div class="table-responsive">
        <table class="table table-bordered nftmax-table table-striped table-hover shadow" id="bidsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Auction</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Bid Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bids as $bid)
                <tr>
                    <td>{{ $bid->id }}</td>
                    <td>{{ $bid->auction->title ?? 'N/A' }}</td>
                    <td>{{ $bid->user->name ?? 'N/A' }}</td>
                    <td>
                        @if(!empty($bid->user->phone))
                            {{ $bid->user->phone }}
                        @elseif(!empty($bid->user->IndividualVerification->contact_number))
                            {{ $bid->user->IndividualVerification->contact_number }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="text-dark font-weight-bold" style="color: #000 !important;">PKR {{ number_format($bid->bid_amount, 2) }}</td>
                    <td>{{ $bid->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <a href="{{ route('bids.show', $bid->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bidsTable').DataTable({
            order: [[0, 'desc']]
        });
    });
</script>
@endsection
