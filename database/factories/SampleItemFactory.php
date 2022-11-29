<?php

use Faker\Generator as Faker;

use App\Helpers\GeneratorHelper;

$factory->define(App\Models\Samples\SampleItem::class, function (Faker $faker) {
    return [
        'name' => $faker->word(3),
        'description' => $faker->paragraph,
        'image_path' => GeneratorHelper::randomFile(),
        'date' => now(),
        'dates' => [now()->toDateString(), now()->addDays(2)->toDateString()],
    ];
});
