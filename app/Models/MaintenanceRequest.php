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
        'type',
        'description',
        'image',
        'status',
        'assigned_worker_id',
        'start_notes',
        'end_notes',
        'note',
        'cost',
        'created_by',
    ];

    // 🔗 العلاقات
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function worker()
    {
        return $this->belongsTo(MaintenanceWorker::class, 'assigned_worker_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
