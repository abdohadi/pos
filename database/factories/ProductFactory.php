<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => factory('App\Category'),
        'ar' => ['name' => $faker->word, 'description' => $faker->word],
        'en' => ['name' => $faker->word, 'description' => $faker->word],
        'purchase_price' => 100,
        'sale_price' => 120,
        'stock' => 20
    ];
});
