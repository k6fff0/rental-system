<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('type', 'room_layout');
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('room_layout', 'type');
        });
    }
};