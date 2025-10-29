@extends('layouts.app')

@section('content')
<div class="container">
    <h2>FAQ Questions</h2>
    <a href="{{ route('faq_questions.create') }}" class="btn btn-primary mb-3">Add FAQ Question</a>
    <table class="table table-bordered" id="faqQuestionsTable">
        <thead>
            <tr>
                <th>ID</th>

                <th>Question</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqQuestions as $faq)
            <tr>
                <td>{{ $faq->id }}</td>

                <td>{{ $faq->question_text }}</td>
                <td>{{ $faq->status }}</td>
                <td>
                    <a href="{{ route('faq_questions.show', $faq->id) }}" class="btn btn-info btn-sm">Show</a>
                    <a href="{{ route('faq_questions.edit', $faq->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('faq_questions.destroy', $faq->id) }}" method="POST">
                        
                        @csrf
                        @method('DELETE')
                         <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $faq->id }}">Delete</button>
                
                    </form>
                    
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
        $(document).ready(function() {
        $('#faqQuestionsTable').DataTable();
    });
    $(document).ready(function() {
        // $('#faqQuestionsTable').DataTable();

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/faq_questions/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success').then(() => {
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
