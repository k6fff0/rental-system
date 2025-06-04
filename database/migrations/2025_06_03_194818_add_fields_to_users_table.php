<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 🧠 نوع المستخدم (فني، مدير، سمسار، إلخ)
            $table->enum('user_type', ['admin', 'technician', 'broker', 'receptionist', 'accountant', 'manager'])->nullable()->after('role');

            // 🔌 التخصص الرئيسي للفني (nullable لو مش فني)
            $table->foreignId('main_specialty_id')->nullable()->after('user_type')->constrained('specialties')->nullOnDelete();

            // 🚦 حالة الفني الحالية
            $table->enum('technician_status', ['available', 'busy', 'unavailable'])->nullable()->after('main_specialty_id');

            // 🗒 ملاحظات داخلية على الموظف
            $table->text('notes')->nullable()->after('technician_status');

            // 🏢 القسم أو الإدارة التابع لها (اختياري)
            $table->string('department')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['main_specialty_id']);
            $table->dropColumn([
                'user_type',
                'main_specialty_id',
                'technician_status',
                'notes',
                'department',
            ]);
        });
    }
};
