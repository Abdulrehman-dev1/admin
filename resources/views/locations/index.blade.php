@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Countries, States, and Cities</h1>

    <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Add Location</a>

    <table class="table nftmax-table" id="locations-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->name }}</td>
                    <td>Country</td>
                    <td>
                        <a href="{{ route('locations.edit', ['id' => $country->id, 'type' => 'country']) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('locations.destroy', ['id' => $country->id, 'type' => $country]) }}" method="POST">
                                 @csrf
                                @method('DELETE')
                                  <button class="btn btn-danger delete-button">Delete</button>
                         </form>
                    </td>
                </tr>
                @foreach($country->states as $state)
                    <tr>
                        <td>— {{ $state->name }}</td>
                        <td>State</td>
                        <td>
                            <a href="{{ route('locations.edit', ['id' => $state->id, 'type' => 'state']) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('locations.destroy', ['id' => $state->id, 'type' => $country]) }}" method="POST">
                                 @csrf
                                @method('DELETE')
                                  <button  class="btn btn-danger delete-button">Delete</button>
                         </form>
                        </td>
                    </tr>
                    @foreach($state->cities as $city)
                        <tr>
                            <td>—— {{ $city->name }}</td>
                            <td>City</td>
                            <td>
                                <a href="{{ route('locations.edit', ['id' => $city->id, 'type' => 'city']) }}" class="btn btn-warning">Edit</a>
                               <form action="{{ route('locations.edit', ['id' => $city, 'type' => 'city']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                 <button  class="btn btn-danger delete-button">Delete</button>
                               </form>
                               
                               

                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#locations-table').DataTable();
    });
    $(document).ready(function() {
       // $('#locations-table').DataTable();

        $('.delete-button').on('click', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');

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
                    $.ajax({
                        url: '/locations/' + id + '/' + type,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(result) {
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
