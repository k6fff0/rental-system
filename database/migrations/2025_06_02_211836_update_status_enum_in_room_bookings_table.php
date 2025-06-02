<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            // نخليها string مرنة
            $table->string('status', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->enum('status', ['active', 'expired', 'cancelled', 'auto_cancelled', 'cancelled_due_to_rent'])->change();
        });
    }
};
