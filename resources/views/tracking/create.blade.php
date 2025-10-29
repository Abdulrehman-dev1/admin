@extends('layouts.app')

@section('title', 'Add Tracking Record')

@section('content')
<div class="nftmax__item">
<div class="nftmax-form nftmax-table mg-top-40">
    <div class="nftmax__container">
        <h3 class="nftmax-form__title">Add Tracking Record</h3>
        
        <form action="{{ route('tracking.store') }}" method="POST" class="nftmax-form__layout">
            @csrf
            
            <!-- Booking ID -->
            <div class="nftmax-form__group">
                <label for="booking_id" class="nftmax-form__label">Booking ID:</label>
                <input type="number" name="booking_id" id="booking_id" class="nftmax-form__input" required>
            </div>

            <!-- Current Location -->
            <div class="nftmax-form__group">
                <label for="current_location" class="nftmax-form__label">Current Location:</label>
                <input type="text" name="current_location" id="current_location" class="nftmax-form__input" required>
            </div>

            <!-- Status -->
            <div class="nftmax-form__group">
                <label for="status" class="nftmax-form__label">Status:</label>
                <select name="status" id="status" class="nftmax-form__select" required>
                    <option value="in_transit">In Transit</option>
                    <option value="at_warehouse">At Warehouse</option>
                    <option value="out_for_delivery">Out for Delivery</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>

            <!-- Estimated Delivery Date -->
            <div class="nftmax-form__group">
                <label for="estimated_delivery_date" class="nftmax-form__label">Estimated Delivery Date:</label>
                <input type="date" name="estimated_delivery_date" id="estimated_delivery_date" class="nftmax-form__input">
            </div>

            <!-- Submit Button -->
            <div class="nftmax-form__group">
                <button type="submit" class="nftmax__btn nftmax__btn--primary">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
