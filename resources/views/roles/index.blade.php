@extends('layouts.app')

@section('title', 'Roles List')

<style>
    .btn-add-role:hover {
        background: linear-gradient(135deg, #4144D9 0%, #5356FB 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(83, 86, 251, 0.4) !important;
    }

    .btn-add-role:active {
        transform: translateY(0);
    }

    .btn-primary:hover {
        background: #4144D9 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(83, 86, 251, 0.3);
    }

    .btn-danger:hover {
        background: #DC2626 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-primary:active,
    .btn-danger:active {
        transform: translateY(0);
    }
</style>

@section('content')
    <div class="nftmax-table mg-top-40">
        <div class="nftmax__container">
            <div class="nftmax-table__heading">
                <h3 class="nftmax-table__title mb-0">Roles List</h3>
                <a href="{{ route('roles.create') }}" class="btn-add-role"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #5356FB 0%, #6366F1 100%); color: white; border: none; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s; box-shadow: 0 2px 8px rgba(83, 86, 251, 0.2);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Role
                </a>
            </div>
            <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
                <thead class="nftmax-table__head">
                    <tr>
                        <th class="nftmax-table__h1">#</th>
                        <th class="nftmax-table__h2">Role Name</th>
                        <th class="nftmax-table__h3">Actions</th>
                    </tr>
                </thead>
                <tbody class="nftmax-table__body">
                    @forelse ($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary"
                                        style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #5356FB; color: white; border: none; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="nftmax-table__no-data">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection