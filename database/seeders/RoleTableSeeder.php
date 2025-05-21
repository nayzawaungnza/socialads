<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $roles = [
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Editor', 'guard_name' => 'web'],
            ['name' => 'Content Writer', 'guard_name' => 'web'],
        ];

        // Create each role
        foreach ($roles as $role) {
            try {
                Role::firstOrCreate($role);
            } catch (\Exception $e) {
                Log::error("Error creating role: " . $e->getMessage());
            }
        }
    }
}