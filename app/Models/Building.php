<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'name',
        'building_number',
        'address',
        'location_url',
        'image', 
        'owner_name',
        'owner_nationality',
        'owner_id_number',
        'owner_phone',
        'municipality_number',
        'rent_amount',
        'initial_renovation_cost',
        'families_only', 
    ];



    protected $casts = [
        'electric_meters' => 'array',
        'internet_lines'  => 'array',
    ];

    protected static function booted()
    {
        static::deleting(function ($building) {
            foreach ($building->units as $unit) {
                $unit->contracts()->delete(); // حذف العقود المرتبطة بالغرفة
                $unit->delete(); // حذف الغرفة
            }
        });
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function utilities()
    {
        return $this->hasMany(BuildingUtility::class);
    }
	
	
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
	
	
    public function expenses()
    {
        return $this->morphMany(Expense::class, 'expensable');
    }
	
	
}
