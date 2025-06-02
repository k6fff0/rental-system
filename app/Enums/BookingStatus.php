<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Tentative = 'tentative';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case AutoCancelled = 'auto_cancelled';
    case CancelledDueToRent = 'cancelled_due_to_rent';
    case Expired = 'expired';
    case Active = 'active';
}
