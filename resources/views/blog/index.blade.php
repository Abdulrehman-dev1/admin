@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Blogs</h1>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create Blog</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Author</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($blogs as $blog)
            <tr>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->slug }}</td>
                <td>{{ $blog->user->name ?? 'N/A' }}</td>
                <td>{{ $blog->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('blogs.show',$blog->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('blogs.edit',$blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('blogs.destroy',$blog->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this blog?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No blogs found.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $blogs->links() }}
</div>
@endsection
