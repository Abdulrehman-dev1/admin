@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
<style>
#imgModal .modal-dialog {
    max-width: 90vw !important;
    margin: auto;
        display: flex
;
    justify-content: center;

}
#imgModal img {
    max-height: 70vh;
    max-width: 90vw;
    display: block;
    margin: 0 auto;
    object-fit: contain;
    background: #222;
    border-radius: 8px;
}
.show {
    position: fixed !important; 
    transform: translate(0px, 0px) !important;
    border: none;
}
.modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: auto !important;
    pointer-events: auto;
     background-color: transparent !important; 
    background-clip: padding-box;
    border: none !important; 
    border-radius: .3rem;
    outline: 0;
}
</style>
<div class="container">
    <div class="row">
              {{-- Left: Auction Details --}}
        <div class="col-md-6">
            <h4>Auction Details</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item"><b>ID:</b> {{ $auction->id }}</li>
                <li class="list-group-item"><b>Title:</b> {{ $auction->title }}</li>
               
              <li class="list-group-item"><b>Category:</b> {{ $auction->category->name ?? '-' }}</li>
<li class="list-group-item"><b>Sub Category:</b> {{ $auction->subCategory->name ?? '-' }}</li>
<li class="list-group-item"><b>Child Category:</b> {{ $auction->childCategory->name ?? '-' }}</li>
                <li class="list-group-item"><b>Create Category:</b> {{ $auction->create_category }}</li>
                <li class="list-group-item"><b>Start Date:</b> {{ $auction->start_date }}</li>
                <li class="list-group-item"><b>End Date:</b> {{ $auction->end_date }}</li>
                <li class="list-group-item"><b>Reserve Price:</b> {{ $auction->reserve_price }}</li>
                <li class="list-group-item"><b>Minimum Bid:</b> {{ $auction->minimum_bid }}</li>
                <li class="list-group-item"><b>Product Year:</b> {{ $auction->product_year }}</li>
                <li class="list-group-item"><b>Product Location:</b> {{ $auction->product_location }}</li>
               <li class="list-group-item">
    <b>Status:</b>
    @php
        $status = strtolower($auction->status);
        $badges = [
            'active'    => 'success',
            'inactive'  => 'warning',
            'resubmit'  => 'info',
            'decline'   => 'danger',
        ];
        $badgeClass = $badges[$status] ?? 'info';
    @endphp
    <span class="badge bg-{{ $badgeClass }}" style="font-size: 15px;">
        {{ ucfirst($status) }}
    </span>
</li>
                <li class="list-group-item"><b>Description:</b> {{ $auction->description }}</li>
                <li class="list-group-item">
                    <b>Album:</b>
                    <div class="d-flex flex-wrap">
                        @php
                            $album = is_array($auction->album) ? $auction->album : (json_decode($auction->album, true) ?: []);
                        @endphp
                        @foreach($album as $img)
                            @php
                                $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                                $isPdf = $ext === 'pdf';
                                $url = asset($img);
                            @endphp
                            @if($isPdf)
                                <a href="{{ $url }}" target="_blank" class="m-2">
                                    <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                </a>
                            @else
                                <img src="{{ $url }}" class="img-thumbnail m-2 preview-img" style="width:80px;cursor:pointer;" data-img="{{ $url }}" />
                            @endif
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>


        {{-- Right: User & Property/Vehicle --}}
        <div class="col-md-6">
            <h4>User Details</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item"><b>Name:</b> {{ $auction->user->name ?? '-' }}</li>
                <li class="list-group-item"><b>Email:</b> {{ $auction->user->email ?? '-' }}</li>
            </ul>
@if($auction->property_verification)
    <h5>Property Verification</h5>
    <ul class="list-group mb-4">
        <li class="list-group-item"><b>ID:</b> {{ $auction->property_verification->id }}</li>
        <li class="list-group-item"><b>Type:</b> {{ $auction->property_verification->property_type }}</li>
        <li class="list-group-item"><b>Address:</b> {{ $auction->property_verification->property_address }}</li>
        <li class="list-group-item"><b>Title Deed Number:</b> {{ $auction->property_verification->title_deed_number }}</li>
        {{-- Property Documents --}}
        <li class="list-group-item">
            <b>Documents:</b>
            <div class="d-flex flex-wrap">
                @php
                    $docs = is_array($auction->property_verification->property_documents)
                        ? $auction->property_verification->property_documents
                        : (json_decode($auction->property_verification->property_documents, true) ?: []);
                @endphp
                @foreach($docs as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                        $isPdf = $ext === 'pdf';
                        $url = asset($doc);
                    @endphp
                    @if($isPdf)
                        <a href="{{ $url }}" target="_blank" class="m-2">
                            <i class="fa fa-file-pdf-o fa-2x text-danger"></i>
                        </a>
                    @else
                        <img src="{{ $url }}" class="img-thumbnail m-2 preview-img" style="width:60px;cursor:pointer;" data-img="{{ $url }}" />
                    @endif
                @endforeach
            </div>
        </li>
    </ul>
@endif

@if($auction->vehicle_verification)
    <h5>Vehicle Verification</h5>
    <ul class="list-group mb-4">
        <li class="list-group-item"><b>ID:</b> {{ $auction->vehicle_verification->id }}</li>
        <li class="list-group-item"><b>Make & Model:</b> {{ $auction->vehicle_verification->vehicle_make_model }}</li>
        <li class="list-group-item"><b>Year of Manufacture:</b> {{ $auction->vehicle_verification->year_of_manufacture }}</li>
        <li class="list-group-item"><b>Chassis/VIN:</b> {{ $auction->vehicle_verification->chassis_vin }}</li>
        {{-- Vehicle Documents --}}
        <li class="list-group-item">
            <b>Documents:</b>
            <div class="d-flex flex-wrap">
                @php
                    $vdocs = is_array($auction->vehicle_verification->vehicle_documents)
                        ? $auction->vehicle_verification->vehicle_documents
                        : (json_decode($auction->vehicle_verification->vehicle_documents, true) ?: []);
                @endphp
                @foreach($vdocs as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                        $isPdf = $ext === 'pdf';
                        $url = asset($doc);
                    @endphp
                    @if($isPdf)
                        <a href="{{ $url }}" target="_blank" class="m-2">
                            <i class="fa fa-file-pdf-o fa-2x text-danger"></i>
                        </a>
                    @else
                        <img src="{{ $url }}" class="img-thumbnail m-2 preview-img" style="width:60px;cursor:pointer;" data-img="{{ $url }}" />
                    @endif
                @endforeach
            </div>
        </li>
    </ul>
@endif

        </div>
    </div>

<div id="imgModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0">
           
            <div style="display:flex; justify-content:center; align-items:center; min-height:70vh;">
                <img id="modalImage" src="" />
            </div>
        </div>
    </div>
</div>

    {{-- Action Buttons --}}
    <div class="mt-4">
        <a href="{{ route('auctionstatus.index') }}" class="btn btn-secondary">Back</a>
       <form action="{{ route('auctionstatus.accept', $auction->id) }}" method="POST" style="display:inline;">
    @csrf
    <button class="btn btn-success mx-2" type="submit">Accept</button>
</form>

        <button type="button" class="btn btn-danger" id="declineBtn">Decline</button>
    </div>

    {{-- Decline Section --}}
   <form action="{{ route('auctionstatus.decline', $auction->id) }}" method="POST">
    @csrf
    <textarea name="decline_reason" class="form-control my-4" rows="3" required placeholder="Enter decline reason..."></textarea>
    <button class="btn btn-primary">Submit</button>
</form>
</div>


@section('scripts')
@endsection
<!-- In your layouts/app.blade.php before </body> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(function(){
    $('.preview-img').on('click', function(){
        $('#modalImage').attr('src', $(this).data('img'));
        $('#imgModal').modal('show');
    });
    $('#declineBtn').on('click', function(){
        $('#declineReason').show();
    });
});
</script>
@endsection
