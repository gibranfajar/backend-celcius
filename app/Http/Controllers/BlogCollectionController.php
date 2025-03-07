<?php

namespace App\Http\Controllers;

use App\Models\BlogCollection;
use App\Models\Collection;
use Illuminate\Http\Request;

class BlogCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Blog Collections';
        $data = BlogCollection::orderBy('id', 'desc')->get();
        $collections = Collection::all();

        return view('blogcollections', compact('title', 'data', 'collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'collection' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('banner')) {
            $banner = $request['banner'] = $request->file('banner')->store('blogcollections', 'public');
        }

        BlogCollection::create([
            'collection_id' => $request->collection,
            'banner' => $banner
        ]);

        return redirect()->route('blogcollections.index')->with('success', 'Blog Collection created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCollection $blogCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCollection $blogCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCollection $blogCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCollection $blogCollection)
    {
        //
    }
}
