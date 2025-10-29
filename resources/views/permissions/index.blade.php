@extends('layouts.app')

@section('title', 'Permissions List')

@section('content')
<div class="nftmax-table mg-top-40">
    <div class="nftmax__container">
        <div class="nftmax-table__heading">
            <h3 class="nftmax-table__title mb-0">Permissions List</h3>
            <a href="{{ route('permissions.create') }}" class="nftmax__btn primary">Add Permission</a>
        </div>
        <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
            <thead class="nftmax-table__head">
                <tr>
                    <th class="nftmax-table__h1">#</th>
                    <th class="nftmax-table__h2">Permission Name</th>
                    <th class="nftmax-table__h3">Actions</th>
                </tr>
            </thead>
            <tbody class="nftmax-table__body">
                @forelse ($permissions as $index => $permission)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="nftmax__btn edit">Edit</a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="nftmax__btn delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="nftmax-table__no-data">No permissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
