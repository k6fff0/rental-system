@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="rtl">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إضافة مبنى جديد</h1>
        <a href="{{ route('admin.buildings.index') }}" class="text-sm text-blue-600 hover:underline">
            ← رجوع لقائمة المباني
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.buildings.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- اسم المبنى --}}
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium">اسم المبنى *</label>
                    <input type="text" name="name" id="name" class="form-input w-full" required>
                </div>

                {{-- العنوان --}}
                <div>
                    <label for="address" class="block mb-1 text-sm font-medium">العنوان *</label>
                    <input type="text" name="address" id="address" class="form-input w-full" required>
                </div>

                {{-- رابط الموقع --}}
                <div>
                    <label for="location_url" class="block mb-1 text-sm font-medium">رابط موقع المبنى على Google Maps</label>
                    <input type="url" name="location_url" id="location_url" class="form-input w-full">
                </div>

                {{-- رقم المبنى --}}
                <div>
                    <label for="building_number" class="block mb-1 text-sm font-medium">رقم المبنى *</label>
                    <input type="text" name="building_number" id="building_number" class="form-input w-full" required>
                </div>

                {{-- اسم المالك --}}
                <div>
                    <label for="owner_name" class="block mb-1 text-sm font-medium">اسم المالك *</label>
                    <input type="text" name="owner_name" id="owner_name" class="form-input w-full" required>
                </div>

                {{-- الجنسية --}}
                <div>
                    <label for="owner_nationality" class="block mb-1 text-sm font-medium">الجنسية</label>
                    <input type="text" name="owner_nationality" id="owner_nationality" class="form-input w-full">
                </div>

                {{-- رقم الهوية --}}
                <div>
                    <label for="owner_id_number" class="block mb-1 text-sm font-medium">رقم الهوية *</label>
                    <input type="text" name="owner_id_number" id="owner_id_number" class="form-input w-full" required>
                </div>

                {{-- رقم الجوال --}}
                <div>
                    <label for="owner_phone" class="block mb-1 text-sm font-medium">رقم الموبايل *</label>
                    <input type="text" name="owner_phone" id="owner_phone" class="form-input w-full" required>
                </div>

                {{-- رقم تسجيل البلدية --}}
                <div>
                    <label for="municipality_number" class="block mb-1 text-sm font-medium">رقم تسجيل البلدية</label>
                    <input type="text" name="municipality_number" id="municipality_number" class="form-input w-full">
                </div>

                {{-- سعر الإيجار --}}
                <div>
                    <label for="rent_amount" class="block mb-1 text-sm font-medium">سعر الإيجار *</label>
                    <input type="number" name="rent_amount" id="rent_amount" class="form-input w-full" step="0.01" required>
                </div>

                {{-- التعديل الأولي --}}
                <div>
                    <label for="initial_renovation_cost" class="block mb-1 text-sm font-medium">تكاليف التعديل لأول مرة</label>
                    <input type="number" name="initial_renovation_cost" id="initial_renovation_cost" class="form-input w-full" step="0.01">
                </div>
            </div>

            {{-- عدادات الكهرباء --}}
            <div class="mt-8">
                <label class="block mb-2 text-sm font-medium">أرقام عدادات الكهرباء *</label>
                <div id="electric-meters-wrapper" class="space-y-2">
                    <input type="text" name="electric_meters[]" class="form-input w-full" required>
                </div>
                <button type="button" onclick="addElectricMeter()" class="mt-2 text-blue-600 text-sm hover:underline">+ إضافة عداد</button>
            </div>

            {{-- خطوط الإنترنت --}}
            <div class="mt-6">
                <label class="block mb-2 text-sm font-medium">خطوط الإنترنت (الرقم + اسم المالك)</label>
                <div id="internet-lines-wrapper" class="space-y-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <input type="text" name="internet_lines[0][line]" class="form-input w-full" placeholder="رقم الخط">
                        <input type="text" name="internet_lines[0][owner]" class="form-input w-full" placeholder="اسم المالك">
                    </div>
                </div>
                <button type="button" onclick="addInternetLine()" class="mt-2 text-blue-600 text-sm hover:underline">+ إضافة خط</button>
            </div>

            {{-- زر الحفظ --}}
            <div class="mt-8 text-left">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow transition">
                    حفظ المبنى
                </button>
            </div>
        </form>
    </div>
</div>

{{-- سكريبت التكرار --}}
<script>
    function addElectricMeter() {
        const container = document.getElementById('electric-meters-wrapper');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'electric_meters[]';
        input.className = 'form-input w-full mt-2';
        input.required = true;
        container.appendChild(input);
    }

    function addInternetLine() {
        const container = document.getElementById('internet-lines-wrapper');
        const wrapper = document.createElement('div');
        wrapper.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2';

        const inputLine = document.createElement('input');
        inputLine.type = 'text';
        inputLine.name = `internet_lines[${Date.now()}][line]`;
        inputLine.placeholder = 'رقم الخط';
        inputLine.className = 'form-input w-full';

        const inputOwner = document.createElement('input');
        inputOwner.type = 'text';
        inputOwner.name = `internet_lines[${Date.now()}][owner]`;
        inputOwner.placeholder = 'اسم المالك';
        inputOwner.className = 'form-input w-full';

        wrapper.appendChild(inputLine);
        wrapper.appendChild(inputOwner);
        container.appendChild(wrapper);
    }
</script>
@endsection
