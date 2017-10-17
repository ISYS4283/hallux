<?php

use Faker\Generator as Faker;

$factory->define(App\Connection::class, function (Faker $faker) {
    $name = $faker->unique()->word;

    $config = [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'host' => $faker->domainName,
    ];

    config(["database.connections.$name" => $config]);

    Artisan::call('migrate', ['--database' => $name]);

    return [
        'name' => $name,
        'config' => $config,
    ];
});
