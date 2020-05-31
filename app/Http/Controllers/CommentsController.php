<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use DB;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request) {
        $user_id = auth()->user()->id;
        $post_id = $request->post_id;

        $comment = new Comment;

        $comment->body = $request->comment_body;
        $comment->user_id = $user_id;
        $post = Post::find($post_id);

        $post->comments()->save($comment);

        return response()->json([
            'msg'=>'comment has been added successfully',
            'comment'=>$comment
        ]);
    }

    public function load(Request $request) {
        $post_id = $request->post_id;

        // $post = Post::find($post_id);

        $comments = DB::table('comments')
            ->where('comments.commentable_id', '=' , $post_id)
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.*', 'users.name as user_name')
            ->get();

        return response()->json([
            'msg'=>'all comments has been loaded for this post',
            'comments'=>$comments
        ]);
    }

    public function edit(Request $request) {
        $comment_id = $request->comment_id;
        $comment = Comment::find($comment_id);

        if(auth()->user()->id == $comment->user_id) {
            $comment_body = $request->comment_body;
            $comment->body = $comment_body;

            $comment->save();

            return response()->json([
                'msg'=>'comment has been edited successfully',
                'comment'=>$comment
            ]);
        }
        return response()->json([
            'error' => 'Unauthorized Action'
        ], 403);
    }

    public function delete(Request $request) {
        $comment_id = $request->comment_id;
        $comment = Comment::find($comment_id);

        if(auth()->user()->id == $comment->user_id) {
            $comment->delete();

            return response()->json([
                'msg'=>'comment has been deleted successfully',
            ]);
        }
        return response()->json([
            'error' => 'Unauthorized Action'
        ], 403);
    }
}
