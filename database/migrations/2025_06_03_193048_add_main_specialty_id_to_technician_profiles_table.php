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
            $table->foreignId('main_specialty_id')->nullable()->constrained('specialties')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->dropForeign(['main_specialty_id']);
            $table->dropColumn('main_specialty_id');
        });
    }
};
