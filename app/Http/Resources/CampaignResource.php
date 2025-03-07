<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'type' => $this->category,
            'thumbnail' => $this->image,
            'banner_left' => $this->banner_left,
            'banner_right' => $this->banner_right,
            'banner_center' => $this->banner_center,
            'product1' => $this->product1 ? new ProductResource($this->product1) : null,
            'product2' => $this->product2 ? new ProductResource($this->product2) : null,
            'product3' => $this->product3 ? new ProductResource($this->product3) : null,
            'product4' => $this->product4 ? new ProductResource($this->product4) : null,
            'product5' => $this->product5 ? new ProductResource($this->product5) : null,
            'product6' => $this->product6 ? new ProductResource($this->product6) : null,
        ];
    }
}
