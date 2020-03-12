<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with(['issue', 'user'])->paginate(20);
        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        if ($comment = Comment::create([
            'issue_id' => $request->issue_id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
        ])) {
            return response()->json([
                'comment' => $comment
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->comment = $request->comment;
        $comment->issue_id = $request->issue_id;
        $comment->user_id = $request->user_id;

        if ($comment->save()) {
            return response()->json([
                'comment' => $comment
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
