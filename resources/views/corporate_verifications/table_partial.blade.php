<table class="table nftmax-table" id="corporateVerificationsTable">
    <thead>
        <tr>
            <th>User</th>
            <th>Entity Name</th>
            <th>Country</th>
            <th>Status</th>
            <th style="min-width: 140px;">Submitted At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($verifications as $cv)
            <tr>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ optional($cv->user)->name ?? 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ optional($cv->user)->email ?? 'N/A' }}</small>
                </td>
                <td>
                    <div style="font-weight: 600; color: #1A1D2F;">{{ $cv->legal_entity_name }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $cv->entity_type }}</small>
                </td>
                <td>
                    <span style="font-size: 13px; color: #374557; background: #F8F9FA; padding: 4px 10px; border-radius: 20px;">
                        {{ $cv->country }}
                    </span>
                </td>
                <td>
                    <span class="custom-badge {{ strtolower($cv->status) }}">
                        {{ ucfirst(str_replace('_', ' ', $cv->status)) }}
                    </span>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $cv->created_at ? $cv->created_at->format('d M Y') : 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $cv->created_at ? $cv->created_at->format('h:i A') : '' }}</small>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('corporate-verifications.edit', $cv->id) }}" class="action-icon edit" title="Verify / Edit"><i class="fas fa-edit"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No corporate verifications found based on your filters.</td>
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
