@extends('layouts.app')

@section('title', 'Add Invoice')

@section('content')
<div class="nftmax-form nftmax-table mg-top-40">
    <div class="nftmax__container">
        <h3 class="nftmax-form__title">Add Invoice</h3>
        
        <form action="{{ route('invoices.store') }}" method="POST" class="nftmax-form__layout">
            @csrf
            
            <!-- Booking ID -->
            <div class="nftmax-form__group">
                <label for="booking_id" class="nftmax-form__label">Booking ID:</label>
                <input type="number" name="booking_id" id="booking_id" class="nftmax-form__input" required>
            </div>

            <!-- Status -->
            <div class="nftmax-form__group">
                <label for="status" class="nftmax-form__label">Status:</label>
                <select name="status" id="status" class="nftmax-form__select" required>
                    <option value="estimated">Estimated</option>
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <!-- Total Amount -->
            <div class="nftmax-form__group">
                <label for="total_amount" class="nftmax-form__label">Total Amount:</label>
                <input type="number" step="0.01" name="total_amount" id="total_amount" class="nftmax-form__input" required>
            </div>

            <!-- Advance Amount -->
            <div class="nftmax-form__group">
                <label for="advance_amount" class="nftmax-form__label">Advance Amount:</label>
                <input type="number" step="0.01" name="advance_amount" id="advance_amount" class="nftmax-form__input">
            </div>

            <!-- Remaining Amount -->
            <div class="nftmax-form__group">
                <label for="remaining_amount" class="nftmax-form__label">Remaining Amount:</label>
                <input type="number" step="0.01" name="remaining_amount" id="remaining_amount" class="nftmax-form__input">
            </div>

            <!-- Submit Button -->
            <div class="nftmax-form__group">
                <button type="submit" class="nftmax__btn nftmax__btn--primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
