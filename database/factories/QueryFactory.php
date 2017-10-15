<?php

use Faker\Generator as Faker;

$factory->define(App\Query::class, function (Faker $faker) {
    return [
        'sql' => $faker->sentence,
        'description' => $faker->paragraph,
        'connection_id' => function () {
            return factory(\App\Connection::class)->create()->id;
        },
    ];
});
