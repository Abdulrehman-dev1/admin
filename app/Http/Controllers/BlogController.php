<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/images/blogs'), $filename);
            $data['image'] = 'assets/images/blogs/'.$filename;
        }

        $data['slug']    = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        Blog::create($data);

        return redirect()->route('blogs.index')->with('success','Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Purani image delete karna (agar exist karti hai)
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            $file     = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/images/blogs'), $filename);
            $data['image'] = 'assets/images/blogs/'.$filename;
        }

        $data['slug'] = Str::slug($request->title);

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success','Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }
        $blog->delete();

        return redirect()->route('blogs.index')->with('success','Blog deleted.');
    }
}
