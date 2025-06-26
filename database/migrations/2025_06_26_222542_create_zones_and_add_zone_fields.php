<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // جدول المناطق
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // تعديل جدول المباني
        Schema::table('buildings', function (Blueprint $table) {
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
        });

        // تعديل جدول المستخدمين
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
            $table->boolean('has_all_zones')->default(false); // فني يشوف كل المناطق
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['zone_id', 'has_all_zones']);
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('zone_id');
        });

        Schema::dropIfExists('zones');
    }
};
