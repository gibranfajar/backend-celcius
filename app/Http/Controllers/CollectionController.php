<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ImageCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Collections';
        $data = Collection::orderBy('id', 'desc')->get();

        return view('collections.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Collection';

        return view('collections.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required'
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request['thumbnail'] = $request->file('thumbnail')->store('collections', 'public');
        }

        $collection = Collection::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category' => $request->category,
            'banner' => $thumbnail,
        ]);

        // menambahkan image yang banyak kedalam collection
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('collections', 'public');
                ImageCollection::create([
                    'collection_id' => $collection->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('collections.index')->with('success', 'Collection created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        $title = "Edit Collection";

        return view('collections.edit', compact('title', 'collection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'name' => 'required',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required'
        ]);

        if ($request->hasFile('thumbnail')) {
            // jika ada file baru maka cek apakah ada file lama
            if ($collection->banner) {
                Storage::disk('public')->delete($collection->banner);
            }
            $thumbnail = $request['thumbnail'] = $request->file('thumbnail')->store('collections', 'public');
        }

        Collection::where('id', $collection->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category' => $request->category,
            'banner' => $thumbnail ?? $collection->banner,
        ]);

        // menambahkan image yang banyak kedalam collection
        if ($request->hasFile('image')) {

            $images = ImageCollection::where('collection_id', $collection->id)->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image);
            }

            foreach ($request->file('image') as $image) {
                $path = $image->store('collections', 'public');
                ImageCollection::create([
                    'collection_id' => $collection->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('collections.index')->with('success', 'Collection updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
