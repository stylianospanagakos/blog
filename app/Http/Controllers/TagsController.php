<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;

class TagsController extends Controller
{

    public function show(Tag $tag) {

        $posts = Post::hasTag($tag->name)->with(['user', 'tags', 'comments', 'likes'])
            ->orderByDesc('created_at')
            ->paginate(Post::PAGINATION_NUMBER);

        return view('home', ['posts' => $posts]);

    }

}
