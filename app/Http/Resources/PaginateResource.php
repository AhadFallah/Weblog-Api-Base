<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

   'data' => $this->collection,
            'page' => $this->currentPage(),
            'to' => $this->lastItem(),
            'total' => $this->lastPage(),
            'next' => $this->nextPageUrl(),
            'perv' => $this->previousPageUrl(),
        ];
    }
}
