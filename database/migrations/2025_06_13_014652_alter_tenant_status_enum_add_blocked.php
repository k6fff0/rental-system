<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE tenants MODIFY tenant_status ENUM(
            'active',
            'late_payer',
            'has_debt',
            'absent',
            'abroad',
            'legal_issue',
            'blocked'
        ) NOT NULL DEFAULT 'active'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE tenants MODIFY tenant_status ENUM(
            'active',
            'late_payer',
            'has_debt',
            'absent',
            'abroad',
            'legal_issue'
        ) NOT NULL DEFAULT 'active'");
    }
};
