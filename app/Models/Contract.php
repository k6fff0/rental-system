<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Contract extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'rent_amount',
        'contract_file',
        'contract_image',
        'notes',
        'status',
        'contract_number',
    ];

    /**
     * تحويل الحقول لتواريخ تلقائياً
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];


    /**
     * توليد رقم العقد تلقائياً
     */
    protected static function booted()
    {
        static::creating(function ($contract) {
            $lastId = self::max('id') + 1;
            $contract->contract_number = 'C-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        });
    }
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    /**
     * علاقة العقد بالمستأجر
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }


    /**
     * علاقة العقد بالوحدة
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    public function getVisualStatusAttribute(): string
    {
        if ($this->status !== 'active') {
            return $this->status;
        }

        if (now()->gt($this->end_date)) {
            return 'expired';
        }

        if (now()->diffInDays($this->end_date) <= 30) {
            return 'expiring';
        }

        return 'active';
    }
    public function getFormattedDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        $start = \Carbon\Carbon::parse($this->start_date);
        $end = \Carbon\Carbon::parse($this->end_date);

        $diff = $start->diff($end);

        $months = $diff->m + ($diff->y * 12); // عدد الشهور الكلي
        $days = $diff->d; // باقي الأيام

        $output = '';

        if ($months > 0) {
            $output .= $months . ' ' . __('messages.months');
        }

        if ($days > 0) {
            $output .= ($months > 0 ? ' ' : '') . $days . ' ' . __('messages.days');
        }

        return $output ?: __('messages.no_duration');
    }
    public function getDaysRemainingTextAttribute()
    {
        if (!$this->end_date) {
            return __('messages.no_duration');
        }

        $now = \Carbon\Carbon::now();
        $end = \Carbon\Carbon::parse($this->end_date);

        if ($end->isPast()) {
            return __('messages.expired');
        }

        $daysLeft = $now->diffInDays($end, false);
        return __('messages.remaining_in', ['days' => $daysLeft]);
    }
}
