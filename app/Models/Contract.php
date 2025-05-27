<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'notes',
		'status',
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
        return $this->belongsTo(\App\Models\Tenant::class);
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

}
