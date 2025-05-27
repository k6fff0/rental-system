<?php

namespace App\Enums;

enum UnitType: string
{
    case Studio = 'studio';
    case FurnishedStudio = 'furnished_studio';

    case RoomLounge = 'room_lounge';
    case FurnishedRoomLounge = 'furnished_room_lounge';

    case TwoRoomsLounge = 'two_rooms_lounge';
    case FurnishedTwoRoomsLounge = 'furnished_two_rooms_lounge';

    case Apartment = 'apartment';
    case FurnishedApartment = 'furnished_apartment';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
