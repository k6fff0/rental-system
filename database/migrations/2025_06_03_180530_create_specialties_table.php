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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id(); // 🔑 المفتاح الأساسي
            $table->string('name'); // 🏷️ اسم التخصص (مثلاً كهرباء)
            $table->timestamps(); // 🕓 تاريخ الإنشاء والتحديث
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};
