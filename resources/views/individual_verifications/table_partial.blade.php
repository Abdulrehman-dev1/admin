<table class="table nftmax-table" id="individualVerificationsTable">
    <thead>
        <tr>
            <th>User</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Status</th>
            <th style="min-width: 140px;">Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($verifications as $item)
            <tr>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ optional($item->user)->name ?? 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ optional($item->user)->email ?? 'N/A' }}</small>
                </td>
                <td>
                    <div style="font-weight: 600; color: #1A1D2F;">{{ $item->full_legal_name }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $item->document_type }}</small>
                </td>
                <td>
                    <div style="font-size: 13px; color: #374557;">{{ $item->contact_number }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $item->email_address }}</small>
                </td>
                <td>
                    <span class="custom-badge {{ strtolower($item->status) }}">
                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                    </span>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $item->created_at ? $item->created_at->format('d M Y') : 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $item->created_at ? $item->created_at->format('h:i A') : '' }}</small>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('individual-verifications.edit', $item->id) }}" class="action-icon edit" title="Verify / Edit"><i class="fas fa-edit"></i></a>
                        <!-- Delete form if needed, keeping Edit as primary action -->
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No individual verifications found based on your filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $verifications->firstItem() ?? 0 }}-{{ $verifications->lastItem() ?? 0 }} of {{ $verifications->total() ?? 0 }} results
    </div>
    <div>
        {{ $verifications->links('pagination::bootstrap-5') }}
    </div>
</div>
