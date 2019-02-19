<?php

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    return [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $firstName.'.'.$lastName.'@test.com',
        'password' => bcrypt('test123'),
        'remember_token' => str_random(10),
    ];
});
