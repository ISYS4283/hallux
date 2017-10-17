<?php

use Faker\Generator as Faker;

$factory->define(App\Query::class, function (Faker $faker) {
    return [
        'sql' => 'SELECT COUNT(*) FROM products',
        'description' => 'How many products are there?',
        'connection_id' => function () {
            return factory(\App\Connection::class)->create()->id;
        },
    ];
});
