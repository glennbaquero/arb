<?php

use Faker\Generator as Faker;

use App\Helpers\GeneratorHelper;

$factory->define(App\Models\Articles\Article::class, function (Faker $faker) {
    return [
        'name' => $faker->word(3),
        'description' => $faker->paragraph,
        'image_path' => GeneratorHelper::randomFile(),
        'published_at' => now(),
    ];
});
