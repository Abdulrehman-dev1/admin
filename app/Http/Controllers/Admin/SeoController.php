<?php
// app/Http/Controllers/Admin/SeoController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $rows = Seo::paginate(20);
        return view('seo.index', compact('rows'));
    }

    public function create()
    {
        // Pass an empty Seo instance (so your form can bind to old() values)
        return view('seo.form', ['seo' => new Seo()]);
    }

    public function store(Request $request)
    {
        // Validate incoming data
        //dd($request);
        $data = $request->validate([
            'slug'             => 'required|unique:seos,slug',
            'meta_title'       => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
           
        ]);
       // dd($data);

        // Mass-assign into the DB
        Seo::create($data);

        // Redirect back to the index with a success flash
        return redirect()->route('seo.index')
                         ->with('success', 'SEO record created.');
    }

    public function edit(Seo $seo)
    {
        // $seo is injected by Route-Model binding
        return view('seo.form', compact('seo'));
    }

    public function update(Request $request, Seo $seo)
    {
        $data = $request->validate([
            'slug'             => 'required|unique:seos,slug,' . $seo->id,
            'meta_title'       => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
          
        ]);

        $seo->update($data);

        return redirect()->route('seo.index')
                         ->with('success', 'SEO record updated.');
    }

   public function destroy($id)
{
    $seo = Seo::findOrFail($id);
    $seo->delete();

    return redirect()->route('seo.index')
                     ->with('success', 'SEO record deleted.');
}

    public function show(Seo $seo)
    {
        return view('seo.show', compact('seo'));
    }
}
