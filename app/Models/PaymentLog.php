<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Payment;
use Illuminate\Database\Eloquent\SoftDeletes;



class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_id',
        'action',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class)->withTrashed();
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
