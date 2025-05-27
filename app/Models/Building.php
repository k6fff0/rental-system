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
        'address',
		'location_url',
        'number_of_units',       
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

    /**
     * تحويل بعض الحقول تلقائياً إلى Array عند القراءة
     */
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
    /**
     * علاقة المبنى بالوحدات
     * كل مبنى يحتوي على وحدات متعددة
     */
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


}
