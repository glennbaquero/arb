<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Arr;

use App\Helpers\GeneratorHelper;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    protected $users;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'first_name' => 'Web',
                'last_name' => 'User',
                'image_path' => GeneratorHelper::randomFile(),
                'email' => 'user@app.com',
                'username' => 'username',
                'password' => 'password',
                'mobile_number' => '09123456789',
                'telephone_number' => '12345678',
                'gender' => 'Male',
                'birthday' => GeneratorHelper::generateBirthday(),
            ],
        ];

        foreach($items as $item) {
            $item['password'] = Hash::make($item['password']);
            $item['email_verified_at'] = now();
            
            User::create($item);
        }
    }
}
