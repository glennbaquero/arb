<?php

use Illuminate\Database\Seeder;

use App\Models\Users\User;

class SampleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 12)->create();
    }
}
