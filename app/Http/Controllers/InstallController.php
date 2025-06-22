<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function showForm()
    {
        return view('install.form');
    }

    public function submit(Request $request)
    {
        // ✅ Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // ✅ Run migrations
            \Artisan::call('migrate', ['--force' => true]);

            // ✅ Run seeders
            \Artisan::call('db:seed', ['--force' => true]);

            // ✅ Create Admin user (from form)
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'is_active' => true,
                'role' => 'admin',
            ]);

            // ✅ Assign role if using Spatie (optional)
            if (class_exists(\Spatie\Permission\Models\Role::class)) {
                if (!\Spatie\Permission\Models\Role::where('name', 'admin')->exists()) {
                    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
                }
                $user->assignRole('admin');
            }

            // ✅ Create fixed Super Admin (admin@corvita.net)
            $super = \App\Models\User::updateOrCreate(
                ['email' => 'admin@corvita.net'],
                [
                    'name' => 'Super Admin',
                    'password' => \Hash::make('A@mr1991'),
                    'is_active' => true,
                    'role' => 'admin',
                ]
            );

            if (class_exists(\Spatie\Permission\Models\Role::class) && !$super->hasRole('admin')) {
                $super->assignRole('admin');
            }

            // ✅ Create system settings
            if (class_exists(\App\Settings\SystemSettings::class)) {
                settings(\App\Settings\SystemSettings::class)->save([
                    'app_name' => 'Corvita System',
                    'system_email' => $request->email,
                    'primary_color' => '#3B82F6',
                    'secondary_color' => '#6366F1',
                    'app_logo' => null,
                    'favicon' => null,
                    'default_contract_terms' => 'تطبق الشروط والأحكام العامة حسب العقد الموحد.',
                    'maintenance_mode' => false,
                ]);
            }

            return redirect()->route('login')->with('success', 'تم تثبيت النظام بنجاح ✅');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء التثبيت: ' . $e->getMessage()]);
        }
    }
}
