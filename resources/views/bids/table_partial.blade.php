<table class="table nftmax-table" id="bidsTable">
    <thead>
        <tr>
            <th>Auction</th>
            <th>User</th>
            <th>Phone</th>
            <th>Bid Amount</th>
            <th style="min-width: 140px;">Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bids as $bid)
            <tr>
                <td>
                    <div style="max-width: 250px;">
                        <div class="text-truncate" title="{{ $bid->auction->title ?? 'N/A' }}" style="font-weight: 700; color: #1A1D2F;">
                            {{ $bid->auction->title ?? 'N/A' }}
                        </div>
                        <small style="color: #878F9A; font-size: 11px;">Auction ID: #{{ $bid->auction_id }}</small>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 600; color: #1A1D2F;">{{ $bid->user->name ?? 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $bid->user->email ?? '' }}</small>
                </td>
                <td>
                    <span style="font-size: 13px; color: #374557;">
                        @if(!empty($bid->user->phone))
                            {{ $bid->user->phone }}
                        @elseif(!empty($bid->user->IndividualVerification->contact_number))
                            {{ $bid->user->IndividualVerification->contact_number }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </span>
                </td>
                <td>
                    <div style="font-weight: 800; color: #5356FB; font-size: 15px;">
                        PKR {{ number_format($bid->bid_amount, 2) }}
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $bid->created_at->format('d M Y') }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $bid->created_at->format('h:i A') }}</small>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('bids.show', $bid->id) }}" class="action-icon view" title="View Details"><i class="fas fa-eye"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No bids found based on your filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $bids->firstItem() ?? 0 }}-{{ $bids->lastItem() ?? 0 }} of {{ $bids->total() ?? 0 }} results
    </div>
    <div>
        {{ $bids->links('pagination::bootstrap-5') }}
    </div>
</div>
