<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuildingUtilityController extends Controller
{
    public function index(Request $request)
    {
        $query = BuildingUtility::with('building');

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        $utilities = $query->latest()->get();
        $buildings = Building::all();

        return view('admin.building_utilities.index', compact('utilities', 'buildings'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('admin.building_utilities.create', compact('buildings'));
    }

   public function store(Request $request)
{
    $data = $request->validate([
        'building_id' => 'required|exists:buildings,id',
        'type' => 'required|in:electricity,water,internet',
        'value' => 'required|string|max:255',
        'owner_name' => 'nullable|string|max:255',
        'owner_id_number' => 'nullable|string|max:255',
        'owner_id_image.*' => 'nullable|image|max:2048',
		'owner_id_image' => 'nullable|array',
        'notes' => 'nullable|string',
    ]);

    $images = [];

    if ($request->hasFile('owner_id_image')) {
        foreach ($request->file('owner_id_image') as $image) {
            if ($image) {
                $images[] = $image->store('utilities/ids', 'public');
            }
        }
    }

    $data['owner_id_image'] = json_encode($images);

    BuildingUtility::create($data);

    return redirect()->route('admin.building-utilities.index')->with('success', 'تم إضافة المرفق بنجاح');
}


    public function show(BuildingUtility $buildingUtility)
    {
        return view('admin.building_utilities.show', compact('buildingUtility'));
    }

    public function edit(BuildingUtility $buildingUtility)
    {
        $buildings = Building::all();
        return view('admin.building_utilities.edit', compact('buildingUtility', 'buildings'));
    }

   public function update(Request $request, BuildingUtility $buildingUtility)
{
    $data = $request->validate([
        'building_id' => 'required|exists:buildings,id',
        'type' => 'required|in:electricity,water,internet',
        'value' => 'required|string|max:255',
        'owner_name' => 'nullable|string|max:255',
        'owner_id_number' => 'nullable|string|max:255',
        'owner_id_image.*' => 'nullable|image|max:2048',
		'owner_id_image' => 'nullable|array',
        'notes' => 'nullable|string',
    ]);

    // الصور القديمة من الداتابيز
    $existingImages = json_decode($buildingUtility->owner_id_image, true) ?? [];
    $newImages = [];

    // لو المستخدم رفع صور جديدة
    if ($request->hasFile('owner_id_image')) {
        foreach ($request->file('owner_id_image') as $image) {
            if ($image) {
                $newImages[] = $image->store('utilities/ids', 'public');
            }
        }
    }

    // دمج الصور الجديدة مع القديمة (لو فيه جديدة)
    $data['owner_id_image'] = json_encode(array_merge($existingImages, $newImages));

    $buildingUtility->update($data);

    return redirect()->route('admin.building-utilities.index')->with('success', 'تم تحديث المرفق بنجاح');
}

    public function destroy(BuildingUtility $buildingUtility)
    {
        $images = json_decode($buildingUtility->owner_id_image, true) ?? [];

        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        $buildingUtility->delete();

        return redirect()->route('admin.building-utilities.index')->with('success', 'تم حذف المرفق بنجاح');
    }
	public function deleteImage(Request $request, BuildingUtility $utility)
{
    $request->validate([
        'image' => 'required|string'
    ]);

    $images = json_decode($utility->owner_id_image, true) ?? [];

    // لو الصورة موجودة
    if (($key = array_search($request->image, $images)) !== false) {
        // احذفها من الملفات
        Storage::disk('public')->delete($request->image);

        // احذفها من المصفوفة
        unset($images[$key]);

        // حفظ الباقي بعد الحذف
        $utility->update([
            'owner_id_image' => json_encode(array_values($images))
        ]);
    }

    return back()->with('success', '✅ تم حذف الصورة بنجاح');
}

}
