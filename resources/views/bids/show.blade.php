@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @php
                            $album = json_decode($bid->auction->album, true);
                            $img = $album && count($album) > 0 ? $album[0] : 'assets/images/no-image.png';
                        @endphp
                        <img src="{{ asset($img) }}" alt="Auction Image" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                    <h4>{{ $bid->auction->title ?? 'N/A' }}</h4>
                    <p><strong>Category:</strong> {{ $bid->auction->category->name ?? 'N/A' }}</p>
                    <p><strong>List Type:</strong> {{ ucfirst($bid->auction->list_type ?? 'Auction') }}</p>
                    <p><strong>Reserve Price:</strong> AED {{ number_format($bid->auction->reserve_price, 2) }}</p>
                    <p><strong>Minimum Bid:</strong> AED {{ number_format($bid->auction->minimum_bid, 2) }}</p>
                    <p><strong>Start Date:</strong> {{ $bid->auction->start_date }}</p>
                    <p><strong>End Date:</strong> {{ $bid->auction->end_date }}</p>
                    <hr>
                    <h5>Description</h5>
                    <p>{!! $bid->auction->description !!}</p>
                </div>
            </div>
        </div>

        <!-- Seller Details -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Seller Details</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset($bid->auction->user->profile_pic ?? 'assets/images/default-user.png') }}" alt="Seller Image" class="rounded-circle mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h5 class="mb-0">{{ $bid->auction->user->name ?? 'N/A' }}</h5>
                            <p class="text-muted mb-0">{{ $bid->auction->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <p><strong>Phone:</strong> 
                        @if(!empty($bid->auction->user->phone))
                            {{ $bid->auction->user->phone }}
                        @elseif(!empty($bid->auction->user->IndividualVerification->contact_number))
                            {{ $bid->auction->user->IndividualVerification->contact_number }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>

            <!-- All Bids for this Auction -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Bids for this Product</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-nowrap" style="min-width: 200px;">User</th>
                                    <th class="text-nowrap" style="min-width: 250px;">Email</th>
                                    <th class="text-nowrap" style="min-width: 150px;">Phone</th>
                                    <th class="text-nowrap" style="min-width: 120px;">Amount</th>
                                    <th class="text-nowrap" style="min-width: 150px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auctionBids as $aBid)
                                <tr class="{{ $aBid->id == $bid->id ? 'table-primary' : '' }}">
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center pr-3">
                                            <img src="{{ asset($aBid->user->profile_pic ?? 'assets/images/default-user.png') }}" alt="User" class="rounded-circle mr-3" style="width: 40px; height: 40px; min-width: 40px; object-fit: cover; border: 1px solid #ddd;">
                                            <span class="font-weight-bold ml-1">{{ $aBid->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-nowrap px-3">{{ $aBid->user->email ?? 'N/A' }}</td>
                                    <td class="align-middle text-nowrap px-3">
                                        @if(!empty($aBid->user->phone))
                                            {{ $aBid->user->phone }}
                                        @elseif(!empty($aBid->user->IndividualVerification->contact_number))
                                            {{ $aBid->user->IndividualVerification->contact_number }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="align-middle text-nowrap px-3 text-dark font-weight-bold" style="color: #000 !important;">PKR {{ number_format($aBid->bid_amount, 2) }}</td>
                                    <td class="align-middle text-nowrap px-3 text-muted" style="font-size: 0.85rem;">{{ $aBid->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .mr-3 { margin-right: 1rem !important; }
    .mr-2 { margin-right: 0.5rem !important; }
</style>
@endsection
