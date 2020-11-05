<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'category_id' => 1,
        'blog_title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'blog_content' => $faker->text(),
    ];
});
