<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceWorkerController;
use App\Http\Controllers\Admin\MaintenanceRequestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleManagerController;
use App\Http\Controllers\Admin\NotificationController;

// ✅ كود مؤقت لاختبار اللغة - امسحه بعدين
Route::get('/اختبار-اللغة', function () {
    $current = app()->getLocale();
    $session = session('locale');
    return "<h1>app() = $current | session() = $session</h1>";
});
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// ✅ الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// ✅ تحويل مباشر إلى لوحة تحكم الأدمن
Route::redirect('/admin', '/admin/dashboard');

// ✅ روتات لوحة تحكم الأدمن
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('buildings', BuildingController::class);
    Route::resource('units', UnitController::class);
    Route::patch('units/{unit}/status', [UnitController::class, 'updateStatus'])->name('units.updateStatus');

    Route::resource('tenants', TenantController::class);

    // ✅ العقود (Contracts)
    Route::resource('contracts', ContractController::class)->names('contracts');

    Route::resource('payments', PaymentController::class);
    Route::resource('maintenance-workers', MaintenanceWorkerController::class);
    Route::resource('maintenance-requests', MaintenanceRequestController::class)->names('maintenance_requests');
    Route::put('maintenance-requests/{id}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance_requests.update_status');
    Route::resource('expenses', ExpenseController::class);
    Route::resource('inventory-items', InventoryItemController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    // ✅ صفحة إدارة المجموعات (الصلاحيات)
    Route::get('/role-manager', [RoleManagerController::class, 'index'])->name('role_manager.index');
    Route::post('/role-manager', [RoleManagerController::class, 'store'])->name('role_manager.store');
    Route::get('/role-manager/{role}/edit', [RoleManagerController::class, 'edit'])->name('role_manager.edit');
    Route::put('/role-manager/{role}', [RoleManagerController::class, 'update'])->name('role_manager.update');
    Route::delete('/role-manager/{role}', [RoleManagerController::class, 'destroy'])->name('role_manager.destroy');

    // ✅ روتات ربط المستأجر بحساب مستخدم
    Route::get('tenants/{tenant}/link-user', [TenantController::class, 'linkUser'])->name('tenants.link-user');
    Route::post('tenants/{tenant}/attach-user', [TenantController::class, 'attachUser'])->name('tenants.attach-user');
    Route::post('tenants/{tenant}/create-user', [TenantController::class, 'createUser'])->name('tenants.create-user');
});

// ✅ روتات البروفايل
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ روت تغيير اللغة
Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['ar', 'en'])) {
        session(['locale' => $lang]);
    }
    return redirect()->route('admin.dashboard');
})->name('lang.switch');

// ✅ ملفات المصادقة
require __DIR__.'/auth.php';
