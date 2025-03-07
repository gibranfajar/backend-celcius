<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'description' => $this->description,
            'sizechart' => $this->sizechart,
            'category' => $this->category->name,
            'collection' => $this->collection->name ?? null,
            'status' => $this->status,
            'color' => new ColorResource($this->color),
            'size' => SizeResource::collection($this->size),
            'images' => ProductImageResource::collection($this->images),
        ];
    }
}
