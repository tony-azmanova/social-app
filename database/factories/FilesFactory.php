<?php

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
$factory->define(App\File::class, function (Faker $faker) {
    $fakedImage = $faker->image('storage/app/public/files/images/',400,300, null, false);

    return [
        'originalName' => $faker->words(1, true),
        'pathToFile' => $fakedImage,
        'mimeType' => 'image/jpg',
        'user_id' => App\User::all()->random()->id,
    ];
});
