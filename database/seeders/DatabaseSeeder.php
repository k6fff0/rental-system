<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MaintenanceCategorySeeder::class,
        ]);
    }
	public function run(): void
{
    $this->call([
        // باقي السييدرز...
        SystemSettingsSeeder::class,
    ]);
}

}
