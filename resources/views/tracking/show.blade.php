@extends('layouts.app')

@section('content')
    <h1>Tracking Details</h1>
    <p>ID: {{ $tracking->id }}</p>
    <p>Booking ID: {{ $tracking->booking_id }}</p>
    <p>Current Location: {{ $tracking->current_location }}</p>
    <p>Status: {{ $tracking->status }}</p>
    <p>Estimated Delivery Date: {{ $tracking->estimated_delivery_date }}</p>
    <a href="{{ route('tracking.index') }}">Back to List</a>
@endsection
