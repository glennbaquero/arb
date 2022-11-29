<?php

namespace App\Helpers;

use Faker\Factory as Faker;

use Illuminate\Support\Arr;

use App\Helpers\ListHelper;

class GeneratorHelper
{
    public static function randomFile($dir = 'public/storage/tmp', $required = 0, $extension = 'jpg') {
        $path = null;

        if ($required) {
            $files = glob($dir . '/*.' . $extension);

            if (count($files) > $required) {
                $file = array_rand($files);
                $path = $files[$file];
            }
        }

        if ($path) {
            $path = str_replace('public/storage/', '', $path);
        } else {
            $faker = Faker::create();
            $path = $faker->image('public/storage/tmp', 400, 300, null, false);
            if ($path) {
                $path = 'tmp/' . $path;
            }
        }
        
        return $path;
    }

    public static function generateMobileNumber() {
        return '09' . (string) rand(100, 999) . (string) rand(1000, 9999);
    }

    public static function generateTelephoneNumber() {
        return (string) rand(3000, 9999) . (string) rand(1000, 9999);
    }

    public static function generateBirthday($age = null) {
        if (!$age) {
            $age = rand(14, 50);
        }
        
        return now()->subYears($age)->subDays(rand(1, 365))->toDateString();
    }

    public static function randomGender() {
        return Arr::random(ListHelper::getGenderList());
    }
}