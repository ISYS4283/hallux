<?php

use Faker\Generator as Faker;

$factory->define(App\Connection::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    return [
        'name' => $name,
        'config' => [
            'driver' => 'sqlsrv',
            'host' => $faker->domainName,
            'port' => '1433',
            'database' => $name,
            'username' => $faker->userName,
            'password' => $faker->password,
            'charset' => 'utf8',
            'prefix' => '',
        ],
    ];
});
