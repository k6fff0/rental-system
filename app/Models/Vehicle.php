<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate_number',
        'brand',
		'model',
        'color',
        'user_id',
        'status',
        'photo',
        'notes',
		'license_expiry_date',
        'insurance_expiry_date',
    ];
	protected $casts = [
    'license_expiry_date' => 'date',
    'insurance_expiry_date' => 'date',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function expenses()
{
    return $this->morphMany(\App\Models\Expense::class, 'expensable');
}

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
	
	
}
