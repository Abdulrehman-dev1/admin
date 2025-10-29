<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogApiController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);

        return response()->json([
            'status' => true,
            'blogs' => $blogs,
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        return response()->json([
            'status' => true,
            'blog' => $blog,
        ]);
    }
}
