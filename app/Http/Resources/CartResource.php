<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user' => $this->user->name,
            'size' => $this->size->size,
            'color' => $this->color->color,
            'price' => $this->price,
            'qty' => $this->qty,
            'product' => new ProductCartResource($this->product),
        ];
    }
}
