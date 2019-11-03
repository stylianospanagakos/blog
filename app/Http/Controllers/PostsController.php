<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('post_ownership')->only('edit', 'update', 'destroy');
    }

    public function index() {

        $posts = Post::with(['user', 'tags', 'comments', 'likes'])
            ->orderByDesc('created_at')
            ->paginate(Post::PAGINATION_NUMBER);

        return view('home', ['posts' => $posts]);
    }

    public function show(Post $post) {

        // load relationships
        $post->load(['user', 'tags', 'comments.user'])->loadCount(['comments', 'likes']);

        // we start by assuming post is not liked
        $liked = false;

        // check if post is already liked by - potential - logged in user
        if (auth()->user()) {
            $liked = $post->likes->where('user_id', auth()->user()->id)->first() ? true : false;
        }

        return view('post_show', [
            'post' => $post,
            'liked' => $liked
        ]);
    }

    public function create() {

        return view('post_create');

    }

    public function store(PostRequest $request) {

        // save post
        $post = Post::create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ]);

        // get tags
        $tags = Tag::getUniqueTags($request->input('tags'));

        foreach ($tags as $tag) {

            // get tag record
            $record = Tag::getTagByName($tag);

            // make connection
            $post->tags()->attach($record);

        }

        return redirect()->route('posts.show', $post->id);

    }

    public function edit(Post $post) {

        // load relationships
        $post->load(['user', 'tags', 'comments.user'])->loadCount(['comments', 'likes']);

        return view('post_edit', ['post' => $post]);

    }

    public function update(PostRequest $request, Post $post) {

        $update = false;

        if ($post->title !== $request->title) {
            $post->title = $request->title;
            $update = true;
        }

        if ($post->body !== $request->body) {
            $post->body = $request->body;
            $update = true;
        }

        if ($update) {
            $post->save();
        }

        // load post tags
        $post->load('tags');

        // get tags
        $tags = Tag::getUniqueTags($request->input('tags'));

        // remove the post tags that are not in the request tags
        foreach ($post->tags as $tag) {

            if (!in_array($tag->name, $tags)) {

                $post->tags()->detach($tag);

            }

        }

        // get names of existing post tags
        $post_tags = $post->tags->pluck('name')->toArray();

        // add the request tags that don't exist in post tags
        foreach ($tags as $tag) {

            if (!in_array($tag, $post_tags)) {

                // get tag record
                $record = Tag::getTagByName($tag);

                // make connection
                $post->tags()->attach($record);

            }

        }

        return redirect()->route('posts.show', $post->id);

    }

    public function destroy(Post $post) {

        $post->delete();

        return redirect()->route('home');

    }

}
