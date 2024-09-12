<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    //get all the tags
    public function get()
    {
        //get all the tags
        $tags = Tag::all();

        //return all the tags
        return response()->json([
            'tags' => $tags
         ]);

    }
}
