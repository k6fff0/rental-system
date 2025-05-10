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

        $expenses = $query->latest()->get();
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
