<?php

use Faker\Generator as Faker;

$factory->define(App\Reaction::class, function (Faker $faker) {
    return [
        //user_id, model, model_id,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'element_id' => function () {
            return factory(App\Post::class)->create()->id;
        },
        'element_type' => 'App\\Post',
        'reaction_type' => 'like',
    ];
});

// $factory->define(App\Reaction::class, function (Faker $faker) {
//     return [
//         //user_id, model, model_id,
//         'user_id' => function () {
//             return factory(App\User::class)->create()->id;
//         },
//         'model' => 'App\\Comment',
//         'model_id' => function () {
//             return factory(App\Comment::class)->create()->id;
//         }
//     ];
// });
