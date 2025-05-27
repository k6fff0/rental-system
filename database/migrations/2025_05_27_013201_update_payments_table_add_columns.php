<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('payer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('method')->nullable(); // cash, bank transfer, etc.
            $table->text('notes')->nullable();
            $table->date('month_for')->after('payment_date');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['payer_id']);
            $table->dropColumn(['payer_id', 'method', 'notes', 'month_for']);
        });
    }
};
