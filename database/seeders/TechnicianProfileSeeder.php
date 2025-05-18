<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TechnicianProfile;

class TechnicianProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // هات كل المستخدمين اللي عندهم رول فني (لو بتستخدم Spatie)
        $technicians = User::role('technician')->get();

        foreach ($technicians as $tech) {
            // لو عنده بروفايل بالفعل، متعملش تكرار
            if (!$tech->technicianProfile) {
                TechnicianProfile::create([
                    'user_id' => $tech->id,
                    'specialty' => 'كهرباء', // تقدر تغيره حسب رغبتك أو تخليه عشوائي
                    'status' => 'available',
                    'notes' => 'تم إضافته تلقائيًا من Seeder',
                ]);
            }
        }
    }
}
