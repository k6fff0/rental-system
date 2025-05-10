<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'number_of_units', // لو العمود موجود فعلاً
        'owner_name',
        'owner_nationality',
        'owner_id_number',
        'owner_phone',
        'municipality_number',
        'rent_amount',
        'initial_renovation_cost',
        'electric_meters',
        'internet_lines',
    ];

    protected $casts = [
        'electric_meters' => 'array',
        'internet_lines' => 'array',
    ];

    // علاقة المبنى بالوحدات
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
