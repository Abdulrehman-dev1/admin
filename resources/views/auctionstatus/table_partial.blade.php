<table class="table nftmax-table" id="auctionStatusTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>User</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($auctions as $auction)
            @php
            $album = json_decode($auction->album,true);
            $img = ($album && count($album) > 0) ? $album[0] : 'assets/images/placeholder.png';
            @endphp
            <tr>
                <td style="color: #878F9A;">#{{ $auction->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="auction-img-wrapper me-3">
                            <img src="{{asset($img)}}" alt="Auction Image">
                        </div>
                        <div style="max-width: 200px;">
                            <div class="text-truncate" title="{{ $auction->title }}">{{ $auction->title }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ ($auction->user->name) ?? '-' }}</td>
                <td>
                    <span style="font-size: 12px; background: #F8F9FA; padding: 4px 10px; border-radius: 20px; color: #5356FB;">
                        {{ ($auction->category->name) ?? '-' }}
                    </span>
                </td>
                <td>
                    <span class="custom-badge {{ strtolower($auction->status) }}">
                        {{ ucfirst($auction->status) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('auctionstatus.edit', $auction->id) }}" class="action-icon edit" title="Verify / Edit"><i class="fas fa-edit"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No lots found for verification.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $auctions->firstItem() ?? 0 }}-{{ $auctions->lastItem() ?? 0 }} of {{ $auctions->total() ?? 0 }} results
    </div>
    <div>
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>
</div>
