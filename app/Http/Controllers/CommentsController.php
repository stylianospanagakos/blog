<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('throttle:10,1');
    }

    public function store(CommentRequest $request, Post $post) {

        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.show', $post->id);

    }

}
