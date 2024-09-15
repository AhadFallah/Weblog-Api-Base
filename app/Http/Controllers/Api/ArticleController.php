<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\Articles\ArticleRequest;
use App\Http\Requests\Articles\ArticleUpdateRequest;
use App\Http\Services\ImageService;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['store','update','delete']]);
    }


    //@param cookies[category] string example '1,2,3'
    public function index(Request $request)
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
    public function store(ArticleRequest $request, ImageService $imageService)
    {
        //get the data
        $data = $request->all();

        //validate data
        $request->validated();

        //save the cover and return the path
        $image = $imageService->setFile($data['cover'])->setPath('images'.DIRECTORY_SEPARATOR.'covers')->save();

        //put the path in data
        $data['cover'] = $image;

        $article = Article::create($data);

        //foreach in tags user given and if do not exist make one
        foreach ($data['tags'] as $tag) {
            $existingTag = Tag::firstOrCreate(['name' => $tag]);
            $article->tags()->attach($existingTag);
        }
        //return a success message
        return response()->json([
            'success' => true
        ]);
    }
    //########################################################################################################
    //
    //
    //
    //@param article object and tag
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        //todo need to be test
        $this->authorize('crudArticle', $article);

        //get the data
        $data = $request->all();

        //validate data
        $request->validated();

        //if want to update the cover delete cover and add new one
        if(isset(data['cover'])) {

            //init image service
            $imageService = new ImageService();

            //delete cover
            $imageService->deleteImage($article->cover);

            //save the cover and return the path
            $image = $imageService->setFile($data['cover'])->setPath('images'.DIRECTORY_SEPARATOR.'covers')->save();

            //put the path in data
            $data['cover'] = $image;
        }

        //update
        $article->update($data);

        //detach all tag for update
        $article->tags()->detach();
        foreach ($data['tags'] as $tag) {
            $existingTag = Tag::firstOrCreate(['name' => $tag]);
            $article->tags()->attach($existingTag);
        }



    }
    //########################################################################################################
    //
    //
    //@param article object
    public function destroy(Article $article)
    {
        //todo need to be tested
        $this->authorize('crudArticle', $article);

        $article->delete();

        return response()->json([
            'success' => true
        ]);
    }

}
