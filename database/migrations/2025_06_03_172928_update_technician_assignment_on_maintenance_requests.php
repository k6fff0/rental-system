<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // 🛠️ فك الربط أولاً لو موجود
            if (Schema::hasColumn('maintenance_requests', 'technician_id')) {
                $table->dropForeign(['technician_id']);
                $table->dropColumn('technician_id');
            }

            // ✅ نضيف الأعمدة الجديدة
            $table->foreignId('assigned_worker_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('category_id');

            $table->boolean('assigned_manually')
                ->default(false)
                ->after('assigned_worker_id');
        });
    }
};
