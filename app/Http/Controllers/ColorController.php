<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Colors';
        $data = Color::orderBy('id', 'desc')->get();

        return view('colors', compact('title', 'data'));
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
        $validate = $request->validate([
            'color' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validate['image'] = $request->file('image')->store('colors', 'public');
        }


        Color::create($validate);

        return redirect()->route('colors.index')->with('success', 'Color created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $validate = $request->validate([
            'color' => 'required'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($color->image);
            $validate['image'] = $request->file('image')->store('colors', 'public');
        }

        $color->update($validate);

        return redirect()->route('colors.index')->with('success', 'Color updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        //
    }
}
