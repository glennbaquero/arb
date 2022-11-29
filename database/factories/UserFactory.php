<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

use App\Helpers\GeneratorHelper;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Users\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'image_path' => $faker->image('public/storage/tmp', 400, 300, null, false),
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'email_verified_at' => now(),
        'gender' => GeneratorHelper::randomGender(),
        'telephone_number' => GeneratorHelper::generateTelephoneNumber(),
        'mobile_number' => GeneratorHelper::generateMobileNumber(),
        'birthday' => GeneratorHelper::generateBirthday(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
