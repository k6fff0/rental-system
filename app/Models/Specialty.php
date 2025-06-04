<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_main', 'parent_id'];

    // 🔁 علاقات التخصصات
    public function parent()
    {
        return $this->belongsTo(Specialty::class, 'parent_id');
    }

    public function subSpecialties()
    {
        return $this->hasMany(Specialty::class, 'parent_id');
    }

    // 🧑‍🔧 فنيين مرتبطين بتخصص رئيسي
    public function technicians()
    {
        return $this->hasMany(User::class, 'main_specialty_id');
    }

    // 🧠 سكوبات
    public function scopeMain($query)
    {
        return $query->where('is_main', 1)->whereNull('parent_id');
    }

    public function scopeSubtasks($query)
    {
        return $query->where('is_main', 0)->whereNotNull('parent_id');
    }

    // ℹ️ دوال مساعدة
    public function isMain()
    {
        return $this->is_main && is_null($this->parent_id);
    }

    public function isSubtask()
    {
        return !$this->is_main && !is_null($this->parent_id);
    }
}
