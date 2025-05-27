<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('building_utilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['electricity', 'water', 'internet']);
            $table->string('value'); // رقم العداد أو رقم الخط
            $table->string('owner_name')->nullable();
            $table->string('owner_id_number')->nullable();
            $table->string('owner_id_image')->nullable(); // مسار الصورة
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_utilities');
    }
};
