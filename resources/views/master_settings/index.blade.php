@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Master Settings</h2>
    <a href="{{ route('master-settings.create') }}" class="btn btn-primary mb-3">Add Master Setting</a>
    <table id="masterSettingsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Key</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($masterSettings as $masterSetting)
                <tr>
                    <td>{{ $masterSetting->id }}</td>
                    <td>{{ $masterSetting->title }}</td>
                    <td>{{ $masterSetting->key }}</td>
                    <td>
                        @if($masterSetting->image)
                            <img src="{{ asset('storage/' . $masterSetting->image) }}" alt="Image" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('master-settings.show', $masterSetting->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('master-settings.edit', $masterSetting->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-button" data-id="{{ $masterSetting->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $masterSettings->links() }}
</div>

<script>
    $(document).ready(function() {
        $('#masterSettingsTable').DataTable();

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
                        url: '/master-settings/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success')
                                .then(() => location.reload());
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
