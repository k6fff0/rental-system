<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ إنشاء اليوزر
        $user = User::updateOrCreate(
            ['email' => 'admin@corvita.net'],
            [
                'name' => 'super',
                'password' => Hash::make('A@mr1991'),
                'is_hidden' => true, // تأكد إن العمود ده موجود ف جدول users
            ]
        );

        // ✅ إنشاء role super-admin
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // ✅ صلاحيات من الواقع اللي انت طلعتها من Tinker
        $permissions = [
            "create buildings",
            "create contracts",
            "create expenses",
            "create inventory",
            "create maintenance requests",
            "create payments",
            "create roles",
            "create tenants",
            "create units",
            "delete buildings",
            "delete contracts",
            "delete expenses",
            "delete inventory",
            "delete maintenance requests",
            "delete payments",
            "delete roles",
            "delete tenants",
            "delete units",
            "edit buildings",
            "edit contracts",
            "edit expenses",
            "edit inventory",
            "edit maintenance requests",
            "edit payments",
            "edit permissions",
            "edit roles",
            "edit tenants",
            "edit units",
            "edit users",
            "edit-posts",
            "view buildings",
            "view contracts",
            "view expenses",
            "view inventory",
            "view maintenance requests",
            "view payments",
            "view permissions",
            "view roles",
            "view tenants",
            "view units",
            "view users",
        ];

        // ✅ إنشاء الصلاحيات لو مش موجودة
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // ✅ ربطها بالـ role
        $role->syncPermissions(Permission::all());

        // ✅ ربط اليوزر بالـ role
        $user->assignRole($role);
    }
}
