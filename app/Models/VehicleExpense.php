<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleExpense extends Model
{
    protected $fillable = [
        'vehicle_id',
        'expense_type',
        'cost',
        'date',
        'notes',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
