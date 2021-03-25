<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RunnerCompetition;
use Faker\Generator as Faker;

$factory->define(RunnerCompetition::class, function (Faker $faker) {
    return [
        'runner_id' => $faker->randomDigit,
        'competition_id' => $faker->randomDigit,
        'hour_end' => $faker->time('H:i:s'),
        'position' => $faker->randomDigit
    ];
});
