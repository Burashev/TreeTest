<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'index' => $this->index,
            'products' => ProductResource::collection($this->products),
            'children' => CategoryWithChildrenResource::collection($this->whenLoaded('children'))
        ];
    }
}
