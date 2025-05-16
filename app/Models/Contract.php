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
    ];

    /**
     * تحويل الحقول لتواريخ تلقائياً
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

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
}
