<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Enums\UnitType;
use App\Enums\UnitStatus;
use App\Models\UnitImage;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Services\ImageService;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class UnitController extends Controller



{
    public function __construct()
    {
        $this->middleware('permission:view units')->only(['index', 'show']);
        $this->middleware('permission:create units')->only(['create', 'store']);
        $this->middleware('permission:edit units')->only(['edit', 'update']);
        $this->middleware('permission:delete units')->only(['destroy']);
    }


    //------------------------------------------------------------------------------------------------------------------------


    public function show(Unit $unit)
    {
        abort_unless(Gate::allows('view unit details'), 403);
        return view('admin.units.show', compact('unit'));
    }

    //-----------------------------------------------------------------------------------------------------------------------


    public function index(Request $request)
    {
        $query = Unit::with(['building', 'contracts.tenant', 'latestContract'])
            ->orderByDesc('updated_at');

        // ✅ فلترة لو المستخدم اختارها
        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('search')) {
            $query->where('unit_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('unit_type')) {
            $query->where('unit_type', $request->unit_type);
        }

        // 🔁 انسخ الكويري الكامل قبل الباجينيشن لحساب الإحصائيات
        $statsQuery = clone $query;
        $allUnits = $statsQuery->get(); // جميع النتائج بدون paginate

        // ✅ الباجينيشن
        $units = $query->paginate(10);

        $units->getCollection()->transform(function ($unit) {
            $contract = $unit->latestContract;

            $unit->actual_rent = ($contract && $contract->status !== 'terminated')
                ? $contract->rent_amount
                : $unit->rent_price;

            $unit->has_discount = $unit->actual_rent != $unit->rent_price;
            $unit->contract_status = $contract?->status;
            $unit->building_name = optional($unit->building)->name;

            return $unit;
        });

        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.index', compact('units', 'allUnits', 'buildings', 'unitTypes'));
    }


    //-----------------------------------------------------------------------------------------------------------------------

    public function create()
    {
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.create', compact('buildings', 'unitTypes'));
    }

    //-----------------------------------------------------------------------------------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'building_id'       => 'required|exists:buildings,id',
            'unit_number'       => 'required|string|max:50|unique:units,unit_number,NULL,id,building_id,' . $request->building_id,
            'floor'             => 'nullable|string|in:ground,first,second,third,fourth,fifth',
            'unit_type'         => 'required|string|in:' . implode(',', UnitType::values()),
            'status'            => 'required|string|in:' . implode(',', UnitStatus::values()),
            'notes'             => 'nullable|string|max:1000',
            'rent_price'        => 'required|numeric|min:0',
            'location'          => 'nullable|string|max:100',
            'image'             => 'nullable|image|max:20480',
            'is_first_tenant'   => 'nullable|boolean',
        ]);

        $unit = Unit::create($request->only([
            'building_id',
            'unit_number',
            'floor',
            'unit_type',
            'status',
            'notes',
            'rent_price',
            'location',
        ]) + [
            'is_first_tenant' => $request->has('is_first_tenant'),
        ]);

        if ($request->hasFile('image')) {
            $filename = ImageService::uploadAndOptimize($request->file('image'), 'units');
            $unit->images()->create(['image_path' => $filename]);
        }

        log_action("🏠 تم إضافة وحدة جديدة رقم {$unit->unit_number} في مبنى: {$unit->building->name}");

        return redirect()->route('admin.units.index')->with('success', __('messages.created_successfully'));
    }



    //-----------------------------------------------------------------------------------------------------------------------

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


    //-----------------------------------------------------------------------------------------------------------------------


    public function update(Request $request, Unit $unit)
    {
        $unit->load('latestContract');

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

        if (
            $request->has('status') &&
            $request->status === 'available' &&
            $unit->activeBookingExists()
        ) {
            return back()->withErrors([
                'status' => 'لا يمكن تحويل الغرفة إلى متاحة لأنها مرتبطة بحجز قائم، يجب أولاً إلغاء الحجز.',
            ])->withInput();
        }

        $validated = $request->validate([
            'unit_number'      => 'required|string|max:255',
            'floor'            => 'nullable|string|in:ground,first,second,third,fourth,fifth',
            'rent_price'       => 'required|numeric',
            'status'           => 'required|in:' . implode(',', UnitStatus::values()),
            'unit_type'        => 'required|string|in:' . implode(',', UnitType::values()),
            'location'         => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
            'is_first_tenant'  => 'nullable|boolean',
        ]);

        $unit->update($validated + [
            'is_first_tenant' => $request->has('is_first_tenant'),
        ]);

        log_action('🏠 تم تعديل بيانات الغرفة: ' . $unit->unit_number . ' - ' . $unit->building->name);

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'تم تحديث بيانات الوحدة بنجاح');
    }


    //-----------------------------------------------------------------------------------------------------------------------


    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', __('messages.deleted_successfully'));
    }

    //-----------------------------------------------------------------------------------------------------------------------

    public function available(Request $request)
    {
        $query = Unit::with(['building', 'images'])
            ->where('status', 'available');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('unit_number', 'like', "%{$search}%")
                    ->orWhereHas('building', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $units = $query->latest()->paginate(20);

        return view('admin.units.available', compact('units'));
    }

    //-----------------------------------------------------------------------------------------------------------------------



    public function availableText(Request $request)
    {
        $units = Unit::with(['building.supervisors'])
            ->where('status', 'available')
            ->orderBy('building_id')
            ->get()
            ->groupBy('building.name');

        return view('admin.units.available_text', compact('units'));
    }


    //-----------------------------------------------------------------------------------------------------------------------

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


    //-----------------------------------------------------------------------------------------------------------------------


    // 🖼 رفع الصور (يدعم رفع أكثر من صورة)
    public function uploadImage(Request $request, Unit $unit)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:20000',
        ]);

        foreach ($request->file('images') as $file) {
            // ✅ 1. رفع الصورة إلى المسار الصحيح
            $path = $file->store('unit_images', 'public');

            // ✅ 2. المسار الحقيقي الفعلي للصورة
            $fullPath = Storage::disk('public')->path($path);
            Log::info('📏 قبل: ' . filesize($fullPath));
            // ✅ 3. ضغط الصورة فعليًا
            OptimizerChainFactory::create()->optimize($fullPath);
            Log::info('✅ بعد: ' . filesize($fullPath));
            // ✅ 4. حفظ الصورة في قاعدة البيانات
            $unit->images()->create([
                'image_path' => $path,
                'order' => $unit->images()->count() + 1,
            ]);
        }

        return back()->with('success', 'تم رفع وضغط الصور بنجاح.');
    }
    // ❌ حذف صورة واحدة
    public function deleteImage(UnitImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
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

    //-----------------------------------------------------------------------------------------------------------------------


    public function search(Request $request)
    {
        $term = $request->get('q');

        $results = Unit::with('building')
            ->where(function ($q) use ($term) {
                $q->where('unit_number', 'like', "%$term%")
                    ->orWhereHas('building', function ($q2) use ($term) {
                        $q2->where('name', 'like', "%$term%");
                    });
            })
            ->take(15)
            ->get()
            ->map(function ($unit) {
                return [
                    'id' => $unit->id,
                    'text' => $unit->unit_number . ' - ' . optional($unit->building)->name,
                ];
            });

        return response()->json($results);
    }


    //-----------------------------------------------------------------------------------------------------------------------



    //-----------------------------------------------------------------------------------------------------------------------
}
