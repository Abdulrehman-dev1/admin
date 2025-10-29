@extends('layouts.app')

@section('title', 'Add Permission')

@section('content')
<div class="nftmax__form mg-top-40">
    <div class="nftmax__container">
        <h3 class="nftmax__form-title">Add Permission</h3>
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="nftmax__form-group">
                <label for="name" class="nftmax__item-label">Permission Name:</label>
                <input type="text" class="nftmax__item-input" name="name" required>
            </div>
            <button type="submit" class="nftmax__btn primary">Save</button>
        </form>
    </div>
</div>
@endsection
