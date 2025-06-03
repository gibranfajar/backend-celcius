<?php

namespace App\Http\Controllers;

use App\Models\PageHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Page Homes";
        $data = PageHome::where('type', 'men')->first();

        return view('pagehomes.pagehomes', compact('title', 'data'));
    }

    public function woman()
    {
        $title = "Page Homes Woman";
        $data = PageHome::where('type', 'women')->first();

        return view('pagehomes.woman', compact('title', 'data'));
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
            'title' => 'required',
            'bannertop_desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannertop_mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannerbottom_desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannerbottom_mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required'
        ]);

        if ($request->hasFile('bannertop_desktop_image')) {
            $bannertop_desktop_image = $request['bannertop_desktop_image'] = $request->file('bannertop_desktop_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannertop_mobile_image')) {
            $bannertop_mobile_image = $request['bannertop_mobile_image'] = $request->file('bannertop_mobile_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannerbottom_desktop_image')) {
            $bannerbottom_desktop_image = $request['bannerbottom_desktop_image'] = $request->file('bannerbottom_desktop_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannerbottom_mobile_image')) {
            $bannerbottom_mobile_image = $request['bannerbottom_mobile_image'] = $request->file('bannerbottom_mobile_image')->store('pagehomes', 'public');
        }

        PageHome::create([
            'title' => $request->title,
            'bannertop_desktop_image' => $bannertop_desktop_image,
            'bannertop_mobile_image' => $bannertop_mobile_image,
            'bannerbottom_desktop_image' => $bannerbottom_desktop_image,
            'bannerbottom_mobile_image' => $bannerbottom_mobile_image,
            'type' => $request->type
        ]);

        return redirect()->route('pagehomes.index')->with('success', 'Page Home created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PageHome $pageHome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageHome $pageHome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageHome $pageHome)
    {
        $request->validate([
            'title' => 'required',
            'bannertop_desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannertop_mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannerbottom_desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bannerbottom_mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required'
        ]);

        $dataLama = PageHome::find($request->id);

        if ($request->hasFile('bannertop_desktop_image')) {
            Storage::disk('public')->delete($dataLama->bannertop_desktop_image);
            $bannertop_desktop_image = $request['bannertop_desktop_image'] = $request->file('bannertop_desktop_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannertop_mobile_image')) {
            Storage::disk('public')->delete($dataLama->bannertop_mobile_image);
            $bannertop_mobile_image = $request['bannertop_mobile_image'] = $request->file('bannertop_mobile_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannerbottom_desktop_image')) {
            Storage::disk('public')->delete($dataLama->bannerbottom_desktop_image);
            $bannerbottom_desktop_image = $request['bannerbottom_desktop_image'] = $request->file('bannerbottom_desktop_image')->store('pagehomes', 'public');
        }
        if ($request->hasFile('bannerbottom_mobile_image')) {
            Storage::disk('public')->delete($dataLama->bannerbottom_mobile_image);
            $bannerbottom_mobile_image = $request['bannerbottom_mobile_image'] = $request->file('bannerbottom_mobile_image')->store('pagehomes', 'public');
        }

        PageHome::where('id', $request->id)->update([
            'title' => $request->title,
            'bannertop_desktop_image' => $bannertop_desktop_image,
            'bannertop_mobile_image' => $bannertop_mobile_image,
            'bannerbottom_desktop_image' => $bannerbottom_desktop_image,
            'bannerbottom_mobile_image' => $bannerbottom_mobile_image,
            'type' => $request->type
        ]);

        return redirect()->route('pagehomes.index')->with('success', 'Page Home updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageHome $pageHome)
    {
        //
    }
}
