<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->renameColumn('specialty', 'maintenance_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->renameColumn('maintenance_category_id', 'specialty');
        });
    }
};
