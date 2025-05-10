<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('building_id')->after('id');
            $table->unsignedBigInteger('unit_id')->nullable()->after('building_id');
            $table->string('type')->after('unit_id');

            // علاقات (اختياري في حالة وجود الجداول والربط الصحيح)
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['building_id', 'unit_id', 'type']);
        });
    }
};
