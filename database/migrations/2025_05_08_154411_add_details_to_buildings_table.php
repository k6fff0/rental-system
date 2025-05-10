<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToBuildingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->string('owner_name')->nullable();
            $table->string('owner_nationality')->nullable();
            $table->string('owner_id_number')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('municipality_number')->nullable();
            $table->decimal('rent_amount', 10, 2)->nullable();
            $table->decimal('initial_renovation_cost', 10, 2)->nullable();
            $table->json('electric_meters')->nullable();
            $table->json('internet_lines')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn([
                'owner_name',
                'owner_nationality',
                'owner_id_number',
                'owner_phone',
                'municipality_number',
                'rent_amount',
                'initial_renovation_cost',
                'electric_meters',
                'internet_lines',
            ]);
        });
    }
}
