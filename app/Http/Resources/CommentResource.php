<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        return [
            'name' => $this->name,
            'comment' => $this->comment,
            'subComments' => CommentResource::collection(this->subComments),
            'user' => [
                'name' => $user->pname,
        'profile' => $user->profile
            ],

        ];
    }
}
