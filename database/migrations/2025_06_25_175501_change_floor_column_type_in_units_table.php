<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFloorColumnTypeInUnitsTable extends Migration
{
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('floor')->change();
        });
    }

    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->integer('floor')->change();
        });
    }
}
