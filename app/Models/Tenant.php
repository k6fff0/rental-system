<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    // ✅ الأعمدة المسموح بملئها
    protected $fillable = [
        'unit_id',
        'name',
        'phone',
        'id_number',
        'email',
        'move_in_date',
        'notes',
        'user_id',
    ];

    // ✅ العلاقة مع الوحدة
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // ✅ العلاقة مع العقود
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // ✅ العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
