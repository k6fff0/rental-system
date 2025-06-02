<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\RoomBookingController;

class ExpireOldBookings extends Command
{
    protected $signature = 'bookings:expire';
    protected $description = 'Automatically expire old room bookings after their deadline';

    public function handle(): void
    {
        $controller = new RoomBookingController();
        $controller->expireOldBookings();
        $controller->expireConfirmedWithoutContract();

        $this->info('تم تنفيذ أوامر الإلغاء التلقائي للحجوزات بنجاح.');
    }
}
