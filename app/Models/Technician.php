<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',      // مثال لحقل رقم الهاتف
        'email',      // مثال لحقل الإيميل
        'specialty',  // تخصص الفني مثلاً: كهرباء، سباكة..
    ];

    /**
     * العلاقة مع طلبات الصيانة.
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
