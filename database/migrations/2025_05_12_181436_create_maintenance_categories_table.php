<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maintenance_categories', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->string('slug')->unique(); // الاسم البرمجي (بالإنجليزي، من غير تكرار)
            $table->timestamps(); // created_at و updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_categories');
    }
};

