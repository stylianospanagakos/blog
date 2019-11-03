<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $postsNumber = $this->command->askWithCompletion('How many posts do you want to generate?', [], 10);

        factory(App\Post::class, $postsNumber)->create();

    }
}
