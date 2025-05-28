@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ➕ زر إضافة مبنى --}}
	@can('create buildings')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.building_list') }}</h1>
        <a href="{{ route('admin.buildings.create') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition duration-200">
            + {{ __('messages.add_building') }}
        </a>
    </div>
	@endcan

    {{-- 🔍 فلتر البحث الذكي --}}
<div class="mb-6 bg-white p-4 rounded-lg shadow grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="relative">
        <label class="block text-sm text-gray-700 mb-1">{{ __('messages.select_from_list') }}</label>
        <div class="relative">
            <select id="buildingSelect" class="form-select appearance-none w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 rtl:pr-8 ltr:pl-8 bg-white">
                <option value="">{{ __('messages.all_buildings') }}</option>
                @foreach ($buildings as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 ml-2' : 'right-0 mr-2' }} flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
    </div>
	<div class="relative">
        <label class="block text-sm text-gray-700 mb-1">{{ __('messages.search_by_name') }}</label>
        <input type="text" id="smartSearch" placeholder="{{ __('messages.type_building_name_or_number') }}"
               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 rtl:pr-3 ltr:pl-3">
    </div>
</div>

    {{-- 📭 لا توجد مباني --}}
    <div id="noResults" class="bg-white p-6 rounded-lg shadow text-center text-gray-500 hidden">
        {{ __('messages.no_results_found') }}
    </div>

{{-- 📋 جدول عرض المباني --}}
<div id="buildingsTable" class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full border border-gray-200 text-sm text-gray-800">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                {{-- ✅ ظاهرة في الموبايل --}}
                <th class="px-4 py-3 text-right w-full sm:w-auto">{{ __('messages.building_name') }}</th>
                <th class="px-4 py-3 text-right">{{ __('messages.building_number') }}</th>
                {{-- ⛔ مخفية في الموبايل --}}
                <th class="px-4 py-3 hidden sm:table-cell text-right">{{ __('messages.address') }}</th>
                <th class="px-4 py-3 hidden sm:table-cell text-right">{{ __('messages.unit_count') }}</th>
                <th class="px-4 py-3 hidden sm:table-cell text-right">{{ __('messages.created_at') }}</th>
                {{-- ✅ ظاهرة في الموبايل --}}
                <th class="px-4 py-3 text-right">🌍 {{ __('messages.location') }}</th>
                {{-- ✅ ظاهرة في الموبايل --}}
                <th class="px-4 py-3 text-right">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody id="buildingsTableBody">
            @foreach ($buildings as $building)
                @php
                    $confirmMessage = app()->getLocale() === 'ar'
                        ? '⚠️ هل أنت متأكد أنك تريد حذف هذا المبنى؟ سيتم أيضًا حذف كل الغرف المرتبطة به، وقد تؤدي العملية إلى حذف عقود مرتبطة.'
                        : '⚠️ Are you sure you want to delete this building? All related units will also be deleted, and this may include linked contracts.';
                @endphp
                <tr class="border-t hover:bg-gray-50 transition duration-150" data-name="{{ strtolower($building->name) }}" data-id="{{ $building->id }}">
                    {{-- ✅ اسم المبنى --}}
                    <td class="px-4 py-3 text-right min-w-[160px] sm:min-w-0">{{ $building->name }}</td>

                    {{-- ✅ رقم المبنى --}}
                    <td class="px-4 py-3 text-right">{{ $building->building_number ?? '-' }}</td>

                    {{-- ⛔ العنوان - مخفي في الموبايل --}}
                    <td class="px-4 py-3 hidden sm:table-cell text-right">{{ $building->address }}</td>

                    {{-- ⛔ عدد الوحدات - مخفي في الموبايل --}}
                    <td class="px-4 py-3 hidden sm:table-cell text-right">{{ $building->units->count() }}</td>

                    {{-- ⛔ تاريخ الإنشاء - مخفي في الموبايل --}}
                    <td class="px-4 py-3 hidden sm:table-cell text-right">{{ $building->created_at->format('Y-m-d') }}</td>

                    {{-- 🌍 الموقع - ظاهر دائماً --}}
                    <td class="px-4 py-3 text-right">
                        @if ($building->location_url)
                            <a href="{{ $building->location_url }}" target="_blank" class="text-blue-600 underline">
                                {{ app()->getLocale() == 'ar' ? 'عرض الموقع' : 'View Map' }}
                            </a>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>

                    {{-- 🔧 الإجراءات - ظاهرة دائماً --}}
                    <td class="px-4 py-3 text-right">
                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 justify-end flex-row-reverse">
                            @can('view building details')
                                <a href="{{ route('admin.buildings.show', $building->id) }}"
                                   class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs transition duration-200">
                                    {{ app()->getLocale() == 'ar' ? 'عرض' : 'Show' }}
                                </a>
                            @endcan

                            @can('edit buildings')
                                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition duration-200">
                                    {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                                </a>
                            @endcan

                            @can('delete buildings')
                                <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('{{ $confirmMessage }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition duration-200">
                                        {{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const smartSearch = document.getElementById('smartSearch');
    const buildingSelect = document.getElementById('buildingSelect');
    const buildingsTableBody = document.getElementById('buildingsTableBody');
    const noResults = document.getElementById('noResults');
    const buildingsTable = document.getElementById('buildingsTable');
    const rows = Array.from(document.querySelectorAll('#buildingsTableBody tr'));

    // فلترة ذكية أثناء الكتابة
    smartSearch.addEventListener('input', debounce(function() {
        filterBuildings();
    }, 300));

    // فلترة عند تغيير القائمة المنسدلة
    buildingSelect.addEventListener('change', function() {
        filterBuildings();
    });

    function filterBuildings() {
        const searchTerm = smartSearch.value.toLowerCase();
        const selectedBuildingId = buildingSelect.value;
        
        let hasVisibleRows = false;

        rows.forEach(row => {
            const buildingName = row.getAttribute('data-name');
            const buildingId = row.getAttribute('data-id');
            
            const matchesSearch = searchTerm === '' || buildingName.includes(searchTerm) || buildingId.includes(searchTerm);
            const matchesSelect = selectedBuildingId === '' || buildingId === selectedBuildingId;
            
            if (matchesSearch && matchesSelect) {
                row.style.display = '';
                hasVisibleRows = true;
            } else {
                row.style.display = 'none';
            }
        });

        // إظهار رسالة عدم وجود نتائج إذا لزم الأمر
        if (!hasVisibleRows) {
            buildingsTable.classList.add('hidden');
            noResults.classList.remove('hidden');
        } else {
            buildingsTable.classList.remove('hidden');
            noResults.classList.add('hidden');
        }
    }

    // دالة لتأخير تنفيذ البحث أثناء الكتابة
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }
});
</script>

<style>
    /* تحسينات عامة للجوال */
    @media (max-width: 640px) {
        .max-w-7xl {
            padding: 0.5rem;
        }
        
        .py-6 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        /* تحسين القائمة المنسدلة للعربية */
        .rtl .form-select {
            background-position: left 0.5rem center;
            padding-right: 2.5rem;
            padding-left: 0.5rem;
        }
        
        /* تحسين حقول الإدخال */
        .form-input, .form-select {
            font-size: 16px; /* منع تكبير النص في iOS */
        }
        
        /* تحسين الجدول في الجوال */
        td:before {
            font-size: 14px;
            {{ app()->getLocale() == 'ar' ? 'right: 6px' : 'left: 6px' }};
            width: 40%;
        }
        
        td {
            padding: 0.5rem 0.5rem 0.5rem 50%;
            font-size: 14px;
        }
        
        .rtl td {
            padding: 0.5rem 50% 0.5rem 0.5rem;
        }
    }
    
    /* إصلاح السهم في القائمة المنسدلة */
    select.form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>
@endsection