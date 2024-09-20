<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class ArticleResource extends JsonResource
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
            'description' => $this->description,
            'text' => $this->text,
            'cover' => $this->cover,
            'categories' => CategoryArticleResource::collection([$this->category]),
            'writer' => [
                'name' => $user->pname,
                'description' => $user->description,
                'profile' => $user->profile,
            ],
            'tags' => $this->tags()->limit(5)->get(),
            'comments' => CommentResource::collection($this->comments),
            'create' => Jalalian::fromDateTime($this->updated_at)->format('Y/m/d')
        ];
    }
}
