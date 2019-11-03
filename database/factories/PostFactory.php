<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return \App\User::all()->random();
        },
        'title' => $faker->sentence,
        'body' => $faker->text
    ];
});
