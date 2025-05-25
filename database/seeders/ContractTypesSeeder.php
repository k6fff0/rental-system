<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractType;

class ContractTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['key' => 'type1', 'name' => 'نوع 1', 'is_active' => true],
            ['key' => 'type2', 'name' => 'نوع 2', 'is_active' => true],
            ['key' => 'type3', 'name' => 'نوع 3', 'is_active' => true],
        ];

        foreach ($types as $type) {
            ContractType::updateOrCreate(['key' => $type['key']], $type);
        }
    }
}
