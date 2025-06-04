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
        Schema::table('specialties', function (Blueprint $table) {
            $table->boolean('is_main')->default(true);
            $table->foreignId('parent_id')->nullable()->constrained('specialties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->dropColumn('is_main');
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
