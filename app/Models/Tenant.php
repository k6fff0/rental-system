<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'user_id',
        'uuid',
        'name',
        'phone',
		'phone_secondary',
		'is_whatsapp',
        'id_number',
        'type',
        'family_type',
        'email',
        'move_in_date',
        'notes',
        'debt',
        'tenant_status',
        'id_front',
        'id_back',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'debt' => 'decimal:2',
    ];

    public const STATUSES = [
        'active',
        'late_payer',
        'has_debt',
        'absent',
        'abroad',
        'legal_issue',
		'blocked',
    ];

    /**
     * علاقة المستأجر بالوحدة (قديمة - لم تعد مستخدمة في حالة العقود الديناميكية)
     */
    public function unit()
    {
        return $this->hasOneThrough(Unit::class, Contract::class, 'tenant_id', 'id', 'id', 'unit_id')
                    ->where('contracts.status', 'active')
                    ->latest('start_date');
    }

    /**
     * أحدث عقد نشط
     */
    public function latestContract()
    {
        return $this->hasOne(Contract::class)
                    ->where('contracts.status', 'active')
                    ->latestOfMany('start_date');
    }

    /**
     * كل العقود
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * الحساب المرتبط
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الوحدات الإضافية المرتبطة بالمستأجر
     */
    public function additionalUnits()
    {
        return $this->belongsToMany(Unit::class, 'tenant_unit');
    }

    /**
     * العقود النشطة الحالية
     */
    public function activeContracts()
    {
        return $this->hasMany(Contract::class)
                    ->where('contracts.status', 'active')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
    }
	
	
}
