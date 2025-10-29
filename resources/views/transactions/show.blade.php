@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transaction Details</h3>
    <div><strong>Username:</strong> {{ $transaction->username }}</div>
    <div><strong>Transaction ID:</strong> {{ $transaction->transaction_id }}</div>
    <div><strong>Paid Amount:</strong> ${{ $transaction->paid_amount }}</div>
    <div><strong>Payment For:</strong> {{ $transaction->payment_for }}</div>
    <div><strong>Pay Through:</strong> {{ $transaction->pay_through }}</div>
    <div><strong>Payment Status:</strong> {{ $transaction->payment_status }}</div>
    <div><strong>Datetime:</strong> {{ $transaction->datetime }}</div>
</div>
@endsection
