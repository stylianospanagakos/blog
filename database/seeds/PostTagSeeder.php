<?php

use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = \App\Post::all();
        $tags = \App\Tag::all();

        foreach ($posts as $post) {

            // get random tags
            $random_tags =  $tags->random(rand(1, 4));

            // assign them to post
            $post->tags()->attach($random_tags);

        }

    }
}
