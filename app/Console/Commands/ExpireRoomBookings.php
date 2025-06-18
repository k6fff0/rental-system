<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoomBooking;
use App\Enums\BookingStatus;
use Carbon\Carbon;
use App\Notifications\BookingAutoExpired;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class ExpireRoomBookings extends Command
{
    protected $signature = 'bookings:expire';
    protected $description = 'Expire tentative or confirmed room bookings if time is over';

    public function handle(): void
    {
        $now = Carbon::now();

        // ⏰ الحجوزات المؤقتة المنتهية
        RoomBooking::where('status', BookingStatus::Tentative)
            ->where('auto_expire_at', '<=', $now)
            ->get()
            ->each(function ($booking) use ($now) {
                $booking->update([
                    'status'         => BookingStatus::Expired,
                    'cancelled_at'   => $now,
                    'expired_reason' => 'tentative_expired',
                ]);

                $booking->unit->update(['status' => 'available']);

                // إشعار لكل المستخدمين
                Notification::send(
                    User::all(),
                    new BookingAutoExpired($booking, 'انتهت مهلة الحجز المؤقت بدون تأكيد')
                );

                $this->info("⛔ حجز مؤقت ID {$booking->id} تم إنهاؤه تلقائيًا");
            });

        // ⏰ الحجوزات المؤكدة المنتهية بدون عقد
        RoomBooking::where('status', BookingStatus::Confirmed)
            ->where('expires_at', '<=', $now)
            ->whereDoesntHave('contract')
            ->get()
            ->each(function ($booking) use ($now) {
                $booking->update([
                    'status'         => BookingStatus::Expired,
                    'cancelled_at'   => $now,
                    'expired_reason' => 'no_contract_signed',
                ]);

                $booking->unit->update(['status' => 'available']);

                // إشعار لكل المستخدمين
                Notification::send(
                    User::all(),
                    new BookingAutoExpired($booking, 'انتهت مهلة الحجز المؤكد بدون توقيع عقد')
                );

                $this->info("⚠️ حجز مؤكد ID {$booking->id} انتهى بدون عقد");
            });

        $this->info('✅ تم فحص الحجوزات المنتهية.');
    }
}
