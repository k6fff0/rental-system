<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Building;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->get();
        $buildings = Building::all();

        return view('admin.expenses.index', compact('expenses', 'buildings'));
    }

    public function create()
    {
        $buildings = Building::all();
        $units = Unit::all();

        return view('admin.expenses.create', compact('buildings', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'nullable|exists:units,id',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'invoice_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $expense = new Expense();
        $expense->type = $request->type;
        $expense->building_id = $request->building_id;
        $expense->unit_id = $request->unit_id;
        $expense->amount = $request->amount;
        $expense->expense_date = $request->expense_date;
        $expense->description = $request->description;

        if ($request->hasFile('invoice_image')) {
            $file = $request->file('invoice_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('invoices', $filename, 'public');
            $expense->invoice_image = $path;
        }

        $expense->save();

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.expense_created_successfully'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $buildings = Building::all();
        $units = Unit::all();

        return view('admin.expenses.edit', compact('expense', 'buildings', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'nullable|exists:units,id',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'invoice_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->type = $request->type;
        $expense->building_id = $request->building_id;
        $expense->unit_id = $request->unit_id;
        $expense->amount = $request->amount;
        $expense->expense_date = $request->expense_date;
        $expense->description = $request->description;

        if ($request->hasFile('invoice_image')) {
            $file = $request->file('invoice_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('invoices', $filename, 'public');
            $expense->invoice_image = $path;
        }

        $expense->save();

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.expense_updated_successfully'));
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        // لو عايز تحذف الفاتورة من التخزين كمان:
        if ($expense->invoice_image && Storage::disk('public')->exists($expense->invoice_image)) {
            Storage::disk('public')->delete($expense->invoice_image);
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', __('messages.expense_deleted_successfully'));
    }
}
