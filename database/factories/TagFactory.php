<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

try {
    $factory->define(\App\Tag::class, function (Faker $faker) {
        return [
            'name' => $faker->unique()->word
        ];
    });
} catch (Exception $e) {}
