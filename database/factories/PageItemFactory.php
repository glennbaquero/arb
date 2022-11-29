<?php

use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use App\Helpers\GeneratorHelper;
use App\Models\Pages\PageItem;

$factory->define(PageItem::class, function (Faker $faker) {
	$type = Arr::random(PageItem::getTypes());

	switch ($type['value']) {
		case PageItem::TYPE_IMAGE:
				$content = GeneratorHelper::randomFile();
			break;
		
		default:
				$content = $faker->word(3);
			break;
	}

    return [
        'name' => $faker->word(3),
        'slug' => $faker->unique()->word(),
        'content' => $content,
        'type' => $type['value'],
    ];
});
