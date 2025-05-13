<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'amount',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
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
}
