<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoomBooking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    return view('admin.bookings.index', compact('bookings'));
}


    // ✅ إنشاء حجز جديد
public function store(Request $request)
{
    $request->validate([
        'unit_id'     => 'required|exists:units,id',
        'start_date'  => 'required|date|after_or_equal:today',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'notes'       => 'nullable|string',
    ]);

    $unit = Unit::with('building')->findOrFail($request->unit_id);

    if (in_array($unit->status, ['occupied', 'booked'])) {
        return back()->withErrors(['unit_id' => 'هذه الغرفة غير متاحة حالياً.']);
    }

    RoomBooking::create([
        'unit_id'    => $unit->id,
        'user_id'    => auth()->id(),
        'start_date' => $request->start_date,
        'end_date'   => $request->end_date,
        'status'     => 'active',
        'notes'      => $request->notes,
    ]);

    $unit->update(['status' => 'booked']);

    // 👉 تجهيز نص الرسالة كـ string مباشر
    $unitNumber = $unit->unit_number ?? '-';
    $buildingName = $unit->building->name ?? '-';

    $message = "تم حجز الغرفة رقم {$unitNumber} في مبنى {$buildingName}";

    Notification::send(User::all(), new \App\Notifications\RoomBooked($message));

    return redirect()->route('admin.units.index')->with('success', 'تم حجز الغرفة بنجاح.');
}

public function create()
{
    // بنجيب الغرف اللي متاحه بس للحجز
    $units = \App\Models\Unit::with('building')
        ->where('status', 'available')
        ->get();

    return view('admin.bookings.create', compact('units'));
}


    // ✅ إلغاء حجز (من صاحبه أو إدارة)
    public function cancel(RoomBooking $booking)
    {
        $user = auth()->user();

       if ($booking->user_id !== $user->id && !$user->can('cancel bookings')) {
         abort(403, 'ليس لديك صلاحية إلغاء هذا الحجز.');
        }

        $booking->update(['status' => 'cancelled']);

        // رجع الغرفة متاحة إذا مفيش عقد
        if ($booking->unit->status === 'booked') {
            $booking->unit->update(['status' => 'available']);
        }

        return back()->with('success', 'تم إلغاء الحجز بنجاح.');
    }

    // ✅ دالة تستخدمها في Job لإنهاء الحجوزات المنتهية
    public function expireOldBookings()
    {
        $today = now()->toDateString();

        $expired = RoomBooking::where('status', 'active')
            ->whereDate('end_date', '<', $today)
            ->get();

        foreach ($expired as $booking) {
            $booking->update(['status' => 'expired']);

            // رجع الغرفة لو مش مرتبطة بعقد
            if ($booking->unit->status === 'booked') {
                $booking->unit->update(['status' => 'available']);
            }
        }
    }
}
