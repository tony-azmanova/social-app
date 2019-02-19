<?php

Use App\File;
use App\Image;
use App\Gallery;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'gallery_id' => Gallery::all()->random()->id,
        'file_id' => File::all()->random()->id,
    ];
});
