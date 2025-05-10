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
    Schema::table('contracts', function (Blueprint $table) {
        $table->text('notes')->nullable()->after('rent_amount');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('contracts', function (Blueprint $table) {
        $table->dropColumn('notes');
    });
}

};
