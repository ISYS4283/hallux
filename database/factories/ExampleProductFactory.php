<?php

use Faker\Generator as Faker;

$factory->define(App\Example\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->sentence,
        'description' => $faker->paragraph,
        'price' => $faker->randomFloat(2, 0, 10000),
    ];
});
