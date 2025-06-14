<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn(['electric_meters', 'internet_lines']);
            $table->string('image')->nullable()->after('location_url');
        });
    }

    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->json('electric_meters')->nullable();
            $table->json('internet_lines')->nullable();
            $table->dropColumn('image');
        });
    }
};
