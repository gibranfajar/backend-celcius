<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product' => $this->product->name,
            'qty' => $this->qty,
            'size' => $this->size,
            'price' => $this->price,
            'color' => $this->color,
            'total' => $this->total,
            'created' => $this->created_at->format('Y-m-d'),
            'image' => ProductImageResource::collection($this->product->images)->first()->image,
        ];
    }
}
