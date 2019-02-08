<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'gallery_id' => App\Gallery::all()->random()->id,
        'file_id' => App\File::all()->random()->id,
    ];
});
