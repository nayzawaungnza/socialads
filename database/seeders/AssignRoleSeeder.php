<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        $user = User::where('email', 'admin@admin.com')->first();

        if ($adminRole && $user) {
            $user->assignRole($adminRole);
            $this->command->info('User has been assigned the Admin role.');
        } else {
            $this->command->error('Admin role or user not found.');
        }
    }
}