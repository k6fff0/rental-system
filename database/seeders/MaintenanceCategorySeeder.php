<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'electricity',
            'electrical_appliances',
            'tv',
            'tv_remote',
            'air_conditioning',
            'ac_remote',
            'internet',
            'plumbing',
            'carpentry',
            'painting',
            'locks',
            'aluminum',
            'cleaning',
            'pest_control',
            'other',
        ];

        foreach ($categories as $slug) {
            DB::table('maintenance_categories')->insert([
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
