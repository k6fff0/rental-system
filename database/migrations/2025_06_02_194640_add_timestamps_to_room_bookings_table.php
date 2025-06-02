<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->timestamp('tentative_at')->nullable()->after('is_broker_booking');
            $table->timestamp('expires_at')->nullable()->after('auto_expire_at');
            $table->timestamp('cancelled_at')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'tentative_at',
                'expires_at',
                'cancelled_at',
            ]);
        });
    }
};
