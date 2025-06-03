<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCollectionResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CollectionResource;
use App\Models\BlogCollection;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Location;
use App\Models\PageHome;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function pagehomes()
    {
        $pagehomes = PageHome::all();
        return response()->json([
            'data' => $pagehomes
        ]);
    }

    public function categories()
    {
        $data = Category::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function collections()
    {
        $data = Collection::all();

        $collections = [];

        foreach ($data as $collection) {
            $collections[] = [
                'id' => $collection->id,
                'name' => $collection->name,
                'slug' => $collection->slug,
                'thumbnail' => $collection->banner,
            ];
        }

        return response()->json([
            'data' => $collections
        ]);
    }

    public function collectionsDetail($slug)
    {
        $data = CollectionResource::collection(Collection::where('slug', $slug)->get());

        return response()->json([
            'data' => $data,
        ]);
    }

    public function blogcollections()
    {
        $data = BlogCollectionResource::collection(BlogCollection::all());

        return response()->json([
            'data' => $data
        ]);
    }

    public function campaigns()
    {
        $data = Campaign::all();

        $campaigns = [];

        foreach ($data as $campaign) {
            $campaigns[] = [
                'id' => $campaign->id,
                'name' => $campaign->name,
                'slug' => $campaign->slug,
                'thumbnail' => $campaign->image,
            ];
        }

        return response()->json([
            'data' => $campaigns
        ]);
    }

    public function campaignDetail($slug)
    {
        $campaign = Campaign::where('slug', $slug)->with([
            'product1',
            'product2',
            'product3',
            'product4',
            'product5',
            'product6'
        ])->first();

        return new CampaignResource($campaign);
    }

    public function vouchers()
    {
        $data = Voucher::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function locations()
    {
        $data = Location::all();

        return response()->json([
            'data' => $data
        ]);
    }
}
