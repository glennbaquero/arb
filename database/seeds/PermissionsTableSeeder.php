<?php

use Illuminate\Database\Seeder;

use App\Models\Permissions\PermissionCategory;
use App\Models\Permissions\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Content Management',
                'description' => 'Manage Pages & Contents',
                'icon' => 'fa fa-feather',
                'items' => [
                    [
                        'name' => 'admin.pages.crud',
                        'description' => 'Manage Pages',
                    ],
                    [
                        'name' => 'admin.page-items.crud',
                        'description' => 'Manage Page Contents',
                    ],
                    [
                        'name' => 'admin.articles.crud',
                        'description' => 'Manage Articles',
                    ],
                ],
            ],
            [
                'name' => 'Admin Management',
                'description' => 'Manage Administrators',
                'icon' => 'fa fa-user-shield',
                'items' => [
                    [
                        'name' => 'admin.admin-users.crud',
                        'description' => 'Manage Administrator Accounts',
                    ],
                    [
                        'name' => 'admin.roles.crud',
                        'description' => 'Manage Admin Roles & Permissions',
                    ],
                ],
            ],
            [
                'name' => 'User Management',
                'description' => 'Manage User Accounts',
                'icon' => 'fa fa-users',
                'items' => [
                    [
                        'name' => 'admin.users.crud',
                        'description' => 'Manage User Accounts',
                    ],
                ],
            ],
            [
                'name' => 'Activity Logs',
                'description' => 'View Activity Logs',
                'icon' => 'fa fa-shield-alt',
                'items' => [
                    [
                        'name' => 'admin.activity-logs.crud',
                        'description' => 'View Activity Logs',
                    ],
                ],
            ],

            [
                'name' => 'Documents',
                'description' => 'Manage Documents',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.documents.crud',
                        'description' => 'Manage Documents',
                    ],
                ],
            ],

            [
                'name' => 'Faqs',
                'description' => 'Manage Faqs',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.faqs.crud',
                        'description' => 'Manage Faqs',
                    ],
                ],
            ],

            [
                'name' => 'Announcements',
                'description' => 'Manage Announcements',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.announcements.crud',
                        'description' => 'Manage Announcements',
                    ],
                ],
            ],

            [
                'name' => 'About Us',
                'description' => 'Manage About Us',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.about-us.crud',
                        'description' => 'Manage About Us',
                    ],
                ],
            ],

            [
                'name' => 'Branches/Offices',
                'description' => 'Manage Branches/Offices',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.branches.crud',
                        'description' => 'Manage Branches/Offices',
                    ],
                ],
            ],

            [
                'name' => 'Inquiries',
                'description' => 'Manage Inquiries',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.inquiries.crud',
                        'description' => 'Manage Inquiries',
                    ],
                ],
            ],

            [
                'name' => 'Supervisors',
                'description' => 'Manage Supervisors',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.supervisors.crud',
                        'description' => 'Manage Supervisors',
                    ],
                ],
            ],

            [
                'name' => 'Reports',
                'description' => 'Manage Reports',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.reports.crud',
                        'description' => 'Manage Reports',
                    ],
                ],
            ],
        ];

    	foreach ($categories as $category) {
            $permissions = $category['items'];
            unset($category['items']);

            $item = PermissionCategory::where('name', $category['name'])->first();

            if (!$item) {
                $this->command->info('Adding permission category ' . $category['name'] . '...');
                $item = PermissionCategory::create($category);
            } else {
                $this->command->warn('Updating permission category ' . $category['name'] . '...');
                $item->update($category);
            }


            foreach ($permissions as $permission) {
                $permissionItem = Permission::where('name', $permission['name'])->first();
                
                if (!$permissionItem) {
                    $this->command->info('Adding permission ' . $permission['name'] . '...');
                    $item->permissions()->create($permission);
                } else {
                    $this->command->warn('Updating permission ' . $permission['name'] . '...');
                    unset($permission['name']);
                    $permissionItem->update($permission);
                }
            }
    	}
    }
}
