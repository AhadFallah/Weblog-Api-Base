<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    /**
     * Create a new policy instance.
     */
    public function crudArticle(Article $article)
    {
        $user = auth()->user();
        return $user->id === $article->user_id;
    }
}
