@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        {{-- 🔧 عنوان الصفحة --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_maintenance_request') }}</h1>

        {{-- ⚠️ رسائل الخطأ أو النجاح --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- 📋 فورم الإضافة --}}
        <form action="{{ route('admin.maintenance_requests.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            {{-- المبنى --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
                <select name="building_id" id="buildingSelect"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">{{ __('messages.select_building') }}</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- الوحدة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
                <select name="unit_id" id="unitSelect"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">{{ __('messages.select_unit') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" data-building="{{ $unit->building_id }}"
                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit_number }} - {{ $unit->unit_type }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- نوع العطل بناءً على التخصصات الفرعية --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.issue_type') }}</label>
                <select name="sub_specialty_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">{{ __('messages.select_issue_type') }}</option>
                    @foreach ($subSpecialties as $subtask)
                        <option value="{{ $subtask->id }}"
                            {{ old('sub_specialty_id') == $subtask->id ? 'selected' : '' }}>
                            {{ $subtask->name }} ({{ $subtask->parent?->name ?? __('messages.unspecified') }})
                        </option>
                    @endforeach
                </select>
            </div>
<!-- رقم هاتف إضافي -->
<div class="mt-4">
    <label for="extra_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('messages.extra_contact_number') }}
    </label>
    <input type="text" name="extra_phone" id="extra_phone"
        value="{{ old('extra_phone') }}"
        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

<!-- هل واتساب؟ -->
<div class="mt-2 flex items-center gap-2">
    <input type="checkbox" name="is_whatsapp" id="is_whatsapp" value="1"
        {{ old('is_whatsapp') ? 'checked' : '' }}
        class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 dark:bg-gray-800 dark:border-gray-600">
    <label for="is_whatsapp" class="text-sm text-gray-700 dark:text-gray-300">
        {{ __('messages.is_whatsapp') }}
    </label>
</div>

            {{-- وصف المشكلة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.description') }}</label>
                <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
            </div>

            {{-- الصورة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.image') }}</label>
                <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-700" accept="image/*">
            </div>

            {{-- الأزرار --}}
            <div class="pt-4 flex justify-between items-center">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">{{ __('messages.back') }}</a>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow text-sm font-semibold">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- 🔄 سكريبت فلترة الوحدات بناءً على المبنى --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buildingSelect = document.getElementById('buildingSelect');
            const unitSelect = document.getElementById('unitSelect');

            function filterUnits() {
                const selectedBuilding = buildingSelect.value;
                Array.from(unitSelect.options).forEach(option => {
                    const buildingId = option.getAttribute('data-building');
                    if (!buildingId || !selectedBuilding) {
                        option.style.display = '';
                        return;
                    }

                    if (buildingId === selectedBuilding) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            buildingSelect.addEventListener('change', filterUnits);

            // ✅ شغّل الفلترة عند تحميل الصفحة
            filterUnits();
        });
    </script>
@endsection
