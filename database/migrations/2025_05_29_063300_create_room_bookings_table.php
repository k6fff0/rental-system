<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();

            // الغرفة اللي اتحجزت
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');

            // السمسار أو المستخدم اللي حجز
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // تواريخ الحجز
            $table->date('start_date');
            $table->date('end_date');

            // الحالة: active - expired - cancelled - auto_cancelled
            $table->enum('status', ['active', 'expired', 'cancelled', 'auto_cancelled'])->default('active');

            // ملاحظات إضافية
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
