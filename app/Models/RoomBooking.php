<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\BookingStatus;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'user_id',
        'is_broker_booking',
        'tentative_at',
        'start_date',
        'end_date',
        'confirmed_at',
        'auto_expire_at',
        'expires_at',
        'cancelled_at',
        'deposit_paid',
        'status',
        'expired_reason',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
    'end_date' => 'datetime',
    'tentative_at' => 'datetime',
    'confirmed_at' => 'datetime',
    'auto_expire_at' => 'datetime',
    'expires_at' => 'datetime',
    'cancelled_at' => 'datetime',
        'status'     => BookingStatus::class,
    ];

    // 🔗 الغرفة المرتبطة بالحجز
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // 🔗 المستخدم اللي قام بالحجز
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ هل الحجز منتهي؟
    public function isExpired()
    {
        return $this->status === BookingStatus::Expired || now()->gt($this->end_date);
    }

    // ✅ هل يمكن إلغاؤه؟
    public function isCancelableBy($user)
    {
        return $this->user_id === $user->id || $user->hasRole('admin');
    }

   public function contract()
{
    return $this->hasOne(Contract::class, 'unit_id', 'unit_id');
}

}
