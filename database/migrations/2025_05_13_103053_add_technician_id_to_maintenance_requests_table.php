<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('technician_id')->nullable()->after('assigned_worker_id');

            $table->foreign('technician_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete(); // لو اتحذف اليوزر يفضل الحقل null
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropForeign(['technician_id']);
            $table->dropColumn('technician_id');
        });
    }
};
