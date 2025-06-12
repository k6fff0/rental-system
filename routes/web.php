<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InstallController;
//use App\Http\Controllers\UnitImageController;
use App\Settings\SystemSettings;
use App\Http\Controllers\Admin\VehicleController;
use Illuminate\Support\Facades\Auth;




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


    //Route::delete('admin/unit-images/{id}', [UnitImageController::class, 'destroy'])->name('admin.units.delete_image');
    Route::delete('/building-utilities/{id}/delete-image', [BuildingUtilityController::class, 'deleteImage'])->name('building-utilities.image.delete');


    Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active')->middleware('permission:edit users');



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
    Route::patch('buildings/{building}/toggle-families-only', [BuildingController::class, 'toggleFamiliesOnly'])->name('buildings.toggleFamiliesOnly')->middleware('can:edit buildings');


    Route::prefix('technicians')->name('technicians.')->group(function () {

        // ✅ التخصصات أولاً
        Route::get('/specialties', [TechnicianController::class, 'specialtiesIndex'])->name('specialties.index');
        Route::get('/specialties/create', [TechnicianController::class, 'createSpecialty'])->name('specialties.create');
        Route::post('/specialties', [TechnicianController::class, 'storeSpecialty'])->name('specialties.store');
        Route::get('/specialties/{id}/edit', [TechnicianController::class, 'editSpecialty'])->name('specialties.edit');
        Route::put('/specialties/{id}', [TechnicianController::class, 'updateSpecialty'])->name('specialties.update');
        Route::delete('/specialties/{id}', [TechnicianController::class, 'destroySpecialty'])->name('specialties.destroy');

        // ✅ الفنيين بعد التخصصات
        Route::get('/', [TechnicianController::class, 'index'])->name('index');
        Route::get('/{id}', [TechnicianController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [TechnicianController::class, 'edit'])->name('edit');
        Route::put('/{user}', [TechnicianController::class, 'update'])->name('update');
    });
Route::get('/technician/maintenance', [MaintenanceRequestController::class, 'myRequests'])
    ->name('technician.maintenance')
    ->middleware('auth'); // أو middleware خاص بالفنيين لو عندك
Route::get('/maintenance/{request}', [MaintenanceRequestController::class, 'show'])->name('admin.maintenance.show');







    // ✅ المستأجرين
    Route::resource('tenants', TenantController::class);
    Route::patch('tenants/{tenant}/unlink-unit', [TenantController::class, 'unlinkUnit'])->name('tenants.unlink-unit');
    Route::get('tenants/{tenant}/link-user', [TenantController::class, 'linkUser'])->name('tenants.link-user');
    Route::post('tenants/{tenant}/attach-user', [TenantController::class, 'attachUser'])->name('tenants.attach-user');
    Route::post('tenants/{tenant}/create-user', [TenantController::class, 'createUser'])->name('tenants.create-user');




    Route::get('maintenance-requests/archive', [MaintenanceRequestController::class, 'archive'])->name('maintenance_requests.archive');
    Route::get('maintenance-requests/archive/export/pdf', [MaintenanceRequestController::class, 'exportPdf'])
        ->name('maintenance_requests.exportPdf');

    Route::get('maintenance-requests/archive/export/excel', [MaintenanceRequestController::class, 'exportExcel'])
        ->name('maintenance_requests.exportExcel');
    Route::get('units/search', [UnitController::class, 'search'])->name('units.search');
    Route::get('technicians/search', [TechnicianController::class, 'search'])->name('technicians.search');





    // ✅ العقود والدفع والصيانة
    Route::resource('contracts', ContractController::class);
    Route::patch('contracts/{contract}/end', [ContractController::class, 'end'])->name('contracts.end');
    Route::resource('maintenance-requests', MaintenanceRequestController::class)->names('maintenance_requests');
    Route::put('maintenance-requests/{id}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance_requests.update_status');
	//Route::put('maintenance-requests/{id}', [MaintenanceRequestController::class, 'update'])->name('maintenance_requests.update');
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
            $settings = settings(SystemSettings::class);
            $settings->maintenance_mode = $value;
            $settings->save();
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
    $user = Auth::user();
    if ($user) {
        $user->unreadNotifications->markAsRead();
    }
    return back();
})->middleware('auth')->name('notifications.markAllRead');


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
        Route::get('/{user}', [BuildingSupervisorController::class, 'show'])->name('show'); // 🟢 خليه الأول
        Route::get('/{user}/edit', [BuildingSupervisorController::class, 'edit'])->name('edit');
        Route::put('/{user}', [BuildingSupervisorController::class, 'update'])->name('update');
    });

//cleaningDashboard 
Route::get('cleaning-dashboard', [UnitController::class, 'cleaningDashboard'])->name('admin.cleaning.dashboard');
Route::post('units/{unit}/mark-cleaned', [UnitController::class, 'markAsCleaned'])->name('admin.units.mark.cleaned');
Route::post('units/{unit}/upload-image', [UnitController::class, 'uploadImage'])->name('admin.units.images.upload');
Route::delete('units/images/{image}', [UnitController::class, 'deleteImage'])->name('admin.units.images.delete');

Route::prefix('technician/maintenance')
    ->middleware('auth') // أو middleware خاص بالفنيين لو عندك
    ->name('maintenance.')
    ->group(function () {

    // بدء العمل
    Route::post('/{id}/start', [MaintenanceRequestController::class, 'start'])->whereNumber('id')->name('start');

    // إنهاء العمل
    Route::post('/{id}/complete', [MaintenanceRequestController::class, 'complete'])->whereNumber('id')->name('complete');

    // رفض الطلب
    Route::post('/{id}/reject', [MaintenanceRequestController::class, 'reject'])->whereNumber('id')->name('reject');
		
	Route::post('/{id}/delay', [MaintenanceRequestController::class, 'updateStatus'])->name('delay');

});


//Cars
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // إدارة السيارات
    Route::resource('vehicles', VehicleController::class);

    // تقرير المصاريف والمخالفات
    Route::get('/admin/vehicles/reports', [VehicleController::class, 'reports'])->name('vehicles.reports');

    Route::get('vehicles/reports/pdf', [VehicleController::class, 'exportPdf'])->name('vehicles.reports.pdf');
    Route::get('vehicles/reports/excel', [VehicleController::class, 'exportExcel'])->name('vehicles.reports.excel');

    // حذف مصروف أو مخالفة
    Route::delete('vehicles/expenses/{expense}', function (VehicleExpense $expense) {
        $expense->delete();
        return back()->with('success', 'تم حذف المصروف بنجاح');
    })->name('vehicles.expenses.destroy');

    Route::delete('vehicles/violations/{violation}', function (Violation $violation) {
        $violation->delete();
        return back()->with('success', 'تم حذف المخالفة بنجاح');
    })->name('vehicles.violations.destroy');

    // ✅ إضافة مصروف ومخالفة (خليهم جوا الجروب)
   Route::post('vehicles/{vehicle}/expenses', function (Request $request, $vehicleId) {
    $request->validate([
        'type'          => 'required|string|max:255',
        'expense_date'  => 'required|date',
        'amount'        => 'required|numeric|min:0',
        'description'   => 'nullable|string',
    ]);

    $vehicle = \App\Models\Vehicle::findOrFail($vehicleId);

    $vehicle->expenses()->create([
        'type'          => $request->type,
        'expense_date'  => $request->expense_date,
        'amount'        => $request->amount,
        'description'   => $request->description,
    ]);

    return back()->with('success', '✅ تمت إضافة المصروف للعربية بنجاح');
})->name('vehicles.expenses.store');


    Route::post('vehicles/{vehicle}/violations', function (Request $request, $vehicleId) {
        $request->validate([
            'violation_type' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        \App\Models\Violation::create([
            'vehicle_id' => $vehicleId,
            'user_id' => $request->user_id,
            'violation_type' => $request->violation_type,
            'cost' => $request->cost,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'تمت إضافة المخالفة بنجاح');
    })->name('vehicles.violations.store');
});



// booking 
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/bookings', [RoomBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/create', [RoomBookingController::class, 'create'])->name('admin.bookings.create');
    Route::post('/bookings', [RoomBookingController::class, 'store'])->name('admin.bookings.store');
    Route::patch('/bookings/{booking}/cancel', [RoomBookingController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::post('/bookings/{booking}/confirm', [RoomBookingController::class, 'confirm'])->name('admin.bookings.confirm');
    Route::get('/bookings/{booking}', [RoomBookingController::class, 'show'])->name('admin.bookings.show');
});
// notifications
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('admin.notifications.show');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});
Route::get('/install', [InstallController::class, 'showForm'])->name('install.form');
Route::post('/install', [InstallController::class, 'submit'])->name('install.submit');
Route::get('/phpinfo', fn() => phpinfo());

require __DIR__ . '/auth.php';
