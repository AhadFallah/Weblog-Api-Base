<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sub = $this->subCategories;
        return [
            'name' => $this->name,
            'description' => $this->description,
    'subCategories' => $sub ? CategoryResource::collection($sub) : [],
            'age' => $this->age,
            'sex' => $this->sex,
        ];
    }
}
