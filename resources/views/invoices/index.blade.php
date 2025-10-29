@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="nftmax-table mg-top-40">
    <div class="nftmax__container">

        <div class="nftmax-table__heading">
            <h3 class="nftmax-table__title mb-0">Invoices</h3>
            <a href="{{ route('invoices.create') }}" class="nftmax__btn nftmax__btn--primary">Add Invoice</a>
        </div>

        <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
            <!-- NFTMax Table Head -->
            <thead class="nftmax-table__head">
                <tr>
                    <th class="nftmax-table__column-1 nftmax-table__h1">ID</th>
                    <th class="nftmax-table__column-2 nftmax-table__h2">Booking ID</th>

                    <th class="nftmax-table__column-4 nftmax-table__h3">Total Amount</th>
                    <th class="nftmax-table__column-5 nftmax-table__h4">Advance Amount</th>
                    <th class="nftmax-table__column-6 nftmax-table__h5">Remaining Amount</th>
                    <th class="nftmax-table__column-6 nftmax-table__h6">VAT Amount</th>
                    <th class="nftmax-table__column-6 nftmax-table__h7">Final Amount</th>
                    <th class="nftmax-table__column-3 nftmax-table__h8">Status</th>
                    <th class="nftmax-table__column-7 nftmax-table__h9">Actions</th>
                </tr>
            </thead>
            <!-- NFTMax Table Body -->
            <tbody class="nftmax-table__body">
                @forelse ($invoices as $invoice)
                <tr>
                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                        <span class="nftmax-table__text">{{ $invoice->id }}</span>
                    </td>
                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                        <span class="nftmax-table__text">{{ $invoice->booking_id }}</span>
                    </td>

                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                        <span class="nftmax-table__text">{{ ucfirst($invoice->total_cost) }}</span>
                    </td>
                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                        <span class="nftmax-table__text">{{ ucfirst($invoice->advance_payment) }}</span>
                    </td>
                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                        <span class="nftmax-table__text">{{ ucfirst($invoice->remaining_payment) }}</span>
                    </td>
                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                        <span class="nftmax-table__text">{{ ucfirst($invoice->vat) }}</span>
                    </td>
                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                        <span class="nftmax-table__text">{{ ucfirst($invoice->final_cost) }}</span>
                    </td>
                    <td class="nftmax-table__column-8 nftmax-table__data-8">

                        <span class="nftmax-table__text">{{ ucfirst($invoice->status) }}</span>
                    </td>
                    <td class="nftmax-table__column-9 nftmax-table__data-9">
                        <div class="nftmax__actions">
                            <a href="{{ route('invoices.show', $invoice) }}" class="nftmax__btn nftmax__btn--view">View</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="nftmax__btn nftmax__btn--edit">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="nftmax__btn nftmax__btn--delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="nftmax-table__no-data">No invoices found.</td>
                </tr>
                @endforelse
            </tbody>
            <!-- End NFTMax Table Body -->
        </table>

    </div>
</div>
@endsection
