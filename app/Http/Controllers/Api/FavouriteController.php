<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\FavouriteRequest;

class FavouriteController extends Controller
{
    /**
     * Display a favarate of auth user
     */
    public function index()
    {
        // get the auth user
        $user = auth()->user();
        // $user = User::find(1);

        //get favs
        $favs = $user->favs ?? null;

        //if any favs exist
        if(!$favs) {
            return response()->json([
                'message' => 'nothing to show'
            ]);
        }

        // return the favs
        return response()->json([
            'articles' => ArticleResource::collection($favs)
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FavouriteRequest $request)
    {
        //get auth user
        $user = auth()->user();

        //validate and get data
        $data = $request->validated();

        //register favs
        $user->favs()->attche($data['article_id']);

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $user = auth()->user();

        //register favs
        $user->favs()->detach($article->id);

        return response()->json([
            'success' => true
        ]);

    }
}
