<?php

use Faker\Generator as Faker;

$factory->define(App\Connection::class, function (Faker $faker) {
    $name = $faker->unique()->word;

    $config = [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'host' => "$name.example.org",
    ];

    config(["database.connections.$name" => $config]);

    return [
        'name' => $name,
        'config' => $config,
    ];
});
