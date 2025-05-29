<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\admin\PaymentController;
//use App\Http\Controllers\MaintenanceWorkerController;
use App\Http\Controllers\Admin\MaintenanceRequestController;
use App\Http\Controllers\ExpenseController;
//use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleManagerController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\PdfTestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BuildingUtilityController;
use App\Http\Controllers\Admin\BuildingSupervisorController;
use App\Http\Controllers\Admin\RoomBookingController;



use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::get('lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    App::setLocale($lang);
    $redirectTo = request('redirect') ?? url()->previous() ?? '/';
    return Redirect::to($redirectTo);
})->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/admin', '/admin/dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/buildings/{building}/available-units', [\App\Http\Controllers\ContractController::class, 'getAvailableUnits']);
    Route::get('/api/tenants/search', [\App\Http\Controllers\TenantController::class, 'search']);

    Route::get('contracts/{contract}/print', [\App\Http\Controllers\ContractController::class, 'print'])
        ->name('contracts.print');

    Route::resource('building-utilities', BuildingUtilityController::class);
    Route::post('building-utilities/{utility}/delete-image', [BuildingUtilityController::class, 'deleteImage'])->name('building-utilities.image.delete');

    // ✅ الفنيين
    Route::get('technicians', [TechnicianController::class, 'index'])->name('technicians.index');
    Route::get('technicians/{id}', [TechnicianController::class, 'show'])->name('technicians.show');
    Route::get('technicians/{id}/edit', [\App\Http\Controllers\Admin\TechnicianController::class, 'edit'])->name('technicians.edit');
    Route::put('technicians/{id}', [\App\Http\Controllers\Admin\TechnicianController::class, 'update'])->name('technicians.update');

    // ✅ API للمستأجر
    Route::get('/api/tenant/{id}', [TenantController::class, 'getTenantData']);

    // ✅ API للوحدات حسب المبنى
    Route::get('/api/units-by-building/{building}', [ContractController::class, 'getUnitsByBuilding']);

    // ✅ المباني والوحدات
    Route::resource('buildings', BuildingController::class);
    Route::resource('units', UnitController::class);
    Route::patch('units/{unit}/status', [UnitController::class, 'updateStatus'])->name('units.updateStatus');
    Route::get('buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show');
    Route::get('units/{unit}', [UnitController::class, 'show'])->name('units.show');
    Route::get('/available-units', [UnitController::class, 'available'])->name('units.available');


    // ✅ المستأجرين
    Route::resource('tenants', TenantController::class);
    Route::patch('tenants/{tenant}/unlink-unit', [TenantController::class, 'unlinkUnit'])->name('tenants.unlink-unit');
    Route::get('tenants/{tenant}/link-user', [TenantController::class, 'linkUser'])->name('tenants.link-user');
    Route::post('tenants/{tenant}/attach-user', [TenantController::class, 'attachUser'])->name('tenants.attach-user');
    Route::post('tenants/{tenant}/create-user', [TenantController::class, 'createUser'])->name('tenants.create-user');

    // ✅ العقود والدفع والصيانة
    Route::resource('contracts', ContractController::class);
    Route::patch('contracts/{contract}/end', [ContractController::class, 'end'])->name('contracts.end');
    //Route::resource('payments', PaymentController::class);
    //Route::resource('maintenance-workers', MaintenanceWorkerController::class);
    Route::resource('maintenance-requests', MaintenanceRequestController::class)->names('maintenance_requests');
    Route::put('maintenance-requests/{id}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance_requests.update_status');
    Route::patch('/admin/contracts/{contract}/end', [ContractController::class, 'end'])->name('admin.contracts.end');


    // ✅ المصروفات والمخزون
    Route::resource('expenses', ExpenseController::class);
    //Route::resource('inventory-items', InventoryItemController::class);

    // ✅ المستخدمين والصلاحيات
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // ✅ إدارة المجموعات
    Route::get('/role-manager', [RoleManagerController::class, 'index'])->name('role_manager.index');
    Route::post('/role-manager', [RoleManagerController::class, 'store'])->name('role_manager.store');
    Route::get('/role-manager/{role}/edit', [RoleManagerController::class, 'edit'])->name('role_manager.edit');
    Route::put('/role-manager/{role}', [RoleManagerController::class, 'update'])->name('role_manager.update');
    Route::delete('/role-manager/{role}', [RoleManagerController::class, 'destroy'])->name('role_manager.destroy');

    // ✅ اختبار PDF
    Route::get('/test-pdf', [PdfTestController::class, 'testPdf']);

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





    //clear log
    Route::post('/logs/clear', function () {
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            file_put_contents($logPath, ''); // امسح محتوى اللوج
        }
        return back()->with('success', '🧹 تم مسح سجلات النظام بنجاح!');
    })->name('logs.clear');

    // download log
    Route::get('/logs/download', function () {
        $logPath = storage_path('logs/laravel.log');

        if (!file_exists($logPath)) {
            return back()->with('error', '❌ لا يوجد ملف سجلات حاليًا.');
        }

        return response()->download($logPath, 'laravel-log-' . now()->format('Y-m-d_H-i-s') . '.log');
    })->name('logs.download');

    // settings.maintenance
    Route::post('/settings/maintenance', function () {
        $value = request()->has('maintenance_mode') ? true : false;

        // مثال لو بتستخدم config أو جدول Settings مخصص
        if (function_exists('settings')) {
            settings()->set('maintenance_mode', $value);
            settings()->save();
        }

        // ممكن كمان تشغل مود الصيانة بتاع لارافيل نفسه:
        if ($value) {
            Artisan::call('down');
        } else {
            Artisan::call('up');
        }

        return back()->with('success', '✅ تم تحديث وضع الصيانة.');
    })->name('settings.maintenance');

    // cache.clear
    Route::post('/settings/cache-clear', function () {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            return back()->with('success', '✅ تم تنظيف الكاش بالكامل.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل تنظيف الكاش: ' . $e->getMessage());
        }
    })->name('cache.clear');

    // database.optimize
    Route::post('/settings/optimize-database', function () {
        try {
            // تحسين لكل الجداول في قاعدة البيانات الحالية
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableKey = "Tables_in_$dbName";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                DB::statement("OPTIMIZE TABLE `$tableName`");
            }

            return back()->with('success', '✅ تم تحسين قاعدة البيانات بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في تحسين قاعدة البيانات: ' . $e->getMessage());
        }
    })->name('database.optimize');

    // queue.restart

    Route::post('/settings/queue-restart', function () {
        try {
            Artisan::call('queue:restart');
            return back()->with('success', '🔄 تم إعادة تشغيل الـ Queue Workers بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في إعادة تشغيل الـ Queue: ' . $e->getMessage());
        }
    })->name('queue.restart');
});


// ✅ بروفايل المستخدم
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:super-admin'])->group(function () {
    Route::get('/admin/system-owner', [\App\Http\Controllers\Admin\SystemOwnerController::class, 'index'])
        ->name('admin.system.owner');
});

// تمييز الإشعارات كمقروء
Route::post('/notifications/mark-all-read', function () {
    auth()->user()?->unreadNotifications->markAsRead();
    return back();
})->name('notifications.markAllRead');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/payments/due-report', [\App\Http\Controllers\Admin\PaymentController::class, 'monthlyDueReport'])->name('admin.payments.due_report');
    Route::get('/payments/due-report/export-excel', [\App\Http\Controllers\Admin\PaymentController::class, 'exportExcel'])->name('admin.payments.export_excel');
    Route::get('/payments/due-report/export-pdf', [\App\Http\Controllers\Admin\PaymentController::class, 'exportPDF'])->name('admin.payments.export_pdf');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
    // صفحة جميع اللوجات
    Route::get('/payment-logs/all', [PaymentController::class, 'logsIndex'])->name('admin.payments.logs.all');
    // زر العين بجانب كل دفعة
    Route::get('/payments/{payment}/logs', [PaymentController::class, 'logs'])->name('admin.payments.logs.single');

    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->names('admin.payments');
});

Route::prefix('admin/building-supervisors')
    ->name('admin.building-supervisors.')
    ->middleware(['auth:web'])
    ->group(function () {
        Route::get('/', [BuildingSupervisorController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [BuildingSupervisorController::class, 'edit'])->name('edit');
        Route::put('/{user}', [BuildingSupervisorController::class, 'update'])->name('update');
    });

//room images 
Route::get('units/{unit}/images', [UnitController::class, 'images'])->name('admin.units.images');
Route::post('units/{unit}/images', [UnitController::class, 'uploadImage'])->name('admin.units.images.upload');
Route::delete('units/images/{image}', [UnitController::class, 'deleteImage'])->name('admin.units.images.delete');

// booking 
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/bookings', [RoomBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/create', [RoomBookingController::class, 'create'])->name('admin.bookings.create');
    Route::post('/bookings', [RoomBookingController::class, 'store'])->name('admin.bookings.store');
    Route::patch('/bookings/{booking}/cancel', [RoomBookingController::class, 'cancel'])->name('admin.bookings.cancel');
});
// notifications
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('admin.notifications.show');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});



require __DIR__ . '/auth.php';
