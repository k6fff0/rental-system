<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Amr2',
            'email' => 'k6fff1@gmail.com',
            'password' => Hash::make('A@mr1991'),
        ]);
    }
}
