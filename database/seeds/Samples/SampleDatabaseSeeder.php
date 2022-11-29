<?php

use Illuminate\Database\Seeder;

class SampleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(PagesTableSeeder::class);

        $this->call(SampleItemsTableSeeder::class);
        $this->call(SampleItemRelationshipsTableSeeder::class);
        $this->call(SampleArticlesTableSeeder::class);
        $this->call(SampleAdminsTableSeeder::class);
        $this->call(SampleUsersTableSeeder::class);
    }
}
