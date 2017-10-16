<?php

use Faker\Generator as Faker;

$factory->define(App\QueryQuiz::class, function (Faker $faker) {
    return [
        'points' => $faker->numberBetween(1,5),
        'query_id' => function () {
            return factory(\App\Query::class)->create()->id;
        },
        'quiz_id' => function () {
            return factory(\App\Quiz::class)->create()->id;
        },
    ];
});
