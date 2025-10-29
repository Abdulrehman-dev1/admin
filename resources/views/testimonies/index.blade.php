@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Testimonies</h2>
    <a href="{{ route('testimonies.create') }}" class="btn btn-primary mb-3">Create Testimony</a>
    <table id="testimonies_table" class="table nftmax-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Testimony</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonies as $testimony)
                <tr>
                    <td>{{ $testimony->id }}</td>
                    <td>{{ $testimony->user->name }}</td>
                    <td>{{ $testimony->testimony }}</td>
                    <td>{{ $testimony->status }}</td>
                    <td>
                        <a href="{{ route('testimonies.edit', $testimony->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('testimonies.destroy', $testimony )}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn shadow" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $testimonies->links() }}
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#testimonies_table').DataTable();

        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
     
</script>
@endsection
