<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('throttle:10,1');
    }

    public function store(Request $request, Post $post) {

        // if already liked, remove it
        if ($request->is_liked) {

            Like::where('user_id', auth()->user()->id)->where('post_id', $post->id)->delete();

        } else {

            // otherwise save it
            Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id
            ]);

        }

        return ['success' => true];

    }

}
