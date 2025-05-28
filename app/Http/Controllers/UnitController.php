<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Enums\UnitType;
use App\Models\UnitImage;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view units')->only(['index', 'show']);
        $this->middleware('permission:create units')->only(['create', 'store']);
        $this->middleware('permission:edit units')->only(['edit', 'update']);
        $this->middleware('permission:delete units')->only(['destroy']);
    }

   public function show(Unit $unit)
   {
    abort_unless(auth()->user()->can('view unit details'), 403);

    $unit->load(['building', 'contracts.tenant', 'latestContract.tenant']);
    return view('admin.units.show', compact('unit'));
    }


    public function index(Request $request)
    {
        $query = Unit::with(['building', 'contracts.tenant', 'latestActiveContract']);

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('search')) {
            $query->where('unit_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('unit_type')) {
            $query->where('unit_type', $request->unit_type);
        }

        $units = $query->get();
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.index', compact('units', 'buildings', 'unitTypes'));
    }

    public function create()
    {
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.create', compact('buildings', 'unitTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'unit_number'  => 'required|string|max:50|unique:units,unit_number,NULL,id,building_id,' . $request->building_id,
            'floor'        => 'nullable|integer',
            'unit_type'    => 'required|string|in:' . implode(',', UnitType::values()),
            'status'       => 'required|in:available,occupied,booked,maintenance,cleaning',
            'notes'        => 'nullable|string|max:1000',
            'rent_price'   => 'required|numeric|min:0',
        ]);

        Unit::create($request->only([
            'building_id',
            'unit_number',
            'floor',
            'unit_type',
            'status',
            'notes',
            'rent_price',
        ]));

        return redirect()->route('admin.units.index')->with('success', __('messages.created_successfully'));
    }

    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        $activeContract = \App\Models\Contract::where('unit_id', $unit->id)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        return view('admin.units.edit', compact('unit', 'buildings', 'unitTypes', 'activeContract'));
    }

  public function update(Request $request, Unit $unit)
{
    $unit->load('latestContract');

    // ✅ لو الوحدة حالياً مشغولة وفيه عقد نشط، امنع التغيير إلا لو الحالة هتفضل "occupied"
    if (
        $unit->status === 'occupied' &&
        $unit->latestContract &&
        $unit->latestContract->isActive()
    ) {
        if ($request->has('status') && $request->status !== 'occupied') {
            return back()->withErrors([
                'status' => 'لا يمكن تعديل حالة الوحدة لأنها مرتبطة بعقد نشط رقم ' . $unit->latestContract->contract_number,
            ])->withInput();
        }
    }

    // ✅ لو الحالة القديمة cleaning والجديدة available، تأكد من وجود 5 صور على الأقل
    if (
        $unit->status === 'cleaning' &&
        $request->has('status') &&
        $request->status === 'available'
    ) {
        if ($unit->images()->count() < 5) {
            return back()->withErrors([
                'status' => 'لا يمكن تحويل الوحدة إلى متاحة بدون رفع 5 صور على الأقل.',
            ])->withInput();
        }
    }

    // ✅ التحقق من البيانات
    $validated = $request->validate([
        'unit_number' => 'required|string|max:255',
        'floor' => 'nullable|string|max:255',
        'rent_price' => 'required|numeric',
        'status' => 'required|in:available,occupied,booked,maintenance,cleaning',
        'unit_type'    => 'required|string|in:' . implode(',', UnitType::values()),		
        'notes' => 'nullable|string',
    ]);

    // ✅ التحديث
    $unit->update($validated);

    return redirect()
        ->route('admin.units.index')
        ->with('success', 'تم تحديث بيانات الوحدة بنجاح');
}


    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', __('messages.deleted_successfully'));
    }
	public function available(Request $request)
{
    $units = Unit::with(['building', 'images']) // ✅ تحميل المبنى والصور معًا
        ->where('status', 'available')
        ->latest()
        ->paginate(20);

    return view('admin.units.available', compact('units'));
}

public function images(Unit $unit)
{
    if ($unit->status !== 'cleaning') {
        return redirect()->back()->with('error', 'يمكن رفع الصور فقط عندما تكون الوحدة تحت التنظيف.');
    }

    $images = $unit->images()->orderBy('order')->get();
    return view('admin.units.images', compact('unit', 'images'));
}
public function uploadImage(Request $request, Unit $unit)
{
    $request->validate([
        'image' => 'required|image|max:2048',
    ]);

    $path = $request->file('image')->store('unit_images', 'public');

    $unit->images()->create([
        'image_path' => $path,
        'order' => $unit->images()->count() + 1,
    ]);

    return back()->with('success', 'تم رفع الصورة بنجاح');
}
public function deleteImage(UnitImage $image)
{
    \Storage::disk('public')->delete($image->image_path);
    $image->delete();

    return back()->with('success', 'تم حذف الصورة بنجاح');
}

}
