<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 🛡 تنظيف القيم غير المعروفة قبل التغيير
        DB::table('tenants')
            ->whereNull('tenant_status')
            ->orWhereNotIn('tenant_status', [
                'active',
                'late_payer',
                'has_debt',
                'absent',
                'abroad',
                'legal_issue'
            ])
            ->update(['tenant_status' => 'active']);

        Schema::table('tenants', function (Blueprint $table) {
            $table->enum('tenant_status', [
                'active',
                'late_payer',
                'has_debt',
                'absent',
                'abroad',
                'legal_issue'
            ])->default('active')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('tenant_status')->change();
        });
    }
};
