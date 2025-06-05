<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Settings\SystemSettings;

class SystemSettingsSeeder extends Seeder
{
    public function run(): void
    {
        settings(SystemSettings::class)->save([
            'app_name' => 'Corvita System',
            'system_email' => 'support@corvita.net',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#6366F1',
            'app_logo' => null,
            'favicon' => null,
            'default_contract_terms' => 'تطبق الشروط والأحكام العامة حسب العقد الموحد.',
            'maintenance_mode' => false,
        ]);
    }
}
