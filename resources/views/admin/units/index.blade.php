@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6">
{{-- 🔍 فلتر البحث الذكي --}}
<div class="mb-6 bg-white p-4 rounded-lg shadow grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- اختيار المبنى --}}
    <div class="relative">
    <label class="block text-sm text-gray-700 mb-1">{{ __('messages.building') }}</label>
    <select id="buildingSelect"
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }} bg-white"
        style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none;">
        <option value="">{{ __('messages.all_buildings') }}</option>
        @foreach ($buildings as $building)
            <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                {{ $building->name }}
            </option>
        @endforeach
    </select>

    {{-- SVG السهم اليدوي --}}
    <div class="pointer-events-none absolute inset-y-0 flex items-center {{ app()->getLocale() == 'ar' ? 'right-0 mr-3' : 'left-0 ml-3' }}">
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>
    {{-- بحث برقم الغرفة --}}
    <div class="relative">
        <label class="block text-sm text-gray-700 mb-1">{{ __('messages.search_unit') }}</label>
        <input type="text" id="unitSearchInput" value="{{ request('search') }}" placeholder="{{ __('messages.unit_number') }}"
               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>
</div>


    {{-- بطاقات الفلاتر --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6">
        @php
            $filters = [
                'all' => ['color' => 'blue', 'icon' => '📊', 'count' => $units->count()],
                'available' => ['color' => 'green', 'icon' => '✅', 'count' => $units->where('status_label', 'available')->count()],
                'occupied' => ['color' => 'red', 'icon' => '🛌', 'count' => $units->where('status_label', 'occupied')->count()],
                'booked' => ['color' => 'purple', 'icon' => '🔒', 'count' => $units->where('status_label', 'booked')->count()],
                'maintenance' => ['color' => 'yellow', 'icon' => '🛠️', 'count' => $units->where('status_label', 'maintenance')->count()],
                'cleaning' => ['color' => 'indigo', 'icon' => '🧹', 'count' => $units->where('status_label', 'cleaning')->count()]
            ];
        @endphp

        @foreach($filters as $key => $filter)
        <div onclick="filterBy('{{ $key }}')" 
             class="cursor-pointer bg-white p-3 sm:p-4 rounded-lg shadow-sm border-l-4 border-{{ $filter['color'] }}-500 hover:bg-{{ $filter['color'] }}-50 transition-colors duration-200">
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="text-xl sm:text-2xl">{{ $filter['icon'] }}</span>
                <div class="overflow-hidden">
                    <h3 class="font-bold text-gray-600 text-xs sm:text-sm truncate">{{ __('messages.' . ($key === 'all' ? 'total_units' : $key . '_units')) }}</h3>
                    <p class="text-lg sm:text-xl font-bold text-{{ $filter['color'] }}-600">{{ $filter['count'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- العنوان والإضافة --}}
    <div class="flex flex-col {{ app()->getLocale() === 'ar' ? 'sm:flex-row-reverse' : 'sm:flex-row' }} justify-between items-start gap-3 sm:gap-4 mb-4 sm:mb-6">
        <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ __('messages.unit_list') }}</h1>
            <p class="text-gray-500 text-sm">{{ __('messages.total_units') }}: {{ $units->count() }}</p>
        </div>
        <a href="{{ route('admin.units.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg inline-flex items-center transition-colors text-sm sm:text-base w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('messages.add_unit') }}
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 flex items-center text-sm sm:text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- جدول الغرف --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.building') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.unit_number') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.floor') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.rent_price') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.status') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.tenant') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($units as $unit)
                    <tr class="hover:bg-gray-50 transition-colors duration-150" data-status="{{ $unit->status_label }}" data-building="{{ $unit->building_id }}" data-unit-number="{{ $unit->unit_number }}">
                        {{-- بيانات المبنى (عرض للشاشات الكبيرة فقط) --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <div class="text-sm font-medium text-gray-900">{{ $unit->building->name }}</div>
                        </td>
                        
                        {{-- رقم الغرفة --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $unit->unit_number }}</span>
                        </td>
                        
                        {{-- الطابق --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <span class="text-sm text-gray-500">{{ $unit->floor }} {{ __('messages.floor') }}</span>
                        </td>
                        
                        {{-- سعر الإيجار --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <span class="text-sm font-medium text-gray-900">{{ number_format($unit->rent_price) }} {{ __('messages.currency') }}</span>
                        </td>
                        
                        {{-- الحالة --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            @php
                                $statusColors = [
                                    'available' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                    'occupied' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                    'booked' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                    'maintenance' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                    'cleaning' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800']
                                ];
                                $status = $statusColors[$unit->status_label] ?? $statusColors['available'];
                            @endphp
                            <span class="px-2 py-1 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-xs font-semibold">
                                {{ __('messages.' . $unit->status_label) }}
                            </span>
                        </td>
                        
                        {{-- اسم المستأجر (عرض للشاشات الكبيرة فقط) --}}
                        <td class="px-4 sm:px-6 py-4 hidden sm:table-cell {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            @if($unit->status_label === 'occupied' && $unit->contracts->last()?->tenant)
                                <span class="text-sm font-medium text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $unit->contracts->last()->tenant->name }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        
                        {{-- عرض للجوال (بطاقة لكل وحدة) --}}
                        <td class="px-4 py-4 sm:hidden">
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-start">
                                    <span class="font-medium text-gray-900">{{ $unit->building->name }}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $unit->unit_number }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ $unit->floor }} {{ __('messages.floor') }}</span>
                                    <span class="text-sm font-medium">{{ number_format($unit->rent_price) }} {{ __('messages.currency') }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center mt-1">
                                    <span class="px-2 py-1 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-xs font-semibold">
                                        {{ __('messages.' . $unit->status_label) }}
                                    </span>
                                </div>
                                
                                {{-- اسم المستأجر (عرض للجوال) --}}
                                <div class="text-sm mt-1">
                                    @if($unit->status_label === 'occupied' && $unit->contracts->last()?->tenant)
                                        <span class="text-red-600 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $unit->contracts->last()->tenant->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        {{-- الإجراءات (تظهر في جميع الأحجام) --}}
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex {{ app()->getLocale() === 'ar' ? 'justify-end' : 'justify-start' }} sm:justify-center gap-1 sm:gap-2">
                                @if($unit->status_label === 'available' || $unit->status_label === 'booked')
                                <a href="{{ route('admin.contracts.create', ['unit_id' => $unit->id]) }}" class="text-green-600 hover:text-green-900 p-1 rounded-full hover:bg-green-50" title="{{ __('messages.rent_unit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </a>
                                @endif
                                
                                <a href="{{ route('admin.units.edit', $unit->id) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50" title="{{ __('messages.edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete') }}')" class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50" title="{{ __('messages.delete') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterBy(status) {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const current = row.getAttribute('data-status');
            row.style.display = (status === 'all' || status === current) ? '' : 'none';
        });
        
        // Update active filter cards
        document.querySelectorAll('[onclick^="filterBy"]').forEach(card => {
            if (card.getAttribute('onclick').includes(status)) {
                card.classList.add('ring-1', 'ring-offset-1', `ring-${card.classList.contains('border-blue-500') ? 'blue' : 
                                                           card.classList.contains('border-green-500') ? 'green' :
                                                           card.classList.contains('border-red-500') ? 'red' :
                                                           card.classList.contains('border-yellow-500') ? 'yellow' :
                                                           card.classList.contains('border-purple-500') ? 'purple' : 'indigo'}-500`);
            } else {
                card.classList.remove('ring-1', 'ring-offset-1', 'ring-blue-500', 'ring-green-500', 'ring-red-500', 'ring-yellow-500', 'ring-purple-500', 'ring-indigo-500');
            }
        });
    }

    // فلتر المباني
    document.getElementById('buildingSelect').addEventListener('change', function() {
        const buildingId = this.value;
        const search = document.getElementById('unitSearchInput').value;
        window.location.href = `?building_id=${buildingId}&search=${encodeURIComponent(search)}`;
    });

    // بحث رقم الغرفة
    document.getElementById('unitSearchInput').addEventListener('input', function() {
        const search = this.value;
        const buildingId = document.getElementById('buildingSelect').value;
        clearTimeout(this.delay);
        this.delay = setTimeout(() => {
            window.location.href = `?building_id=${buildingId}&search=${encodeURIComponent(search)}`;
        }, 600);
    });
</script>

<style>
    @media (max-width: 640px) {
        /* تحسينات عامة للجوال */
        .p-4 {
            padding: 1rem;
        }
        
        /* تحسين القائمة المنسدلة */
        select {
            background-position: left 0.5rem center;
            padding-right: 2.5rem;
        }
        
        /* تحسين حقول الإدخال */
        input, select {
            font-size: 16px;
        }
        
        /* تحسين البطاقات */
        .grid-cols-2 > div {
            padding: 0.75rem;
        }
    }
</style>
@endsection