<?php

namespace App\Enums;

enum UnitStatus: string
{
    case AVAILABLE = 'available';               // متاحة
    case OCCUPIED = 'occupied';                 // مشغولة
    case BOOKED = 'booked';                     // محجوزة
    case MAINTENANCE = 'maintenance';           // صيانة
    case CLEANING = 'cleaning';                 // تنظيف
    case EXPIRED_CONTRACT = 'expired_contract'; // عقد منتهي

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'متاحة',
            self::OCCUPIED => 'مشغولة',
            self::BOOKED => 'محجوزة',
            self::MAINTENANCE => 'صيانة',
            self::CLEANING => 'تنظيف',
            self::EXPIRED_CONTRACT => 'عقد منتهي',
        };
    }
}
