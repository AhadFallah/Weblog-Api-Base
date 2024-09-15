<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = $this->parentCategories;
        return [
            'name' => $this->name,
            'description' => $this->description,
    'parentCategories' => $parent ? CategoryArticleResource::collection([$parent]) : [],
            'age' => $this->age,
            'sex' => $this->sex,
        ];
    }
}
