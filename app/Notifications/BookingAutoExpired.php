<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RoomBooking;

class BookingAutoExpired extends Notification
{
    use Queueable;

    public RoomBooking $booking;
    public string $reason;

    public function __construct(RoomBooking $booking, string $reason)
    {
        $this->booking = $booking;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'       => 'تم إنهاء حجز تلقائيًا',
            'unit_number' => $this->booking->unit->unit_number ?? 'غير محددة',
            'building'    => $this->booking->unit->building->name ?? 'غير معروف',
            'user_name'   => $this->booking->user->name ?? 'مستخدم غير معروف',
            'booking_id'  => $this->booking->id,
            'reason'      => $this->reason,
            'expired_at'  => now()->toDateTimeString(),
        ];
    }
}
