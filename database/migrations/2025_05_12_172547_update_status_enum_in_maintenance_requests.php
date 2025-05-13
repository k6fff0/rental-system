<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE maintenance_requests MODIFY status ENUM(
            'new',
            'in_progress',
            'completed',
            'rejected',
            'delayed',
            'waiting_materials',
            'customer_unavailable',
            'other'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE maintenance_requests MODIFY status ENUM(
            'new',
            'in_progress',
            'completed',
            'rejected'
        ) NOT NULL");
    }
};
