@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="nftmax__form mg-top-40">
    <div class="nftmax__container">
        <h3 class="nftmax__form-title">Edit Role</h3>
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="nftmax__form-group">
                <label for="name" class="nftmax__item-label">Role Name:</label>
                <input type="text" class="nftmax__item-input" name="name" value="{{ $role->name }}" required>
            </div>
            <div class="nftmax__form-group">
                <label for="permissions" class="nftmax__item-label">Permissions:</label>
                <select name="permissions[]" class="nftmax__item-select" multiple>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ in_array($permission->name, $rolePermissions) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
                </select>
            </div>
            <button type="submit" class="nftmax__btn primary">Update</button>
        </form>
    </div>
</div>
@endsection
