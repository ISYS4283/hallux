<?php

use Faker\Generator as Faker;

$factory->define(App\Attempt::class, function (Faker $faker) {
    return [
        'query_quiz_id' => function(){
            return factory(App\QueryQuiz::class)->create()->id;
        },
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'sql' => $faker->sentence,
        'valid' => $faker->boolean,
    ];
});
