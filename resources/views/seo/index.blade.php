@extends('layouts.app')

@section('content')
<div class="container">
  <h1>SEO Records</h1>
  <a href="{{ route('seo.create') }}" class="btn btn-primary mb-3">Add New</a>

  <table class="table nftmax-table" id="seo-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Slug</th>
        <th>Meta Title</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $row)
      <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->slug }}</td>
        <td>{{ $row->meta_title }}</td>
        <td>
          <a href="{{ route('seo.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <form
        action="{{ route('seo.destroy', $row) }}"
        method="POST"
        style="display:inline"
        onsubmit="return confirm('Are you sure you want to delete this record?')"
      >
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Delete</button>
      </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $rows->links() }}
</div>
@endsection


<script>
  $(function(){
    $('#seo-table').DataTable();
    $('.delete-btn').click(function(){
      const id = $(this).data('id');
      Swal.fire({
        title: 'Confirm delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete'
      }).then(({ isConfirmed })=>{
        if(isConfirmed){
          axios.delete(`/admin/seo/${id}`)
               .then(()=> location.reload());
        }
      });
    });
  });
</script>

