<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->text('location_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->string('location_url', 191)->nullable()->change();
        });
    }
};

