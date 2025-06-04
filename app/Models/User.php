<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // 🧾 الحقول القابلة للتعبئة
   protected $fillable = [
    'name',
    'email',
    'phone',
    'preferred_language',
    'technician_status',
    'department',
    'notes',
    'photo_url',
    'password',
];

    // 🔒 الحقول المخفية من JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔁 تحويل أنواع الحقول
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 👥 العلاقات
    |--------------------------------------------------------------------------
    */

    // 🔗 علاقة المستأجر (لو يوزر ساكن)
    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    // 🔗 التخصص الرئيسي للفني
    public function mainSpecialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'main_specialty_id');
    }

    // 🔗 المباني اللي مرتبط بيها
    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(Building::class)->withTimestamps();
    }

    // 🔗 الطلبات المسندة لهذا الفني
    public function assignedMaintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_worker_id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔍 سكوبات واستعلامات مخصصة
    |--------------------------------------------------------------------------
    */

    // 🔍 سكوب لفلترة الفنيين
    public function scopeTechnicians($query)
    {
        return $query->role('technician');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔧 دوال منطق السيستم للفنيين
    |--------------------------------------------------------------------------
    */

    // ✅ هل هو سوبر أدمن؟
    public function isSuperAdmin(): bool
    {
        return $this->email === config('app.super_admin_email');
    }

    // ✅ تحديث حالة الفني إلى busy لو عدد الطلبات النشطة 10 أو أكثر
    public function updateTechnicianBusyStatus(): void
    {
        if ($this->user_type !== 'technician') return;

        $activeOrders = $this->assignedMaintenanceRequests()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        if ($this->technician_status === 'available' && $activeOrders >= 10) {
            $this->technician_status = 'busy';
            $this->save();
        }
    }

    // ✅ إعادة حالة الفني إلى available لو الطلبات قلت عن 10
    public function recalculateTechnicianStatus(): void
    {
        if ($this->user_type !== 'technician') return;

        $activeOrders = $this->assignedMaintenanceRequests()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        if ($this->technician_status === 'busy' && $activeOrders < 10) {
            $this->technician_status = 'available';
            $this->save();
        }
    }
}
