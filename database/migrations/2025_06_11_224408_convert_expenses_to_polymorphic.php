<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertExpensesToPolymorphic extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // افحص قبل الحذف لتفادي الخطأ لو القيود اتشالت قبل كده
            if (Schema::hasColumn('expenses', 'building_id')) {
                try {
                    $table->dropForeign(['building_id']);
                } catch (\Throwable $e) {
                }
            }

            if (Schema::hasColumn('expenses', 'unit_id')) {
                try {
                    $table->dropForeign(['unit_id']);
                } catch (\Throwable $e) {
                }
            }
        });

        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'building_id')) {
                $table->dropColumn('building_id');
            }

            if (Schema::hasColumn('expenses', 'unit_id')) {
                $table->dropColumn('unit_id');
            }
        });
    }



    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();

            $table->dropColumn(['expensable_id', 'expensable_type']);
        });
    }
}
