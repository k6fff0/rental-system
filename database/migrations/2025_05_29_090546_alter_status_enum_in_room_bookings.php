<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE room_bookings 
            MODIFY status ENUM('active', 'expired', 'cancelled', 'auto_cancelled', 'cancelled_due_to_rent') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE room_bookings 
            MODIFY status ENUM('active', 'expired', 'cancelled', 'auto_cancelled') NOT NULL");
    }
};
