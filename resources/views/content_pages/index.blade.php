@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Content Pages</h2>
    <a href="{{ route('content-pages.create') }}" class="btn btn-primary mb-3">Add Content Page</a>
    <table id="contentPagesTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contentPages as $contentPage)
                <tr>
                    <td>{{ $contentPage->id }}</td>
                    <td>{{ $contentPage->title }}</td>
                    <td>{{ $contentPage->status }}</td>
                    <td>
                        <a href="{{ route('content-pages.show', $contentPage->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('content-pages.edit', $contentPage->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{route('content-pages.destroy', $contentPage->id) }}" method="POST" style="display:inline;">
                                  @csrf
                              @method('DELETE')
                              <button class="btn btn-danger btn-sm delete-button" data-id="{{ $contentPage->id }}">Delete</button>
                    </form>
                      
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contentPages->links() }}
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
        $(document).ready(function() {
        $('#contentPagesTable').DataTable();
    });
    $(document).ready(function() {
        // $('#contentPagesTable').DataTable();

        $('.delete-button').on('click', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/content-pages/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success');
                            window.location.reload();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
