@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="nftmax__form mg-top-40">
    <div class="nftmax__container">
        <h3 class="nftmax__form-title">Edit Permission</h3>
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="nftmax__form-group">
                <label for="name" class="nftmax__item-label">Permission Name:</label>
                <input type="text" class="nftmax__item-input" name="name" value="{{ $permission->name }}" required>
            </div>
            <button type="submit" class="nftmax__btn primary">Update</button>
        </form>
    </div>
</div>
@endsection
