<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Enums\UnitType;
use App\Enums\UnitStatus;


class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'unit_number',
        'floor',
        'unit_type',
        'status',
        'notes',
        'rent_price',
    ];

    // ✅ حماية تلقائية عند التعديل لمنع تغيير الحالة أثناء وجود عقد نشط
    protected static function booted()
    {
        static::updating(function ($unit) {
            $wasOccupied = $unit->getOriginal('status') === 'occupied';
            $nowNotOccupied = $unit->status !== 'occupied';

            if ($wasOccupied && $nowNotOccupied) {
                $activeContract = Contract::where('unit_id', $unit->id)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

                if ($activeContract) {
                    throw new \Exception('❌ لا يمكن تغيير حالة الوحدة لأنها مرتبطة بعقد رقم: ' . $activeContract->contract_number);
                }
            }
        });
    }

    // ✅ العلاقة مع المبنى
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
	// images
	public function images()
    {
    return $this->hasMany(UnitImage::class);
    }


    // ✅ العلاقة مع العقود
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // ✅ العلاقة مع آخر عقد
    public function latestContract()
    {
        return $this->hasOne(Contract::class)->latestOfMany('start_date');
    }

public function getStatusLabelAttribute()
{
    $contract = $this->latestContract;

    // لو فيه عقد غير مفسوخ
    if ($contract && $contract->status !== 'terminated') {
        return match ($contract->status) {
            'active', 'expiring_soon' => UnitStatus::OCCUPIED->value,
            'ended'                   => UnitStatus::EXPIRED_CONTRACT->value,
            default                   => $this->status,
        };
    }

    // مفيش عقد مرتبط أو مفسوخ → نرجع الحالة الأصلية
    return $this->status;
}


public function getCurrentRentPriceAttribute()
{
    $contract = $this->latestContract;

    if ($contract && $contract->status !== 'terminated') {
        return (float) $contract->rent_amount; // نرجع قيمة فعلية
    }

    return (float) $this->rent_price;
}



    // ✅ آخر مستأجر
    public function latestTenant()
    {
        return $this->latestContract?->tenant;
    }
	
	
	
public function activeContract()
{
    return $this->hasOne(Contract::class)
        ->where('status', 'active')
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now());
}
	
	
	public function latestActiveContract()
{
    return $this->hasOne(\App\Models\Contract::class)
                ->where('status', 'active')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->latestOfMany('start_date');
}


}
