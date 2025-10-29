@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>Email Templates</h1>
        <a href="{{ route('emailtemplates.create') }}" class="btn btn-primary mb-3">Create New Template</a>
        <table class="table nftmax-table" id="emailtemplatesTable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Subject</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emailTemplate as $template)
                <tr> 
                   <td>{{ $template->id}}</td>
                   <td>{{ $template->title }}</td>
                    <td>{{ $template->type }}</td>
                    <td>{{ $template->subject }}</td>
                    <td>
                        <a href="{{ route('emailtemplates.show', $template->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('emailtemplates.edit', $template->id) }}" class="btn btn-warning btn-sm">Edit</a>
                         <!-- <form action="{{ route('emailtemplates.destroy', $template->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                         </form> -->

                   
                         <form action="{{ route('emailtemplates.destroy', $template->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger shadow" data-id="{{ $template->id }}" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>


                      
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    //  $(document).ready(function() {
    //     $('#emailtemplatesTable').DataTable();
    // });
    $(document).ready(function () {
         $('#emailtemplatesTable').DataTable();
        // $('#emailtemplatesTable').DataTable();

        $('.delete-btn').click(function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/emailtemplates/${id}`,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
