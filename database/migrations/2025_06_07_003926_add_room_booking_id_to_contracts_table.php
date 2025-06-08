<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('room_booking_id')->nullable()->after('unit_id');
            $table->foreign('room_booking_id')->references('id')->on('room_bookings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['room_booking_id']);
            $table->dropColumn('room_booking_id');
        });
    }
};
