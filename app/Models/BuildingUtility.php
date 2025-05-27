<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuildingUtility extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'type',
        'value',
        'owner_name',
        'owner_id_number',
        'owner_id_image',
        'notes',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // ✅ Optional: ترجمة النوع
    public function getTypeLabelAttribute()
    {
        return __('building_utilities.' . $this->type);
    }
}
