<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function get(Request $request)
    {
        //should reseve an array  of category id that user mostly clicked
        $cookies = $request->cookie();
        $article = Article::get_article(isset($cookies['category']) ? $cookies['category'] : null);
        dd($article[0]->id);

    }
}
