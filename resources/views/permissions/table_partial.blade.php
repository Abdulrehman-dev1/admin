<table class="table nftmax-table" id="permissionsTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Permission Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($permissions as $key => $permission)
            <tr>
                <td><strong>{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $key + 1 }}</strong></td>
                <td>
                    <div style="font-weight: 700; color: #1A1D2F;">{{ $permission->name }}</div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="action-icon edit" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                <td colspan="3" class="text-center text-muted p-5">No permissions found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3 mb-4 p-3" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0;">
    <div class="small text-muted">
        Showing {{ $permissions->firstItem() ?? 0 }}-{{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() ?? 0 }} permissions
    </div>
    <div>
        {{ $permissions->links('pagination::bootstrap-5') }}
    </div>
</div>
