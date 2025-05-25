<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ActionPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // 🛠️ Maintenance
            'change maintenance status',
            'assign technician',
            'upload maintenance image',
            'comment on maintenance',

            // 🏘️ Units
            'update unit status',

            // 📄 Contracts
            'end contract',
            'renew contract',
            'export contract pdf',
            'preview contract',

            // 👤 Tenants
            'assign tenant to unit',
            'view tenant balance',

            // 💸 Expenses
            'upload invoice image',

            // 👷 Technicians
            'evaluate technician',
            'view technician log',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
