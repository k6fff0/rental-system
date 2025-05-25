<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'unit_number',
        'floor',
        'unit_type',
        'status',
        'notes',
        'rent_price',
    ];

      // ✅ العلاقة مع المبنى
     public function building()
    {
        return $this->belongsTo(Building::class);
    }
	   // ✅ العلاقة مع العقود
	public function contracts()
    {
       return $this->hasMany(\App\Models\Contract::class);
    }


      // ✅ العلاقه مع اخر عقد
    public function latestContract()
    {
        return $this->hasOne(Contract::class)->latestOfMany('start_date'); 
    }

    // ✅ accessor لحالة الغرفة
    public function getStatusLabelAttribute()
    {
        return $this->status;
    }
	
    public function latestTenant()
   {
       return $this->latestContract?->tenant;
   }

}
