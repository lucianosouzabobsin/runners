<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Runner;
use Faker\Generator as Faker;

$factory->define(Runner::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'cpf' => $faker->text,
        'birthday' => $faker->date('Y-m-d'),
    ];
});
