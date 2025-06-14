<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
    'building_id',
    'unit_id',
    'tenant_id',
    'sub_specialty_id',
    'description',
    'image',
    'status',
    'assigned_worker_id',
    'technician_id',
    'start_notes',
    'end_notes',
    'note',
    'cost',
    'created_by',
    'assigned_manually',
    'extra_phone',       
    'is_whatsapp',      
	'delayed_at', 
];


   protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'in_progress_at' => 'datetime',
    'completed_at' => 'datetime',
    'rejected_at' => 'datetime',
	'delayed_at' => 'datetime',
    'is_whatsapp' => 'boolean', 
];


    // ... بقية العلاقات زي ما هي


    // 🔗 التخصص الفرعي (نوع العطل)
    public function subSpecialty()
    {
        return $this->belongsTo(Specialty::class, 'sub_specialty_id');
    }

    // 🔗 المبنى
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // 🔗 الوحدة
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // 🔗 المستأجر
    public function tenant()
{
    return $this->belongsTo(Tenant::class, 'tenant_id');
}


    // 🔗 الفني المعين
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_worker_id');
    }

    // 🔗 من قام بإنشاء البلاغ
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 🔎 لو عايز تجيب اسم التخصص الفرعي كـ slug
    public function getCategorySlugAttribute()
    {
        return $this->subSpecialty?->name ?? 'other';
    }
	public function inProgressBy()
{
    return $this->belongsTo(User::class, 'in_progress_by');
}

public function completedBy()
{
    return $this->belongsTo(User::class, 'completed_by');
}

public function rejectedBy()
{
    return $this->belongsTo(User::class, 'rejected_by');
}

public function delayedBy()
{
    return $this->belongsTo(User::class, 'delayed_by');
}


}
