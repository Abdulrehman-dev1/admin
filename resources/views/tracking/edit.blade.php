@extends('layouts.app')

@section('content')
    <h1>Edit Tracking Record</h1>
    <form action="{{ route('tracking.update', $tracking) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="current_location">Current Location:</label>
        <input type="text" name="current_location" value="{{ $tracking->current_location }}" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="in_transit" {{ $tracking->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
            <option value="at_warehouse" {{ $tracking->status == 'at_warehouse' ? 'selected' : '' }}>At Warehouse</option>
            <option value="out_for_delivery" {{ $tracking->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ $tracking->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
        </select>

        <label for="estimated_delivery_date">Estimated Delivery Date:</label>
        <input type="date" name="estimated_delivery_date" value="{{ $tracking->estimated_delivery_date }}">

        <button type="submit">Update</button>
    </form>
@endsection
