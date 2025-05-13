<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
