<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'custom_product_id' => $this->custom_product_id,
            'slug' => $this->slug,
            'price' => $this->price,
            'discount' => $this->discount,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'store' => $this->store,
            'category_id' => $this->category_id,
            'unit_id' => $this->unit_id,
            'more_info' => $this->more_info,
            'category' => $this->category,
            'unit' => $this->unit,
            'reviews' => $this->reviews,
            'product_star' => $this->product_star,

            'image' => json_decode($this->image),
            'thumb' => json_decode($this->thumb),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
