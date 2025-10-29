@extends('layouts.app')

@section('title', 'Roles List')

@section('content')
<div class="nftmax-table mg-top-40">
    <div class="nftmax__container">
        <div class="nftmax-table__heading">
            <h3 class="nftmax-table__title mb-0">Roles List</h3>
            <a href="{{ route('roles.create') }}" class="nftmax__btn primary">Add Role</a>
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
                        <a href="{{ route('roles.edit', $role->id) }}" class="nftmax__btn edit">Edit</a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="nftmax__btn delete">Delete</button>
                        </form>
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
