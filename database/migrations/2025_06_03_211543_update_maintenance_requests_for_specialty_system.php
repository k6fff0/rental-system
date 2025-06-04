<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // 🛠️ فك الـ foreign key قبل الحذف
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // ✅ إضافة التخصص الفرعي الجديد
            $table->foreignId('sub_specialty_id')->nullable()->constrained('specialties')->nullOnDelete();
        });
    }


    public function down()
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropForeign(['sub_specialty_id']);
            $table->dropColumn('sub_specialty_id');
            $table->foreignId('category_id')->nullable()->constrained('maintenance_categories')->nullOnDelete();
        });
    }
};
