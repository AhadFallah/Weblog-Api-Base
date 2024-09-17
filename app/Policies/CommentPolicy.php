<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function updateDelete(Comment $comment)
    {
        $user = auth()->user();
        return $comment->user_id == $user->id;

    }
}
