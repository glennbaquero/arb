<?php

use Faker\Generator as Faker;

use App\Helpers\GeneratorHelper;

$factory->define(App\Models\Picture::class, function (Faker $faker) {
    return [
        'image_path' => GeneratorHelper::randomFile(),
    ];
});
