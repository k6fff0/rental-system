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
    use HasFactory, Notifiable;

    use HasRoles {
        HasRoles::hasRole as protected traitHasRole;
        HasRoles::hasAnyRole as protected traitHasAnyRole;
    }

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    public function mainSpecialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'main_specialty_id');
    }

    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(Building::class)->withTimestamps();
    }
	
	

    public function assignedMaintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_worker_id');
    }

    public function technicianRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_worker_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function violations(): HasMany
    {
        return $this->hasMany(Violation::class);
    }

public function technicianZones(): BelongsToMany
{
    return $this->belongsToMany(Zone::class, 'technician_zone', 'user_id', 'zone_id');
}

public function supervisedZones(): HasMany
{
    return $this->hasMany(Zone::class, 'supervisor_id');
}


    /*
    |--------------------------------------------------------------------------
    | 🔍 سكوبات
    |--------------------------------------------------------------------------
    */

    public function scopeTechnicians($query)
    {
        return $query->role('technician');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔧 دوال منطق النظام
    |--------------------------------------------------------------------------
    */

    public function isSuperAdmin(): bool
    {
        return $this->email === config('app.super_admin_email');
    }

    public function hasRole($roles, $guard = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->traitHasRole($roles, $guard);
    }

    public function hasAnyRole($roles, $guard = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->traitHasAnyRole($roles, $guard);
    }

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

    public function getPhotoUrlAttribute($value)
    {
        if ($value && file_exists(public_path('storage/' . $value))) {
            return asset('storage/' . $value);
        }

        return asset('images/default-user.png');
    }

    public function syncRolesAndDetachBuildings(array|string $roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];

        $hadSupervisorRole = $this->hasRole('Building Supervisor');

        // نفّذ التعديل الفعلي
        $this->syncRoles($roles);

        // لو اتشال منه الدور بعد التعديل → افصل المباني
        if ($hadSupervisorRole && !in_array('Building Supervisor', $roles)) {
            $this->buildings()->detach();
        }
    }
}
