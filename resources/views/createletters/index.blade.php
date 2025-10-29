@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Letters</h2>
    <a href="{{ route('createletters.create') }}" class="btn btn-primary">Create New Letter</a>
    <table class="table table-striped nftmax-table " id="lettertable">
        <thead>
            <tr>
                <th>ID</th>
                <th>To</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letters as $letter)
            <tr>
                <td>{{ $letter->id }}</td>
                <td>{{ $letter->to }}</td>
                <td>{{ $letter->title }}</td>
                <td>
                    <a href="{{ route('createletters.show', $letter->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('createletters.edit', $letter->id) }}" class="btn btn-warning">Edit</a>
                    <!-- <button class="btn btn-danger" onclick="confirmDelete({{ $letter->id }})">Delete</button> -->
                    <form action="{{ route('createletters.destroy', $letter->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger shadow" onclick="confirmDelete({{ $letter->id }})">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $letters->links() }}
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this letter?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
    $(document).ready(function() {
        $('#lettertable').DataTable();
    });

</script>
@endsection
