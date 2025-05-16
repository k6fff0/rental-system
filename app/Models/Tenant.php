<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'unit_id',
        'name',
        'phone',
        'id_number',
        'email',
        'move_in_date',
        'notes',
        'user_id',
        'debt',
        'tenant_status',
    ];
public const STATUSES = [
    'active',
    'late_payer',
    'has_debt',
    'absent',
    'abroad',
    'legal_issue',
];

    /**
     * علاقة المستأجر بالوحدة
     * المستأجر ينتمي إلى وحدة واحدة (أو null)
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * علاقة المستأجر بالعقود
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * علاقة المستأجر بالمستخدم (الحساب المرتبط)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
	public function additionalUnits()
{
    return $this->belongsToMany(Unit::class, 'tenant_unit');
}
}
