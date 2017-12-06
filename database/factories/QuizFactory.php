<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Quiz::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'open' => (new Carbon)->subDay(),
    ];
});
