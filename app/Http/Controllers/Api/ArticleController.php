<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    //@param cookies[category] string example '1,2,3'
    public function get(Request $request)
    {
        //should receive an string "1,2" of category id that user mostly clicked
        $cookies = $request->cookie();
        //get article by the category most clicked by user that retrieve by cookies
        $articles = Article::get_article(isset($cookies['category']) ? $cookies['category'] : null);
        //make the valid data for response
        $articles = ArticleResource::collection($articles);

        return response()->json([
            'articles' => $articles
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validated();

    }
}
