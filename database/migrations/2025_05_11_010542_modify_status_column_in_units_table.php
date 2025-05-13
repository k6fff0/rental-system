<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // تعديل نوع العمود Enum (لازم Raw SQL في معظم قواعد البيانات)
        DB::statement("ALTER TABLE units MODIFY status ENUM('available', 'occupied', 'maintenance', 'cleaning') DEFAULT 'available'");
    }

    public function down(): void
    {
        // لو رجعنا الميجريشن، نحذف قيمة 'cleaning'
        DB::statement("ALTER TABLE units MODIFY status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available'");
    }
};
