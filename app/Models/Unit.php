<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    // ✅ الحقول المسموح إدخالها
    protected $fillable = [
        'building_id',
        'unit_number',
        'floor',
        'type',
    ];

    // ✅ علاقة الوحدة بالمبنى (كل وحدة تتبع مبنى)
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
	public function contracts()
    {
    return $this->hasMany(Contract::class);
    }

}
