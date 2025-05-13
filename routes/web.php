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
use App\Http\Controllers\PdfTestController;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

Route::get('lang/{lang}', function ($lang) {
    // حفظ اللغة في السيشن
    Session::put('locale', $lang);
    App::setLocale($lang);

    // استخدم redirect من الرابط، أو ارجع على الصفحة السابقة، أو افتراضي "/"
    $redirectTo = request('redirect') ?? url()->previous() ?? '/';

    return Redirect::to($redirectTo);
})->name('lang.switch');



// ✅ الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});



// ✅ تحويل مباشر للوحة تحكم الأدمن
Route::redirect('/admin', '/admin/dashboard');

// ✅ روتات لوحة التحكم (admin)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // المباني والوحدات
    Route::resource('buildings', BuildingController::class);
    Route::resource('units', UnitController::class);
    Route::patch('units/{unit}/status', [UnitController::class, 'updateStatus'])->name('units.updateStatus');
	Route::get('/admin/buildings/{building}', [BuildingController::class, 'show'])->name('admin.buildings.show');


    // المستأجرين
    Route::resource('tenants', TenantController::class);
    Route::patch('tenants/{tenant}/unlink-unit', [TenantController::class, 'unlinkUnit'])->name('tenants.unlink-unit');
    Route::get('tenants/{tenant}/link-user', [TenantController::class, 'linkUser'])->name('tenants.link-user');
    Route::post('tenants/{tenant}/attach-user', [TenantController::class, 'attachUser'])->name('tenants.attach-user');
    Route::post('tenants/{tenant}/create-user', [TenantController::class, 'createUser'])->name('tenants.create-user');

    // العقود والدفع والصيانة
    Route::resource('contracts', ContractController::class)->names('contracts');
    Route::resource('payments', PaymentController::class);
    Route::resource('maintenance-workers', MaintenanceWorkerController::class);
    Route::resource('maintenance-requests', MaintenanceRequestController::class)->names('maintenance_requests');
    Route::put('maintenance-requests/{id}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance_requests.update_status');

    // المصروفات والمخزون
    Route::resource('expenses', ExpenseController::class);
    Route::resource('inventory-items', InventoryItemController::class);

    // المستخدمين والصلاحيات
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // إدارة المجموعات
    Route::get('/role-manager', [RoleManagerController::class, 'index'])->name('role_manager.index');
    Route::post('/role-manager', [RoleManagerController::class, 'store'])->name('role_manager.store');
    Route::get('/role-manager/{role}/edit', [RoleManagerController::class, 'edit'])->name('role_manager.edit');
    Route::put('/role-manager/{role}', [RoleManagerController::class, 'update'])->name('role_manager.update');
    Route::delete('/role-manager/{role}', [RoleManagerController::class, 'destroy'])->name('role_manager.destroy');
// ✅ العقود
Route::resource('contracts', ContractController::class)->names('contracts');
Route::patch('contracts/{contract}/end', [ContractController::class, 'end'])->name('contracts.end');
Route::get('tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
Route::get('/test-pdf', [PdfTestController::class, 'testPdf']);
Route::get('/admin/units', [UnitController::class, 'index'])->name('admin.units.index');




    // الإشعارات
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
});
Route::get('/api/units-by-building/{building}', function ($buildingId) {
    return \App\Models\Unit::where('building_id', $buildingId)->get(['id', 'unit_number']);
});


// ✅ روتات البروفايل
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ✅ ملفات تسجيل الدخول والتسجيل
require __DIR__.'/auth.php';
