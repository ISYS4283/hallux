<?php

use Faker\Generator as Faker;

$factory->define(App\Attempt::class, function (Faker $faker) {
    $qq = factory(App\QueryQuiz::class)->create();
    return [
        'query_id' => $qq->query_id,
        'quiz_id' => $qq->quiz_id,
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'sql' => $faker->sentence,
        'valid' => $faker->boolean,
    ];
});
