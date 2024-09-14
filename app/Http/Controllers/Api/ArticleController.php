<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\Articles\ArticleRequest;

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
    //########################################################################################################
    //
    //
    //
    //@param article object and tag
    public function store(ArticleRequest $request)
    {
        //get the data
        $data = $request->all();

        //validate data
        $request->validated();

        //todo make image service for cover

        //foreach in tags user given and if do not exist make one
        foreach ($data['tags'] as $tag) {
            $existingTag = Tag::firstOrCreate(['name' => $tag]);
            // $->tags()->attach($existingTag);
        }

    }
}
