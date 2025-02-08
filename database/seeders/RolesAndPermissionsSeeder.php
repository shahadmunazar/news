<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $viewDashboard = Permission::create(['name' => 'view_dashboard']);
        $createPost = Permission::create(['name' => 'create_post']);
        $adminRole->givePermissionTo($viewDashboard, $createPost);
        $userRole->givePermissionTo($viewDashboard);
    }
}
