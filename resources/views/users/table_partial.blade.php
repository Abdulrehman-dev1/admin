<table class="table nftmax-table" id="usersTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Verification</th>
            <th>UTM Campaign</th>
            <th style="min-width: 140px;">Joined Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ $user->name ?? 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">#{{ $user->id }} | {{ $user->phone ?? 'No Phone' }}</small>
                </td>
                <td>
                    <div style="color: #374557; font-size: 13px;">{{ $user->email }}</div>
                    @if($user->roles->count() > 0)
                        <span class="badge bg-light text-dark small" style="font-size: 10px; padding: 2px 6px;">{{ $user->roles->first()->name }}</span>
                    @endif
                </td>
                <td>
                    @if(($user->IndividualVerification->status ?? '') === 'verified')
                        <span class="custom-badge approved">Verified</span>
                    @else
                        <span class="custom-badge pending">Not Verified</span>
                    @endif
                </td>
                <td>
                    <code style="background: rgba(83, 86, 251, 0.05); color: #5356FB; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px;">
                        {{ $user->utm_campaign ?? '-' }}
                    </code>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #374557; font-weight: 700;">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</div>
                    <small style="color: #878F9A; font-size: 11px;">{{ $user->created_at ? $user->created_at->format('h:i A') : '' }}</small>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('users.show', $user->id) }}" class="action-icon view" title="View Details"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('users.edit', $user->id) }}" class="action-icon edit" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon delete" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-5">No users found based on your filters.</td>
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
