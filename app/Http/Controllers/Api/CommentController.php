<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Comments\CommentRequest;
use App\Models\Comment;
use App\Http\Requests\Comments\CommentUpdateRequest;

class CommentController extends Controller
{
    /**
      * Store a newly created resource in storage.
      * @param comment fields
      */
    public function store(CommentRequest $request)
    {
        //get all the data
        $data = $request->all();

        //validate data
        $request->validated();

        //store comment

        $comment = Comment::create($data);
        if($comment) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);


    }

    /**
     * Update the specified resource in storage.
     * @param comment objcet and update fields
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $this->authrize('updateDelete', $comment);

        //get all the data
        $data = $request->all();

        //validate data
        $request->validated();

        //update comment
        $comment->update($data);


        return response()->json([
            'success' => true
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authrize('updateDelete', $comment);
        $comment->delete();
        return response()->json([
            'success' => true
        ]);

    }
}
