<table class="table nftmax-table" id="rolesTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Role Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $key => $role)
            <tr>
                <td><strong>{{ ($roles->currentPage() - 1) * $roles->perPage() + $key + 1 }}</strong></td>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ $role->name }}</div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('roles.edit', $role->id) }}" class="action-icon edit" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                <td colspan="3" class="text-center text-muted p-5">No roles found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $roles->firstItem() ?? 0 }}-{{ $roles->lastItem() ?? 0 }} of {{ $roles->total() ?? 0 }} roles
    </div>
    <div>
        {{ $roles->links('pagination::bootstrap-5') }}
    </div>
</div>
