<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUnitTypeEnumForFurnished extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE units 
            MODIFY unit_type 
            ENUM(
                'studio',
                'furnished_studio',
                'room_lounge',
                'furnished_room_lounge',
                'two_rooms_lounge',
                'furnished_two_rooms_lounge',
                'apartment',
                'furnished_apartment'
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE units 
            MODIFY unit_type 
            ENUM(
                'studio',
                'room_lounge',
                'two_rooms_lounge',
                'apartment'
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }
}

