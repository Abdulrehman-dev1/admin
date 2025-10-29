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

    <h1>Identity Verification</h1>

    

   

    <div class="table-responsive">

        <table class="table table-bordered nftmax-table table-striped table-hover shadow" id="auctionsTable">

            <thead class="">

                <tr>

                    <th>ID</th>

                    <th>User Type</th>

                    <th>Full Name</th>

                    <th>Email Address</th>

                    <th>Country</th>

                    <th>Nationality</th>

                    <th>Listing Type</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>
@foreach($identities as $identity)
    <tr>
        <td>{{ $identity->id }}</td>
        <!--<td>{{ $identity->user_type }}</td>-->
        <td>{{ $identity->full_legal_name ?? $identity->legal_entity_name }}</td>
        <td>{{ $identity->email_address }}</td>
        <td>{{ $identity->country }}</td>
		<td>{{ $identity->nationality }}</td>
        <td>{{ ucfirst(str_replace('_', ' ', $identity->listing_type)) }}</td>

        {{-- Status Dropdown --}}
        <td><div>
    @if($identity->status === 'verified')
      <span class="badge bg-success">Verified</span>
    @else
      <span class="badge bg-warning text-dark">Not Verified</span>
    @endif
  </div></td>
        <td class="d-none">
            <form action="{{ route('identities.update', $identity->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="form-select shadow-lg" onchange="this.form.submit()">
                    <option value="not_verified" {{ $identity->status == 'not_verified' ? 'selected' : '' }}>Not Verified</option>
                    <option value="verified" {{ $identity->status == 'verified' ? 'selected' : '' }}>Verified</option>
                </select>
            </form>
        </td>

        <td>
            <a href="{{ route('identities.edit', $identity->id) }}" class="btn btn-sm btn-primary">Edit</a>
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

