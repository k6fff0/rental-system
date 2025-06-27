<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\Admin\MaintenanceRequestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleManagerController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\PdfTestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BuildingUtilityController;
use App\Http\Controllers\Admin\BuildingSupervisorController;
use App\Http\Controllers\Admin\RoomBookingController;
use App\Http\Controllers\Admin\SystemOwnerController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ComplaintController;
use App\Settings\SystemSettings;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\ZoneController;




//راوت اللغه 
Route::get('lang/{lang}', function ($lang) {
    $availableLocales = ['en', 'ar', 'ur'];

    if (in_array($lang, $availableLocales)) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }

    $redirectTo = request('redirect') ?? url()->previous() ?? '/';
    return Redirect::to($redirectTo);
})->name('lang.switch');

//الرئيسيه
Route::get('/', function () {
    return view('welcome');
});

// الغرف المتاحه بدون تسجيل دخول
Route::get('/available-units', [UnitController::class, 'available'])->name('units.available');



// ✅ إعادة التوجيه من /admin إلى /admin/dashboard
Route::redirect('/admin', '/admin/dashboard');

// ✅ مجموعة الـ admin routes
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ✅ لوحة التحكم
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ✅ API
        Route::prefix('api')->group(function () {
            Route::get('/buildings/{building}/available-units', [\App\Http\Controllers\ContractController::class, 'getAvailableUnits'])->name('api.buildings.available_units');
            Route::get('/tenants/search', [\App\Http\Controllers\TenantController::class, 'search'])->name('api.tenants.search');
            Route::get('/tenant/{id}', [\App\Http\Controllers\TenantController::class, 'getTenantData'])->name('api.tenant.data');
            Route::get('/units-by-building/{building}', [\App\Http\Controllers\ContractController::class, 'getUnitsByBuilding'])->name('api.units.by_building');
        });

        // ✅ المباني والوحدات والمرافق والمناطق
        Route::resource('buildings', BuildingController::class);
        Route::resource('units', UnitController::class);
        Route::resource('building-utilities', BuildingUtilityController::class);
		Route::resource('zones', ZoneController::class);

        // ✅ عمليات إضافية على المباني
        Route::patch('buildings/{building}/toggle-families-only', [BuildingController::class, 'toggleFamiliesOnly'])
            ->name('buildings.toggleFamiliesOnly')
            ->middleware('can:edit buildings');
        Route::delete('buildings/{building}/image', [BuildingController::class, 'deleteImage'])->name('buildings.deleteImage');
        Route::get('buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show');

        // ✅ عمليات إضافية على الوحدات
        Route::patch('units/{unit}/status', [UnitController::class, 'updateStatus'])->name('units.updateStatus');
        Route::get('units/{unit}', [UnitController::class, 'show'])->name('units.show');
        Route::get('units/search', [UnitController::class, 'search'])->name('units.search');
        Route::get('units-available-text', [UnitController::class, 'availableText'])->name('units.available.text');

        // ✅ building-utilities إضافية
        Route::delete('building-utilities/{id}/delete-image', [BuildingUtilityController::class, 'deleteImage'])->name('building-utilities.image.delete');

        // ✅ العقود
        Route::get('contracts/{contract}/print', [\App\Http\Controllers\ContractController::class, 'print'])->name('contracts.print');

        // ✅ المستخدمين
        Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active')
            ->middleware('permission:edit users');



    // الفنيين والتخصصات
    Route::prefix('technicians')->name('technicians.')->group(function () {
        Route::get('/specialties', [TechnicianController::class, 'specialtiesIndex'])->name('specialties.index');
        Route::get('/specialties/create', [TechnicianController::class, 'createSpecialty'])->name('specialties.create');
        Route::post('/specialties', [TechnicianController::class, 'storeSpecialty'])->name('specialties.store');
        Route::get('/specialties/{id}/edit', [TechnicianController::class, 'editSpecialty'])->name('specialties.edit');
        Route::put('/specialties/{id}', [TechnicianController::class, 'updateSpecialty'])->name('specialties.update');
        Route::delete('/specialties/{id}', [TechnicianController::class, 'destroySpecialty'])->name('specialties.destroy');
        Route::get('{id}/report', [TechnicianController::class, 'report'])->name('report');
        Route::get('/', [TechnicianController::class, 'index'])->name('index');
        Route::get('/{id}', [TechnicianController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [TechnicianController::class, 'edit'])->name('edit');
        Route::put('/{user}', [TechnicianController::class, 'update'])->name('update');
    });
    Route::get('/technician/maintenance', [MaintenanceRequestController::class, 'myRequests'])
        ->name('technician.maintenance')
        ->middleware('auth'); 
    Route::get('/maintenance/{request}', [MaintenanceRequestController::class, 'show'])->name('admin.maintenance.show');



    // ✅ المستأجرين
    Route::resource('tenants', TenantController::class);
    Route::patch('tenants/{tenant}/unlink-unit', [TenantController::class, 'unlinkUnit'])->name('tenants.unlink-unit');
    Route::get('tenants/{tenant}/link-user', [TenantController::class, 'linkUser'])->name('tenants.link-user');
    Route::post('tenants/{tenant}/attach-user', [TenantController::class, 'attachUser'])->name('tenants.attach-user');
    Route::post('tenants/{tenant}/create-user', [TenantController::class, 'createUser'])->name('tenants.create-user');



    //الصيانه
	Route::resource('maintenance-requests', MaintenanceRequestController::class)->names('maintenance_requests');
    Route::get('admin/maintenance-requests/archive', [MaintenanceRequestController::class, 'archive'])->name('maintenance_requests.archive');
    Route::get('maintenance-requests/archive/export/pdf', [MaintenanceRequestController::class, 'exportPdf'])->name('maintenance_requests.exportPdf');
    Route::get('maintenance-requests/archive/export/excel', [MaintenanceRequestController::class, 'exportExcel'])->name('maintenance_requests.exportExcel');
    Route::get('technicians/search', [TechnicianController::class, 'search'])->name('technicians.search');   
    Route::put('maintenance-requests/{id}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance_requests.update_status');


    // العقود
    Route::resource('contracts', ContractController::class);
    Route::patch('contracts/{contract}/end', [ContractController::class, 'end'])->name('contracts.end');       
    Route::patch('/admin/contracts/{contract}/end', [ContractController::class, 'end'])->name('admin.contracts.end');


    // المصروفات
    Route::resource('expenses', ExpenseController::class);

    // ✅ المستخدمين والصلاحيات
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);


    // ✅ إدارة المجموعات
    Route::resource('role-manager', RoleManagerController::class)->names('role_manager')->parameters(['role-manager' => 'role'])->except(['show', 'create']);


    // ✅ الإشعارات
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // packup 
    Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::post('/backup/download', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/clean', [BackupController::class, 'clean'])->name('backup.clean');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');

    // Edit Settings
    Route::get('/settings/edit', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');

    //tlggle 
    Route::post('/contracts/{key}/toggle', [\App\Http\Controllers\ContractController::class, 'toggleStatus'])->name('contracts.toggle');

    //settings.update
    Route::post('/update', [SettingController::class, 'update'])->name('settings.update');
	

}); // نهايه روتات الادمن 


/// صفحة المالك 
Route::middleware(['auth', 'permission:super-admin'])->group(function () {Route::get('/admin/system-owner', [SystemOwnerController::class, 'index'])->name('admin.system.owner');});
	Route::prefix('admin')->name('admin.')->middleware(['auth', 'permission:super-admin'])->group(function () {
    Route::get('/system-owner', [SystemOwnerController::class, 'index'])->name('system.owner');
    Route::post('/system-owner/logs/clear', [SystemOwnerController::class, 'clearLog'])->name('logs.clear');
    Route::get('/system-owner/logs/download', [SystemOwnerController::class, 'downloadLog'])->name('logs.download');
    Route::post('/system-owner/settings/maintenance', [SystemOwnerController::class, 'toggleMaintenance'])->name('settings.maintenance');
    Route::post('/system-owner/settings/cache-clear', [SystemOwnerController::class, 'clearCache'])->name('cache.clear');
    Route::post('/system-owner/settings/optimize-database', [SystemOwnerController::class, 'optimizeDatabase'])->name('database.optimize');
    Route::post('/system-owner/settings/queue-restart', [SystemOwnerController::class, 'restartQueue'])->name('queue.restart');
});


// ✅ بروفايل المستخدم
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// المدفوعات 
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/payments/due-report', [PaymentController::class, 'monthlyDueReport'])->name('admin.payments.due_report');
    Route::get('/payments/due-report/export-excel', [PaymentController::class, 'exportExcel'])->name('admin.payments.export_excel');
    Route::get('/payments/due-report/export-pdf', [PaymentController::class, 'exportPDF'])->name('admin.payments.export_pdf');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
    Route::get('/payment-logs/all', [PaymentController::class, 'logsIndex'])->name('admin.payments.logs.all');
    Route::get('/payments/{payment}/logs', [PaymentController::class, 'logs'])->name('admin.payments.logs.single');
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->names('admin.payments');
});


//مشرفين المباني 
Route::prefix('admin/building-supervisors')->name('admin.building-supervisors.')->middleware(['auth:web'])->group(function () {
        Route::get('/', [BuildingSupervisorController::class, 'index'])->name('index');
        Route::get('/{user}', [BuildingSupervisorController::class, 'show'])->name('show'); 
        Route::get('/{user}/edit', [BuildingSupervisorController::class, 'edit'])->name('edit');
        Route::put('/{user}', [BuildingSupervisorController::class, 'update'])->name('update');
    });


    //cleaningDashboard 
    Route::get('cleaning-dashboard', [UnitController::class, 'cleaningDashboard'])->name('admin.cleaning.dashboard');
    Route::post('units/{unit}/mark-cleaned', [UnitController::class, 'markAsCleaned'])->name('admin.units.mark.cleaned');
    Route::post('units/{unit}/upload-image', [UnitController::class, 'uploadImage'])->name('admin.units.images.upload');
    Route::delete('units/images/{image}', [UnitController::class, 'deleteImage'])->name('admin.units.images.delete');


//خاص بصفحة الفنيين الخارجيه
Route::prefix('technician/maintenance')->middleware('auth') ->name('maintenance.')->group(function () {
        Route::post('/{id}/start', [MaintenanceRequestController::class, 'start'])->whereNumber('id')->name('start');
        Route::post('/{id}/complete', [MaintenanceRequestController::class, 'complete'])->whereNumber('id')->name('complete');
        Route::post('/{id}/reject', [MaintenanceRequestController::class, 'reject'])->whereNumber('id')->name('reject');
        Route::post('/{id}/delay', [MaintenanceRequestController::class, 'updateStatus'])->name('delay');
    });


//السيارات 
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::get('/admin/vehicles/reports', [VehicleController::class, 'reports'])->name('vehicles.reports');
    Route::get('vehicles/reports/pdf', [VehicleController::class, 'exportPdf'])->name('vehicles.reports.pdf');
    Route::get('vehicles/reports/excel', [VehicleController::class, 'exportExcel'])->name('vehicles.reports.excel');
    Route::post('vehicles/{vehicle}/expenses', [VehicleController::class, 'storeExpense'])->name('vehicles.expenses.store');
    Route::delete('vehicles/expenses/{expense}', [VehicleController::class, 'destroyExpense'])->name('vehicles.expenses.destroy');
    Route::post('vehicles/{vehicle}/violations', [VehicleController::class, 'storeViolation'])->name('vehicles.violations.store');
    Route::delete('vehicles/violations/{violation}', [VehicleController::class, 'destroyViolation'])->name('vehicles.violations.destroy');
});



// booking 
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('bookings', RoomBookingController::class)->only(['index', 'create', 'store', 'show'])->names('bookings');
    Route::patch('bookings/{booking}/cancel', [RoomBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/confirm', [RoomBookingController::class, 'confirm'])->name('bookings.confirm');
});


// notifications
Route::post('/notifications/mark-all-read', function () {$user = Auth::user();if ($user) {$user->unreadNotifications->markAsRead();}return back();})->middleware('auth')->name('notifications.markAllRead');
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('admin.notifications.show');
});


//الشكاوي
Route::post('complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/complaints', [ComplaintController::class, 'index'])->middleware('auth')->name('admin.complaints');



require __DIR__ . '/auth.php';
