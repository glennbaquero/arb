<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Helpers\GeneratorHelper;
use App\Models\Users\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'first_name' => 'App',
                'last_name' => 'Admin',
                'image_path' => GeneratorHelper::randomFile(),
                'email' => 'admin@app.com',
                'password' => 'password',
            ],
        ];

        foreach($items as $item) {
            Admin::create([
                'first_name' => $item['first_name'],
                'last_name' => $item['last_name'],
                'image_path' => $item['image_path'],
                'email' => $item['email'],
                'password' => Hash::make($item['password']),
            ]);
        }
    }
}
