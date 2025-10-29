@extends('layouts.app')



@section('content')



<style>

     body {

      font-family: 'Arial', sans-serif;

      background-color: #f4f4f9;

      margin: 20px;

    }



    h2 {

      text-align: center;

      color: #333;

    }



    .table-container {

      max-width: 800px;

      margin: 30px auto;

      background: #fff;

      border-radius: 10px;

      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

      overflow: hidden;

    }



    table {

      width: 100%;

      border-collapse: collapse;

    }



    thead {

      background-color: #007bff;

      color: #fff;

    }



    th, td {

      padding: 15px;

      text-align: left;

    }



    th {

      text-transform: uppercase;

      font-size: 14px;

    }



    tbody tr {

      transition: all 0.3s ease;

    }



    tbody tr:nth-child(even) {

      background-color: #f9f9f9;

    }



    tbody tr:hover {

      background-color: #eaf4ff;

      transform: scale(1.02);

    }



    td {

      font-size: 14px;

      color: #333;

    }



 

   

    .width{

     display: flex;

        flex-direction: column;

        justify-content: space-evenly;

    }

</style>



<div class="container">

    <h1>Auctions</h1>

    <a href="{{ route('auctions.create') }}" class="btn btn-primary mb-3">Create New Auction</a>

   

    <div class="table-responsive">

        <table class="table table-bordered nftmax-table table-striped table-hover shadow" id="auctionsTable">

            <thead class="">

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Title</th>

                    <th>User</th>

                    <th>Category</th>

                    <th>Start Date</th>

                    <th>End Date</th>

                    <th>Reserve Price</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @foreach($auctions as $auction)
                    @php
                    $album = json_decode($auction->album,true);
                    if($album){
                      $img =$album[0];
                    }else{
                      $img = "";
                    }
                    @endphp
                    <tr>

                        <td>{{ $auction->id }}</td>

                        <td><img src="{{asset($img)}}" alt="Auction Image" style="width: 50px;"></td>

                        <td>{{ $auction->title }}</td>

                        <td>{{ ($auction->user->name) ?? '' }}</td>

                        <td>{{ ($auction->category->name) ?? '' }}</td>

                        <td>{{ $auction->start_date }}</td>

                        <td>{{ $auction->end_date }}</td>

                        <td>${{ $auction->reserve_price }}</td>

                        <td>

                            <span class="badge {{ $auction->status == 'active' ? 'bg-success' : 'bg-danger' }}">

                                {{ $auction->status == 'active' ? 'Active' : 'Inactive' }}

                            </span>

                        </td>

                        <td class="width">

                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-info btn-sm">View</a>

                            <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display:inline;">

                                @csrf

                                @method('DELETE')

                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure?')">Delete</button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>



<script>

    $(document).ready(function() {

$('#auctionsTable').DataTable({

    order: [[0, 'desc']] // Orders the first column (index 0) in descending order

});

    });

</script>





@endsection

