<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResource;

class Article extends Model
{
    use HasFactory;

    //get writer
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //get cagtegoies
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //get tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //get article that user most visit categories by cookies
    public static function get_article(string $categories = null)
    {
        // for now i use this i prefer not use the tag too beccuse make code complex
        $query = Article::latest()->with('tags');

        // If categories are provided, apply the ordering logic
        if (!empty($categories)) {
            $query->orderByRaw("FIELD(category_id, " . $categories . ")");
        }

        // Execute the query and return the results
        return $query->get();
    }
    public function scopeFilter($query, $filter)
    {
        if ($filter['search']) {
            $query->where('name', 'like', '%'. $filter['search'].'%');
        }
        if($categoryId = $filter['category_id'] ?? null !== null && $filter['category_id'] !== "all") {
            $query->whereHas('category', function ($qu) use ($categoryId) {
                $qu->where('id', $categoryId);
            });
        }
        if($tagId = $filter['tag_id'] ?? null !== null && $filter['tag_id'] !== 'all') {
            $query->whereHas('tags', function ($qu) use ($tagId) {
                $qu->whereIn('tag_id', $tagId);
            });
        }
        if (!empty($filter['popular']) && $filter['popular'] == true) {
            $query->orderBy('likes', 'desc');
        }

    }

    //
    // public function toObject()
    // {
    //     $user = $this->user;
    //     return [
    //         'name' => $this->name,
    //         'description' => $this->description,
    //         'text' => $this->text,
    //         'cover' => $this->cover,
    //         'categories' => CategoryResource::collection($this->categories),
    //         'writer' => [
    //             'name' => $user->pname,
    //             'description' => $user->description,
    //             'profile' => $user->profile,
    //         ],
    //         'tags' => $this->tags,
    //     ];
    // }
    // public static function collection(array $articles)
    // {
    //     return array_map(function ($article) {
    //         return (new Article($article))->toObject();
    //     }, $articles);
    // }
}
