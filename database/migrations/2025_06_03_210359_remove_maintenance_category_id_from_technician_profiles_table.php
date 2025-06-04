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
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->dropColumn('maintenance_category_id');
        });
    }

    public function down()
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->string('maintenance_category_id')->nullable();
        });
    }
};
