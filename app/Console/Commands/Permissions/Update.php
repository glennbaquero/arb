<?php

namespace App\Console\Commands\Permissions;

use App\Extenders\BaseCommand as Command;

use App\Models\Roles\Role;
use App\Models\Permissions\Permission;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute PermissionsTableSeeder';

    /**
     * Command to run
     * @return void
     */
    protected function start()
    {
        $this->call('db:seed', [
            '--class' => 'PermissionsTableSeeder',
        ]);

        Role::first()->syncPermissions(Permission::all());
    }
}
