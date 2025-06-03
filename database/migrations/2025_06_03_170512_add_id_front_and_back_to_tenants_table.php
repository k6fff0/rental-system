<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('tenants', 'id_front')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('id_front')->nullable()->after('id_number');
            });
        }

        if (!Schema::hasColumn('tenants', 'id_back')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('id_back')->nullable()->after('id_front');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['id_front', 'id_back']);
        });
    }
};
