@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($transaction) ? 'Edit' : 'Create' }} Transaction</h3>

    <form action="{{ isset($transaction) ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST">
        @csrf
        @if(isset($transaction))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $transaction->username ?? '') }}" required>
        </div>

        <!-- Similar form inputs for transaction_id, paid_amount, payment_for, pay_through, payment_status, datetime -->

        <button type="submit" class="btn btn-primary">{{ isset($transaction) ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
