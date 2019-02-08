<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'user_id' => App\User::all()->random()->id,
    ];
});
