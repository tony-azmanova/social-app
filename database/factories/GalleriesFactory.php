<?php

use App\User;
use App\Gallery;
use Faker\Generator as Faker;

$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'user_id' => User::all()->random()->id,
    ];
});
