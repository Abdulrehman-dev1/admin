@extends('layouts.app')



@section('content')

<table>
  <thead>
    <tr>
        <th>Auction ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Status</th>
        <th>Date</th>
      
    
      
     
     
    </tr>
  </thead>
  <tbody>
  @foreach($transactions as $txn)
    <tr>
      <td>{{ $txn->product_id }}</td>
      <td>
          @php
            // Decode the auction's album JSON into an array
            $album = json_decode(optional($txn->auction)->album ?? '[]', true);
            // Grab the first image, or empty string if none
            $img = (is_array($album) && count($album)) ? $album[0] : '';
          @endphp

          @if($img)
            <img 
              src="{{ asset($img) }}" 
              alt="{{ optional($txn->auction)->title }}" 
              style="width:50px; height:auto;"
            >
          @else
            —
          @endif
        </td>
       <td>{{ $txn->auction->title }}</td>
      <td>{{ $txn->amount }}</td>
      <td>{{ $txn->type }}</td>
      <td>{{ $txn->status }}</td>
      <td>{{ $txn->created_at }}</td>
     
     
  
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
