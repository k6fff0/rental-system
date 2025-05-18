<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public $timestamps = false; // لو جدولك مفيهوش created_at و updated_at

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // ✅ اسم مترجم جاهز للاستخدام في الواجهات
    public function getTranslatedNameAttribute()
    {
        return __('maintenance_categories.' . $this->slug);
    }
}
