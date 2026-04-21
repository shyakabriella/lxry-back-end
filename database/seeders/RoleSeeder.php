<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'System administrator with full access.',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Customer who requests transport or delivery.',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Employee who handles transport and delivery orders.',
            ],
            
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}