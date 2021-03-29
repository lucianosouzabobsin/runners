<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Competition;
use Faker\Generator as Faker;

$factory->define(Competition::class, function (Faker $faker) {
    return [
        'type' => $faker->randomDigit,
        'date' => $faker->date('Y-m-d'),
        'hour_init' => $faker->time('H:i:s'),
        'min_age' => $faker->randomDigit,
        'max_age' => $faker->randomDigit,
    ];
});
