
@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">



<h1>Slider List</h1>

<a href="{{ route('sliders.create') }}" class="btn-primary shadow my-3">Create New Slider</a>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    td{
        padding-inline: 5px;
    }
</style>
<table class="  table-bordered" id="sliderstable">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        

    </thead>
    
    <tbody>
        @forelse ($sliders as $slider)
            <tr class="my-1">
                <td>
                    @if ($slider->image)
                        <img src="{{ asset($slider->image) }}" alt="Image" width="80">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $slider->title }}</td>
                <td>{{ $slider->subtitle }}</td>
                <td>{{ $slider->description }}</td>
                <td>
                    <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-warning my-2 me-3 shadow">Edit</a>
                    <form action="{{ route('sliders.destroy', $slider) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger shadow" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No sliders found.</td>
            </tr>
        @endforelse
        
        
        
    </tbody>
</table>



<script>
    $(document).ready(function() {
        $('#sliderstable').DataTable();
    });
</script>


  <hr>

    <!-- Slider Category Create Form -->
    <h1>Create Slider Category</h1>

    @if (session('category_success'))
        <div class="alert alert-success mt-3">
            {{ session('category_success') }}
        </div>
    @endif

    @if($errors->any())
       <div class="alert alert-danger mt-3">
         <ul>
            @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
         </ul>
       </div>
    @endif

    <form action="{{ route('slider_categories.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                placeholder="Enter category name" 
                required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>




@endsection

