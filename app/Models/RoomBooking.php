<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
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
        return $this->status === 'expired' || now()->gt($this->end_date);
    }

    // ✅ هل يمكن إلغاؤه؟
    public function isCancelableBy($user)
    {
        return $this->user_id === $user->id || $user->hasRole('admin');
    }
}
