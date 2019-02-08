<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        //title, body, user_id, post_id,
        'title' => $faker->text($maxNbChars = 50),
        'body' => $faker->text($maxNbChars = 200),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(App\Post::class)->create()->id;
        }
    ];
});
