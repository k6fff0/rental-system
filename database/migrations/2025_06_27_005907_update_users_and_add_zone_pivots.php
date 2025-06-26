<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAndAddZonePivots extends Migration
{
    public function up(): void
    {
        // 🧨 حذف الأعمدة القديمة من جدول users
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'zone_id')) {
                $table->dropForeign(['zone_id']);
                $table->dropColumn('zone_id');
            }
            if (Schema::hasColumn('users', 'has_all_zones')) {
                $table->dropColumn('has_all_zones');
            }
        });

        // 🧩 جدول pivot الفنيين ↔ المناطق
        Schema::create('technician_zone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->timestamps();
        });

        // 🧩 جدول pivot مشرفي الفلل ↔ المناطق
        Schema::create('supervisor_zone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technician_zone');
        Schema::dropIfExists('supervisor_zone');

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
            $table->boolean('has_all_zones')->default(false);
        });
    }
}
