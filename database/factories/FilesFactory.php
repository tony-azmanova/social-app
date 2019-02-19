<?php

use App\User;
use App\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    $fakedImage = $faker->image('storage/app/public/files/images/',400,300, null, false);

    return [
        'originalName' => $faker->words(1, true),
        'pathToFile' => $fakedImage,
        'mimeType' => 'image/jpg',
        'user_id' => User::all()->random()->id,
    ];
});
