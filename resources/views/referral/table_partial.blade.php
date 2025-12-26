<table class="table nftmax-table" id="referralsTable">
    <thead>
        <tr>
            <th>User</th>
            <th>Referral Code</th>
            <th>Referred By</th>
            <th>Referred Count</th>
            <th style="min-width: 140px;">Join Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ $user->name ?? 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $user->email ?? 'N/A' }}</small>
                </td>
                <td>
                    <code style="background: rgba(83, 86, 251, 0.05); color: #5356FB; padding: 4px 8px; border-radius: 6px; font-weight: 700;">
                        {{ $user->referral_code ?? 'N/A' }}
                    </code>
                </td>
                <td>
                    @if($user->referrer)
                        <div style="font-weight: 600; color: #374557; font-size: 13px;">{{ $user->referrer->name ?? 'N/A' }}</div>
                        <small style="color: #878F9A; font-size: 11px;">#{{ $user->referrer->id }}</small>
                    @else
                        <span class="text-muted small">None</span>
                    @endif
                </td>
                <td>
                    <div style="font-weight: 800; color: #1A1D2F; font-size: 15px;">
                        {{ $user->referrals_count ?? 0 }}
                    </div>
                    <small style="color: #878F9A; font-size: 11px;">Total Referrals</small>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $user->created_at->format('d M Y') }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $user->created_at->format('h:i A') }}</small>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('referrals.show', $user->id) }}" class="action-icon view" title="View Details"><i class="fas fa-eye"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No referrals found based on your filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} results
    </div>
    <div>
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
