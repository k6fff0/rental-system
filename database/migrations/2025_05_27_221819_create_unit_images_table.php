<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->unsignedTinyInteger('order')->nullable(); // الترتيب في السلايدر
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_images');
    }
};
