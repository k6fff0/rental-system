@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="rtl">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">تعديل بيانات المبنى</h1>
        <a href="{{ route('admin.buildings.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← رجوع لقائمة المباني
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.buildings.update', $building->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- اسم المبنى --}}
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium">اسم المبنى</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $building->name) }}" class="form-input w-full" required>
                </div>
                {{-- رقم المبنى --}}
                <div>
                    <label for="building_number" class="block mb-1 text-sm font-medium">رقم المبنى</label>
                    <input type="text" name="building_number" id="building_number" value="{{ old('building_number', $building->building_number) }}" class="form-input w-full">
                </div>
                {{-- العنوان --}}
                <div>
                    <label for="address" class="block mb-1 text-sm font-medium">العنوان</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $building->address) }}" class="form-input w-full" required>
                </div>

                {{-- رابط جوجل ماب --}}
                <div>
                    <label for="location_url" class="block mb-1 text-sm font-medium">رابط موقع المبنى على Google Maps</label>
                    <input type="url" name="location_url" id="location_url" value="{{ old('location_url', $building->location_url) }}" class="form-input w-full">
                </div>

                {{-- اسم المالك --}}
                <div>
                    <label for="owner_name" class="block mb-1 text-sm font-medium">اسم المالك</label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $building->owner_name) }}" class="form-input w-full">
                </div>

                {{-- الجنسية --}}
                <div>
                    <label for="owner_nationality" class="block mb-1 text-sm font-medium">الجنسية</label>
                    <input type="text" name="owner_nationality" id="owner_nationality" value="{{ old('owner_nationality', $building->owner_nationality) }}" class="form-input w-full">
                </div>

                {{-- رقم الهوية --}}
                <div>
                    <label for="owner_id_number" class="block mb-1 text-sm font-medium">رقم الهوية</label>
                    <input type="text" name="owner_id_number" id="owner_id_number" value="{{ old('owner_id_number', $building->owner_id_number) }}" class="form-input w-full">
                </div>

                {{-- رقم الموبايل --}}
                <div>
                    <label for="owner_phone" class="block mb-1 text-sm font-medium">رقم الموبايل</label>
                    <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone', $building->owner_phone) }}" class="form-input w-full">
                </div>

                {{-- رقم تسجيل البلدية --}}
                <div>
                    <label for="municipality_number" class="block mb-1 text-sm font-medium">رقم تسجيل الوحدة في البلدية</label>
                    <input type="text" name="municipality_number" id="municipality_number" value="{{ old('municipality_number', $building->municipality_number) }}" class="form-input w-full">
                </div>

                {{-- سعر الإيجار --}}
                <div>
                    <label for="rent_amount" class="block mb-1 text-sm font-medium">سعر إيجار المبنى (شهريًا)</label>
                    <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount', $building->rent_amount) }}" class="form-input w-full" step="0.01">
                </div>

                {{-- التعديل الأولي --}}
                <div>
                    <label for="initial_renovation_cost" class="block mb-1 text-sm font-medium">تكاليف التعديل لأول مرة</label>
                    <input type="number" name="initial_renovation_cost" id="initial_renovation_cost" value="{{ old('initial_renovation_cost', $building->initial_renovation_cost) }}" class="form-input w-full" step="0.01">
                </div>
            </div>
            {{-- زر الحفظ --}}
            <div class="mt-8 text-left">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow transition">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>

{{-- سكريبت تكرار الحقول --}}
<script>
    function addElectricMeter() {
        const container = document.getElementById('electric-meters-wrapper');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'electric_meters[]';
        input.className = 'form-input w-full mt-2';
        container.appendChild(input);
    }

    function addInternetLine() {
        const container = document.getElementById('internet-lines-wrapper');
        const wrapper = document.createElement('div');
        wrapper.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2';

        const timestamp = Date.now();

        const inputLine = document.createElement('input');
        inputLine.type = 'text';
        inputLine.name = `internet_lines[${timestamp}][line]`;
        inputLine.placeholder = 'رقم الخط';
        inputLine.className = 'form-input w-full';

        const inputOwner = document.createElement('input');
        inputOwner.type = 'text';
        inputOwner.name = `internet_lines[${timestamp}][owner]`;
        inputOwner.placeholder = 'اسم المالك';
        inputOwner.className = 'form-input w-full';

        wrapper.appendChild(inputLine);
        wrapper.appendChild(inputOwner);
        container.appendChild(wrapper);
    }
</script>
@endsection
