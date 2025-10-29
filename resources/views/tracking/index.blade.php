@extends('layouts.app')

@section('title', 'Tracking Records')

@section('content')
<div class="nftmax-table mg-top-40">
    <div class="nftmax__container">

        <div class="nftmax-table__heading">
            <h3 class="nftmax-table__title mb-0">Tracking Records</h3>
            <a href="{{ route('tracking.create') }}" class="nftmax__btn nftmax__btn--primary">Add Tracking Record</a>
        </div>

        <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
            <!-- NFTMax Table Head -->
            <thead class="nftmax-table__head">
                <tr>
                    <th class="nftmax-table__column-1 nftmax-table__h1">ID</th>
                    <th class="nftmax-table__column-2 nftmax-table__h2">Booking ID</th>
                    <th class="nftmax-table__column-3 nftmax-table__h3">Current Location</th>
                    <th class="nftmax-table__column-4 nftmax-table__h4">Status</th>
                    <th class="nftmax-table__column-5 nftmax-table__h5">Estimated Delivery Date</th>
                    <th class="nftmax-table__column-6 nftmax-table__h6">Actions</th>
                </tr>
            </thead>
            <!-- NFTMax Table Body -->
            <tbody class="nftmax-table__body">
                @forelse ($trackings as $tracking)
                <tr>
                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                        <span class="nftmax-table__text">{{ $tracking->id }}</span>
                    </td>
                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                        <span class="nftmax-table__text">{{ $tracking->booking_id }}</span>
                    </td>
                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                        <span class="nftmax-table__text">{{ $tracking->current_location }}</span>
                    </td>
                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                        <span class="nftmax-table__text">{{ ucfirst($tracking->status) }}</span>
                    </td>
                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                        <span class="nftmax-table__text">{{ $tracking->estimated_delivery_date }}</span>
                    </td>
                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                        <div class="nftmax__actions">
                            <a href="{{ route('tracking.show', $tracking) }}" class="nftmax__btn nftmax__btn--view">View</a>
                            <a href="{{ route('tracking.edit', $tracking) }}" class="nftmax__btn nftmax__btn--edit">Edit</a>
                            <form action="{{ route('tracking.destroy', $tracking) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="nftmax__btn nftmax__btn--delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="nftmax-table__no-data">No tracking records found.</td>
                </tr>
                @endforelse
            </tbody>
            <!-- End NFTMax Table Body -->
        </table>

    </div>
</div>
@endsection
