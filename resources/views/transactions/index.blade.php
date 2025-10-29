@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Transactions</h3>
        <a href="{{ route('transactions.create') }}" class="btn btn-success">Create Transaction</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped datatable" id="paytable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
              	<th>Email</th>
                <th>Transaction Id</th>
                <th>Paid Amount</th>
                <th>Payment Method</th>
                
                <th>Payment Status</th>
                <th>Date & Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $key => $transaction)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $transaction->user->name }}</td>
				<td>{{ ($transaction->user->email) ?? '' }}</td>
                <td>{{ $transaction->transaction_id }}</td>
                <td>${{ $transaction->amount }}</td>
                <td>{{ $transaction->type }}</td>
                <td>{{ $transaction->status }}</td>
                <td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-button" data-id="{{ $transaction->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>

<script> 
$(document).ready(function() {
        $('#paytable').DataTable();
    });
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${transactionId}`).submit();
                    }
                });
            });
        });
    });
</script>

@foreach ($transactions as $transaction)
<form id="delete-form-{{ $transaction->id }}" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection
