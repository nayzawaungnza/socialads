<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();

        if ($adminRole) {
            $adminRole->syncPermissions(Permission::where('guard_name', 'web')->get()); // Sync all admin guard permissions
            $this->command->info('All permissions have been assigned to the Admin role.');
        } else {
            $this->command->error('Admin role not found.');
        }
    }
}