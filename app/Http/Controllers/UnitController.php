<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Enums\UnitType;
use App\Enums\UnitStatus;
use App\Models\UnitImage;
use App\Services\ImageService;

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
    $query = Unit::with(['building', 'contracts.tenant', 'latestContract']);

    if ($request->filled('building_id')) {
        $query->where('building_id', $request->building_id);
    }

    if ($request->filled('search')) {
        $query->where('unit_number', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('unit_type')) {
        $query->where('unit_type', $request->unit_type);
    }

    // ✅ جلب البيانات الأصلية
    $unitsRaw = $query->get();

    // ✅ تجهيز البيانات مع السعر الفعلي
    $units = $unitsRaw->map(function ($unit) {
        $contract = $unit->latestContract;

        $actualRent = ($contract && $contract->status !== 'terminated')
            ? $contract->rent_amount
            : $unit->rent_price;

        return [
            'unit' => $unit,
            'building' => optional($unit->building)->name,
            'rent' => $actualRent,
            'original_rent' => $unit->rent_price,
            'has_discount' => $actualRent != $unit->rent_price,
            'contract_status' => $contract?->status,
        ];
    });

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
        'status'       => 'required|string|in:' . implode(',', UnitStatus::values()),
        'notes'        => 'nullable|string|max:1000',
        'rent_price'   => 'required|numeric|min:0',
        'image'        => 'nullable|image|max:20480',
    ]);

    $unit = Unit::create($request->only([
        'building_id',
        'unit_number',
        'floor',
        'unit_type',
        'status',
        'notes',
        'rent_price',
    ]));

    // ✅ لو فيه صورة، اضغط وخزنها
    if ($request->hasFile('image')) {
        $filename = ImageService::uploadAndOptimize($request->file('image'), 'units');
        $unit->images()->create(['image_path' => $filename]);
    }

    return redirect()->route('admin.units.index')->with('success', __('messages.created_successfully'));
}



 public function edit(Unit $unit)
{
    $buildings   = Building::all();
    $unitTypes   = UnitType::values();
    $unitStatuses = UnitStatus::values();

    $activeContract = \App\Models\Contract::where('unit_id', $unit->id)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->first();

    return view('admin.units.edit', compact('unit', 'buildings', 'unitTypes', 'unitStatuses', 'activeContract'));
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


    // ✅ التحقق من البيانات
    $validated = $request->validate([
        'unit_number' => 'required|string|max:255',
        'floor' => 'nullable|string|max:255',
        'rent_price' => 'required|numeric',
        'status' => 'required|in:' . implode(',', UnitStatus::values()),
        'unit_type' => 'required|string|in:' . implode(',', UnitType::values()),		
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





// 🧼 صفحة داشبورد النظافة: فقط الغرف تحت التنظيف
public function cleaningDashboard(Request $request)
{
    $query = Unit::where('status', 'cleaning')->with('images', 'building');

    if ($request->filled('unit_number')) {
        $query->where('unit_number', 'like', '%' . $request->unit_number . '%');
    }

    if ($request->filled('building_id')) {
        $query->where('building_id', $request->building_id);
    }

    $units = $query->withCount('images')->get();
    $buildings = Building::all();

    return view('admin.units.cleaning-dashboard', compact('units', 'buildings'));
}

// 🖼 رفع الصور (يدعم رفع أكثر من صورة)
public function uploadImage(Request $request, Unit $unit)
{
    $request->validate([
        'images' => 'required|array|min:1',
        'images.*' => 'image|max:20000',
    ]);

    foreach ($request->file('images') as $file) {
        $path = $file->store('unit_images', 'public');

        $unit->images()->create([
            'image_path' => $path,
            'order' => $unit->images()->count() + 1,
        ]);
    }

    return back()->with('success', 'تم رفع الصور بنجاح.');
}

// ❌ حذف صورة واحدة
public function deleteImage(UnitImage $image)
{
    \Storage::disk('public')->delete($image->image_path);
    $image->delete();

    return back()->with('success', 'تم حذف الصورة بنجاح.');
}

// ✅ زر إنهاء التنظيف: يتحقق من رفع 5 صور
public function markAsCleaned(Unit $unit)
{
    if ($unit->images()->count() < 5) {
        return back()->with('error', 'يجب رفع 5 صور على الأقل قبل إنهاء التنظيف.');
    }

    $unit->update(['status' => 'available']);
    return back()->with('success', 'تم إنهاء التنظيف بنجاح.');
}






public function search(Request $request)
{
    $q = $request->get('q');

    $units = \App\Models\Unit::with('building')
        ->where('unit_number', 'LIKE', '%' . $q . '%')
        ->limit(10)
        ->get(['id', 'unit_number', 'building_id']);

    return response()->json($units);
}




}
