<?php

namespace App\Enums;

enum UnitType: string
{
    case Studio = 'studio';
    case RoomLounge = 'room_lounge';
    case TwoRoomsLounge = 'two_rooms_lounge';
    case Apartment = 'apartment';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
