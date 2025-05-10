<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'CEO',
            'Manager',
            'Accountants',
            'Supervisors',
            'Sales',
            'Building_managers',
            'Brokers',
            'Technicians',
            'Department_heads',
            'IT',
            'Technical_assistant',
            'Store_manager',
            'Suppliers',
            'Drivers',
            'Housekeeping',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
