<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Contract;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\ActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
	public function __construct()
{
    $this->middleware('permission_or_super:view dashboard')->only(['index', 'show']);
}

    public function index()
    {
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        // 1. عدد المستخدمين
        $usersCount = \App\Models\User::where('is_hidden', false)->count();

        // 2. عدد المباني
        $buildingsCount = Building::count();

        // 3. عدد الوحدات
        $unitsCount = Unit::count();

        // 4. عدد الوحدات المتاحة والمشغولة
        $availableUnitsCount = Unit::where('status', 'available')->count();
        $occupiedUnitsCount = Unit::where('status', 'occupied')->count();

        // 5. عدد المستأجرين
        $tenantsCount = Tenant::count();

        // 6. العقود القريبة من الانتهاء (خلال 30 يوم)
        $expiringContracts = Contract::whereBetween('end_date', [$now, $now->copy()->addDays(30)])->get();

        // 7. أحدث الأنشطة
        $recentActivities = ActivityLog::latest()->paginate(5);
		if ($recentActivities->isEmpty()) {
    $recentActivities = collect([
        (object)[
            'description' => 'تم تعديل بيانات الوحدة رقم 305',
            'created_at' => now()->subMinutes(5),
        ],
        (object)[
            'description' => 'تم إنشاء عقد جديد',
            'created_at' => now()->subHours(1),
        ],
    ]);
}


        // 8. مجموع المصروفات لهذا الشهر
        $totalExpenses = Expense::whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $currentMonth)
            ->sum('amount');

        // 9. مجموع الإيرادات لهذا الشهر
        $totalIncome = Payment::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount');

        // 10. مصروفات كل شهر
        $monthlyExpenses = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->whereYear('expense_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        // 11. إيرادات كل شهر
        $monthlyIncome = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        // ترتيب البيانات للشهور
        $months = range(1, 12);
        $monthlyExpenses = array_map(fn($m) => $monthlyExpenses[$m] ?? 0, $months);
        $monthlyIncome = array_map(fn($m) => $monthlyIncome[$m] ?? 0, $months);

        return view('admin.dashboard', compact(
            'usersCount',
            'buildingsCount',
            'unitsCount',
            'availableUnitsCount',
            'occupiedUnitsCount',
            'tenantsCount',
            'expiringContracts',
            'recentActivities',
            'totalExpenses',
            'totalIncome',
            'monthlyExpenses',
            'monthlyIncome'
        ));
    }
}
