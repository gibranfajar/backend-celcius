<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Campaigns';
        $data = Campaign::all();

        return view('campaigns.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Campaign';
        $products = Product::all();

        return view('campaigns.create', compact('title', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required',
            'banner_left' => 'required',
            'banner_right' => 'required',
            'banner_center' => 'required',
            'product1_id' => 'required',
            'product2_id' => 'required',
            'product3_id' => 'required',
            'product4_id' => 'required',
            'product5_id' => 'required',
            'product6_id' => 'required',
        ]);

        if ($request->hasFile('image') && $request->hasFile('banner_left') && $request->hasFile('banner_right') && $request->hasFile('banner_center')) {
            $image = $request['image'] = $request->file('image')->store('campaigns', 'public');
            $banner_left = $request['banner_left'] = $request->file('banner_left')->store('campaigns', 'public');
            $banner_right = $request['banner_right'] = $request->file('banner_right')->store('campaigns', 'public');
            $banner_center = $request['banner_center'] = $request->file('banner_center')->store('campaigns', 'public');
        }

        Campaign::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image,
            'banner_left' => $banner_left,
            'banner_right' => $banner_right,
            'banner_center' => $banner_center,
            'category' => $request->category,
            'product1_id' => $request->product1_id,
            'product2_id' => $request->product2_id,
            'product3_id' => $request->product3_id,
            'product4_id' => $request->product4_id,
            'product5_id' => $request->product5_id,
            'product6_id' => $request->product6_id
        ]);

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $title = 'Edit Campaign';
        $products = Product::all();

        return view('campaigns.edit', compact('title', 'campaign', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required',
            'banner_left' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_right' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_center' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product1_id' => 'required',
            'product2_id' => 'required',
            'product3_id' => 'required',
            'product4_id' => 'required',
            'product5_id' => 'required',
            'product6_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($campaign->image);
            $image = $request['image'] = $request->file('image')->store('campaigns', 'public');
        }

        if ($request->hasFile('banner_left')) {
            Storage::disk('public')->delete($campaign->banner_left);
            $banner_left = $request['banner_left'] = $request->file('banner_left')->store('campaigns', 'public');
        }

        if ($request->hasFile('banner_right')) {
            Storage::disk('public')->delete($campaign->banner_right);
            $banner_right = $request['banner_right'] = $request->file('banner_right')->store('campaigns', 'public');
        }

        if ($request->hasFile('banner_center')) {
            Storage::disk('public')->delete($campaign->banner_center);
            $banner_center = $request['banner_center'] = $request->file('banner_center')->store('campaigns', 'public');
        }

        Campaign::where('id', $campaign->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image ?? $campaign->image,
            'banner_left' => $banner_left ?? $campaign->banner_left,
            'banner_right' => $banner_right ?? $campaign->banner_right,
            'banner_center' => $banner_center ?? $campaign->banner_center,
            'category' => $request->category,
            'product1_id' => $request->product1_id,
            'product2_id' => $request->product2_id,
            'product3_id' => $request->product3_id,
            'product4_id' => $request->product4_id,
            'product5_id' => $request->product5_id,
            'product6_id' => $request->product6_id
        ]);

        return redirect()->route('campaigns.index')->with('success', 'Campaign updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        Storage::disk('public')->delete($campaign->image);
        Storage::disk('public')->delete($campaign->banner_left);
        Storage::disk('public')->delete($campaign->banner_right);
        Storage::disk('public')->delete($campaign->banner_center);

        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully');
    }
}
