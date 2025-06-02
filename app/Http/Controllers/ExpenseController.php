<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Building;
use App\Models\Unit;
use App\Models\ExpenseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view expenses')->only(['index', 'show']);
        $this->middleware('permission:create expenses')->only(['create', 'store']);
        $this->middleware('permission:edit expenses')->only(['edit', 'update']);
        $this->middleware('permission:delete expenses')->only(['destroy']);
    }

    public function index()
    {
        $query = Expense::with(['building', 'unit']);

        if (request('building_id')) {
            $query->where('building_id', request('building_id'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('expense_date')) {
            $query->whereDate('expense_date', request('expense_date'));
        }

        $expenses = $query->latest()->paginate(20);
        $buildings = Building::all();

        $totalExpenses = $expenses->sum('amount');

        // مصروفات هذا الشهر
        $thisMonthExpenses = Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        // مصروفات الشهر السابق
        $lastMonth = now()->subMonth();
        $lastMonthExpenses = Expense::whereMonth('expense_date', $lastMonth->month)
            ->whereYear('expense_date', $lastMonth->year)
            ->sum('amount');

        // حساب متوسط المصروفات الشهرية من أول مصروف لآخر مصروف (شهريًا)
        $firstExpenseDate = Expense::min('expense_date');
        $monthsCount = 1;

        if ($firstExpenseDate) {
            $start = \Carbon\Carbon::parse($firstExpenseDate)->startOfMonth();
            $end = now()->startOfMonth();
            $monthsCount = $start->diffInMonths($end) + 1;
        }

        $averageMonthlyExpenses = $monthsCount > 0
            ? Expense::sum('amount') / $monthsCount
            : 0;

        return view('admin.expenses.index', compact(
            'expenses',
            'buildings',
            'totalExpenses',
            'thisMonthExpenses',
            'lastMonthExpenses',
            'averageMonthlyExpenses'
        ));
    }



    public function create()
    {
        $buildings = Building::all();
        $units = Unit::all();
        return view('admin.expenses.create', compact('buildings', 'units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'nullable|exists:units,id',
            'type' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'invoice_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $expense = Expense::create($data);

        if ($request->hasFile('invoice_images')) {
            foreach ($request->file('invoice_images') as $image) {
                $path = $image->store('invoices', 'public');
                ExpenseImage::create([
                    'expense_id' => $expense->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.saved_successfully'));
    }

    public function edit(Expense $expense)
    {
        $buildings = Building::all();
        $units = Unit::all();
        $expense->load('images');
        return view('admin.expenses.edit', compact('expense', 'buildings', 'units'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'nullable|exists:units,id',
            'type' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'invoice_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $expense->update($data);

        if ($request->hasFile('invoice_images')) {
            foreach ($request->file('invoice_images') as $image) {
                $path = $image->store('invoices', 'public');
                ExpenseImage::create([
                    'expense_id' => $expense->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Expense $expense)
    {
        foreach ($expense->images as $img) {
            if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.deleted_successfully'));
    }
}
