<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    protected $fillable = ['name', 'supervisor_id'];

    /*
    |--------------------------------------------------------------------------
    | 👥 العلاقات
    |--------------------------------------------------------------------------
    */

    /**
     * المباني التابعة للمنطقة
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    /**
     * الفنيين المرتبطين بالمنطقة (many-to-many)
     */
    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'technician_zone', 'zone_id', 'user_id');
    }

    /**
     * المشرف المسؤول عن المنطقة (one supervisor only)
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
