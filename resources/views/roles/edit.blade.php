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
                    <label class="nftmax__item-label">Permissions:</label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 10px;">
                        @foreach ($permissions as $permission)
                            <div style="display: flex; align-items: center; padding: 8px; background: #f8f9fa; border-radius: 4px;">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->id }}" 
                                    id="perm_{{ $permission->id }}"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                    style="margin-right: 8px; width: 16px; height: 16px; cursor: pointer;"
                                >
                                <label for="perm_{{ $permission->id }}" style="margin: 0; cursor: pointer; font-size: 14px;">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="nftmax__btn primary">Update</button>
            </form>
        </div>
    </div>
@endsection