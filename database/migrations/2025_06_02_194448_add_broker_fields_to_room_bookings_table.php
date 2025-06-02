<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->boolean('is_broker_booking')->default(false)->after('user_id');
            $table->timestamp('confirmed_at')->nullable()->after('end_date');
            $table->timestamp('auto_expire_at')->nullable()->after('confirmed_at');
            $table->boolean('deposit_paid')->default(false)->after('auto_expire_at');
            $table->string('expired_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'is_broker_booking',
                'confirmed_at',
                'auto_expire_at',
                'deposit_paid',
                'expired_reason',
            ]);
        });
    }
};
