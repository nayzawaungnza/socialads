<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'activity-list',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'service-list',
            'service-create',
            'service-edit',
            'service-delete',
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            'testimonial-list',
            'testimonial-create',
            'testimonial-edit',
            'testimonial-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'partner-list',
            'partner-create',
            'partner-edit',
            'partner-delete',
            'portfolio-list',
            'portfolio-create',
            'portfolio-edit',
            'portfolio-delete',
            'subscription-list',
            'subscription-create',
            'subscription-edit',
            'subscription-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'setting-list',
            'setting-create',
            'setting-edit',
            'setting-delete',
            'inquiry-list',
            'inquiry-create',
            'inquiry-edit',
            'inquiry-delete',      
            
        ];

        $guards = ['web'];
        
        foreach ($guards as $guard) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => $guard // Set guard for each permission
                ]);
            }
        }
    }
}