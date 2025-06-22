<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'amount',
        'payment_date',
        'month_for',
        'payer_id',
        'method',
        'notes',
        'collector_id',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'month_for' => 'date:Y-m-d',
    ];

    /**
     * علاقة الدفع بالعقد
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * علاقة الدفع بالمستأجر (عبر العقد)
     */
    public function tenant()
    {
        return $this->hasOneThrough(Tenant::class, Contract::class, 'id', 'id', 'contract_id', 'tenant_id');
    }

    /**
     * المستخدم الذي سجّل الدفعة
     */
    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\PaymentLog::class);
    }
}
