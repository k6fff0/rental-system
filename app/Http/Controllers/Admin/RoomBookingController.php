<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomBooking;
use App\Models\Unit;
use App\Models\User;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RoomBooked;

class RoomBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view bookings')->only(['index']);
        $this->middleware('permission:create bookings')->only(['store']);
        $this->middleware('permission:cancel bookings')->only(['cancel']);
    }

    // ✅ عرض كل الحجوزات
    public function index(Request $request)
    {
        $bookings = RoomBooking::with(['unit.building', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })->orWhereHas('unit', function ($q2) use ($search) {
                        $q2->where('unit_number', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(20);

           // ✅ الإحصائيات
    $stats = [
        'total'     => RoomBooking::count(),
        'confirmed' => RoomBooking::where('status', BookingStatus::Confirmed->value)->count(),
        'tentative' => RoomBooking::where('status', BookingStatus::Tentative->value)->count(),
        'cancelled' => RoomBooking::where('status', BookingStatus::Cancelled->value)->count(),
    ];
	
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    // ✅ إنشاء حجز جديد
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'notes'   => 'nullable|string',
        ]);

        $user = auth()->user();
        $unit = Unit::with('building')->findOrFail($request->unit_id);

        if (in_array($unit->status, ['occupied', 'booked'])) {
            return back()->withErrors(['unit_id' => 'هذه الغرفة غير متاحة حالياً.']);
        }

        $now = now();

        $booking = RoomBooking::create([
            'unit_id'           => $unit->id,
            'user_id'           => $user->id,
            'start_date'        => $now,
            'end_date'          => $now->copy()->addHours(24),
            'status'            => BookingStatus::Tentative->value,
            'notes'             => $request->notes,
            'is_broker_booking' => true,
            'tentative_at'      => $now,
            'auto_expire_at'    => $now->copy()->addHours(24),
            'expires_at'        => $now->copy()->addHours(24),
        ]);

        $unit->update(['status' => 'booked']);

        $unitNumber = $unit->unit_number ?? '-';
        $buildingName = $unit->building->name ?? '-';
        $message = "تم حجز الغرفة رقم {$unitNumber} في مبنى {$buildingName}";

        Notification::send(User::all(), new RoomBooked($message));

        return redirect()->route('admin.bookings.index')->with('success', 'تم حجز الغرفة مؤقتاً بنجاح. يجب تأكيده خلال 24 ساعة.');
    }

    // ✅ صفحة إنشاء حجز
    public function create()
    {
        $units = Unit::with('building')
            ->where('status', 'available')
            ->get();

        return view('admin.bookings.create', compact('units'));
    }

    // ✅ إلغاء الحجز
    public function cancel(RoomBooking $booking)
    {
        $user = auth()->user();

        if (in_array($booking->status, [
            BookingStatus::Cancelled,
            BookingStatus::Expired,
            BookingStatus::AutoCancelled,
        ])) {
            return back()->withErrors(['error' => 'هذا الحجز لا يمكن إلغاؤه لأنه منتهي أو ملغي بالفعل.']);
        }

        if ($booking->user_id !== $user->id && !$user->can('cancel bookings')) {
            abort(403, 'ليس لديك صلاحية إلغاء هذا الحجز.');
        }

        $booking->update([
            'status'       => BookingStatus::Cancelled->value,
            'cancelled_at' => now(),
        ]);

        if ($booking->unit->status === 'booked') {
            $booking->unit->update(['status' => 'available']);
        }

        return back()->with('success', 'تم إلغاء الحجز بنجاح.');
    }

    // ✅ تأكيد الحجز
    public function confirm(Request $request, RoomBooking $booking)
    {
        if ($booking->deposit_paid) {
            return back()->withErrors(['error' => 'هذا الحجز تم تأكيده مسبقاً.']);
        }

        if ($booking->status !== BookingStatus::Tentative || $booking->auto_expire_at < now()) {
            return back()->withErrors(['error' => 'لا يمكن تأكيد هذا الحجز لأنه منتهي أو غير نشط.']);
        }

        $now = now();

        $booking->update([
            'status'         => BookingStatus::Confirmed->value,
            'confirmed_at'   => $now,
            'deposit_paid'   => true,
            'auto_expire_at' => $now->copy()->addHours(48),
            'expires_at'     => $now->copy()->addHours(48),
        ]);

        return back()->with('success', 'تم تأكيد الحجز وتم تمديده 48 ساعة إضافية.');
    }

    // ✅ انتهاء الحجوزات القديمة
    public function expireOldBookings()
    {
        RoomBooking::where('status', BookingStatus::Confirmed->value)
    ->where('expires_at', '<', now())
    ->whereDoesntHave('contract') // ⬅️ دي شغالة على حسب العلاقة اللي فوق
    ->get()
    ->each(function ($booking) {
        $booking->update([
            'status'         => BookingStatus::Expired->value,
            'expired_reason' => 'no_contract_signed',
            'cancelled_at'   => now(),
        ]);

        $booking->unit->update(['status' => 'available']);
    });


        RoomBooking::where('status', BookingStatus::Confirmed->value)
            ->where('expires_at', '<', now())
            ->whereDoesntHave('contract')
            ->get()
            ->each(function ($booking) {
                $booking->update([
                    'status'         => BookingStatus::Expired->value,
                    'expired_reason' => 'no_contract_signed',
                    'cancelled_at'   => now(),
                ]);

                $booking->unit->update(['status' => 'available']);
            });
    }

    // ✅ عرض التفاصيل
    public function show(RoomBooking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }
}
