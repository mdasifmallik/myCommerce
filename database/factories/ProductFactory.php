<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    $product_name = $faker->sentence($nbWords = 5, $variableNbWords = true);
    $slug = Str::slug($product_name . "-" . Str::random(5));
    return [
        'category_id' => 1,
        'product_name' => $product_name,
        'product_short_description' => $faker->text(),
        'product_long_description' => $faker->paragraph($nbSentences = 6, $variableNbSentences = true),
        'product_price' => rand(10, 10000),
        'product_quantity' => rand(5, 100),
        'product_alert_quantity' => rand(3, 10),
        'slug' => $slug,
    ];
});
