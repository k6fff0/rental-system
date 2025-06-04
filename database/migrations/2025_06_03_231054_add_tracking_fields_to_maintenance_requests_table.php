<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // 🖼️ صورة بعد الصيانة
            $table->string('completed_image')->nullable()->after('image');

            // ⏱️ توقيتات الحالات
            $table->timestamp('in_progress_at')->nullable()->after('created_at');
            $table->timestamp('completed_at')->nullable()->after('in_progress_at');
            $table->timestamp('rejected_at')->nullable()->after('completed_at');

            // 👤 مين غير الحالة
            $table->foreignId('in_progress_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
            $table->foreignId('completed_by')->nullable()->constrained('users')->nullOnDelete()->after('in_progress_by');
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete()->after('completed_by');
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropColumn([
                'completed_image',
                'in_progress_at',
                'completed_at',
                'rejected_at',
                'in_progress_by',
                'completed_by',
                'rejected_by',
            ]);
        });
    }
};
