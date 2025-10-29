@extends('layouts.app')

@section('content')
    <h1>Edit Invoice</h1>
    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="estimated" {{ $invoice->status == 'estimated' ? 'selected' : '' }}>Estimated</option>
            <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
        </select>

        <label for="total_amount">Total Amount:</label>
        <input type="number" step="0.01" name="total_amount" value="{{ $invoice->total_amount }}" required>

        <label for="advance_amount">Advance Amount:</label>
        <input type="number" step="0.01" name="advance_amount" value="{{ $invoice->advance_amount }}">

        <label for="remaining_amount">Remaining Amount:</label>
        <input type="number" step="0.01" name="remaining_amount" value="{{ $invoice->remaining_amount }}">

        <button type="submit">Update</button>
    </form>
@endsection
