
@extends('layouts.app')

@section('content')
<h1>Slider List</h1>

<a href="{{ route('sliders.create') }}" class="btn-primary">Create New Slider</a>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1">
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
            <tr>
                <td>
                    @if ($slider->image)
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Image" width="50">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $slider->title }}</td>
                <td>{{ $slider->subtitle }}</td>
                <td>{{ $slider->description }}</td>
                <td>
                    <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-success" >Edit</a>
                    <form action="{{ route('sliders.destroy', $slider) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
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
        
@endsection

