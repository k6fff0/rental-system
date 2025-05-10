<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // المباني
            'view buildings',
            'create buildings',
            'edit buildings',
            'delete buildings',

            // الوحدات
            'view units',
            'create units',
            'edit units',
            'delete units',

            // المستأجرين
            'view tenants',
            'create tenants',
            'edit tenants',
            'delete tenants',

            // العقود
            'view contracts',
            'create contracts',
            'edit contracts',
            'delete contracts',

            // المدفوعات
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            // الصيانة
            'view maintenance requests',
            'create maintenance requests',
            'edit maintenance requests',
            'delete maintenance requests',

            // المصروفات
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',

            // المخزون
            'view inventory',
            'create inventory',
            'edit inventory',
            'delete inventory',

            // المستخدمين والمجموعات
            'view users',
            'edit users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'edit permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
