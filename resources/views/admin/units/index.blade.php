@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-6">
        {{-- 🔍 فلتر البحث الذكي --}}
        <div class="mb-6 bg-white p-4 rounded-lg shadow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- 🏢 اختيار المبنى --}}
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
                {{-- SVG السهم --}}
                <div
                    class="pointer-events-none absolute inset-y-0 flex items-center {{ app()->getLocale() == 'ar' ? 'right-0 mr-3' : 'left-0 ml-3' }}">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- 🏷️ اختيار نوع الوحدة --}}
            <div class="relative">
                <label class="block text-sm text-gray-700 mb-1">{{ __('messages.unit_type') }}</label>
                <select id="unitTypeSelect"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }} bg-white"
                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none;">
                    <option value="">{{ __('messages.all_unit_types') }}</option>
                    @foreach ($unitTypes as $type)
                        <option value="{{ $type }}" {{ request('unit_type') == $type ? 'selected' : '' }}>
                            {{ __('messages.' . $type) }}
                        </option>
                    @endforeach
                </select>
                {{-- SVG السهم --}}
                <div
                    class="pointer-events-none absolute inset-y-0 flex items-center {{ app()->getLocale() == 'ar' ? 'right-0 mr-3' : 'left-0 ml-3' }}">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- 🔎 بحث برقم الغرفة --}}
            <div class="relative">
                <label class="block text-sm text-gray-700 mb-1">{{ __('messages.search_unit') }}</label>
                <input type="text" id="unitSearchInput" value="{{ request('search') }}"
                    placeholder="{{ __('messages.unit_number') }}"
                    class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- بطاقات الفلاتر --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6">
            @php
                $filters = [
                    'all' => ['color' => 'blue', 'icon' => '📊', 'count' => count($units)],
                    'available' => [
                        'color' => 'green',
                        'icon' => '✅',
                        'count' => collect($units)->filter(fn($u) => $u['unit']->status === 'available')->count(),
                    ],
                    'occupied' => [
                        'color' => 'red',
                        'icon' => '🛌',
                        'count' => collect($units)->filter(fn($u) => $u['unit']->status === 'occupied')->count(),
                    ],
                    'booked' => [
                        'color' => 'purple',
                        'icon' => '🔒',
                        'count' => collect($units)->filter(fn($u) => $u['unit']->status === 'booked')->count(),
                    ],
                    'maintenance' => [
                        'color' => 'yellow',
                        'icon' => '🛠️',
                        'count' => collect($units)->filter(fn($u) => $u['unit']->status === 'maintenance')->count(),
                    ],
                    'cleaning' => [
                        'color' => 'indigo',
                        'icon' => '🧹',
                        'count' => collect($units)->filter(fn($u) => $u['unit']->status === 'cleaning')->count(),
                    ],
                ];
            @endphp


            @foreach ($filters as $key => $filter)
                <div onclick="filterBy('{{ $key }}')"
                    class="cursor-pointer bg-white p-3 sm:p-4 rounded-lg shadow-sm border-l-4 border-{{ $filter['color'] }}-500 hover:bg-{{ $filter['color'] }}-50 transition-colors duration-200">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="text-xl sm:text-2xl">{{ $filter['icon'] }}</span>
                        <div class="overflow-hidden">
                            <h3 class="font-bold text-gray-600 text-xs sm:text-sm truncate">
                                {{ __('messages.' . ($key === 'all' ? 'total_units' : $key . '_units')) }}</h3>
                            <p class="text-lg sm:text-xl font-bold text-{{ $filter['color'] }}-600">{{ $filter['count'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- العنوان والإضافة --}}
        <div
            class="flex flex-col {{ app()->getLocale() === 'ar' ? 'sm:flex-row-reverse' : 'sm:flex-row' }} justify-between items-start gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ __('messages.unit_list') }}</h1>
                <p class="text-gray-500 text-sm">{{ __('messages.total_units') }}: {{ $units->count() }}</p>
            </div>
            @can('create units')
                <a href="{{ route('admin.units.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg inline-flex items-center transition-colors text-sm sm:text-base w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('messages.add_unit') }}
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div
                class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 flex items-center text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- جدول الغرف --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            {{-- عرض البطاقات للجوال --}}
            <div class="sm:hidden">
                @foreach ($units as $row)
                    @php
                        $unit = $row['unit'];
                        $rent = $row['rent'];
                        $hasDiscount = $row['has_discount'];
                        $originalRent = $row['original_rent'] ?? null;
                        $contract = $unit->contracts->last();
                        $tenant = optional($contract)->tenant;
                        $statusColors = [
                            'available' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                            'occupied' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                            'booked' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                            'maintenance' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                            'cleaning' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                        ];
                        $status = $statusColors[$unit->status] ?? $statusColors['available'];
                    @endphp

                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-3 mx-4 hover:shadow-md transition-shadow duration-200"
                        data-status="{{ $unit->status }}" data-building="{{ $unit->building_id }}"
                        data-unit-number="{{ $unit->unit_number }}">

                        {{-- الصف العلوي: المبنى ورقم الوحدة --}}
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="font-medium text-gray-800">{{ $unit->building->name }}</span>
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                #{{ $unit->unit_number }}
                            </span>
                        </div>

                        {{-- الصف الأوسط: نوع الوحدة والسعر --}}
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">
                                    {{ __('messages.unit_type_' . $unit->unit_type) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ number_format($rent, 2) }} {{ __('messages.currency') }}
                                </span>
                                @if ($hasDiscount && $originalRent && $originalRent != $rent)
                                    <br>
                                    <span class="text-xs text-gray-400 line-through">
                                        {{ number_format($originalRent, 2) }} {{ __('messages.currency') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- الصف السفلي: الحالة والمستأجر --}}
                        <div class="flex justify-between items-center mb-3">
                            <span
                                class="px-2 py-1 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-xs font-semibold">
                                {{ __('messages.' . $unit->status) }}
                            </span>

                            @if ($unit->status === 'occupied' && $tenant)
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-700 mr-2">{{ $tenant->name }}</span>
                                    <a href="{{ route('admin.tenants.show', $tenant->id) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </div>

                        {{-- أزرار الإجراءات --}}
                        <div class="flex justify-end items-center pt-3 border-t border-gray-100 gap-2">
                            {{-- زر التأجير --}}
                            @if ($unit->status === 'available' || $unit->status === 'booked')
                                <a href="{{ route('admin.contracts.create', ['unit_id' => $unit->id]) }}"
                                    class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
                                    title="{{ __('messages.rent_unit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </a>
                            @endif

                            {{-- زر التعديل --}}
                            @can('edit units')
                                <a href="{{ route('admin.units.edit', $unit->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
                                    title="{{ __('messages.edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            @endcan

                            {{-- زر العرض --}}
                            @can('view unit details')
                                <a href="{{ route('admin.units.show', $unit->id) }}"
                                    class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors"
                                    title="{{ __('messages.view') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            @endcan

                            {{-- زر الحذف --}}
                            @can('delete units')
                                <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                        title="{{ __('messages.delete') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- عرض الجدول للشاشات الكبيرة --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.building') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.unit_number') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.unit_type') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.rent_price') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.status') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                {{ __('messages.tenant') }}</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($units as $row)
                            @php
                                $unit = $row['unit'];
                                $rent = $row['rent'];
                                $hasDiscount = $row['has_discount'];
                                $originalRent = $row['original_rent'] ?? null;
                                $contract = $unit->contracts->last();
                                $tenant = optional($contract)->tenant;
                                $statusColors = [
                                    'available' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                    'occupied' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                    'booked' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                    'maintenance' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                    'cleaning' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                                ];
                                $status = $statusColors[$unit->status] ?? $statusColors['available'];
                            @endphp

                            <tr class="hover:bg-gray-50 transition-colors duration-150" data-status="{{ $unit->status }}"
                                data-building="{{ $unit->building_id }}" data-unit-number="{{ $unit->unit_number }}">

                                {{-- اسم المبنى --}}
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 text-right">
                                    {{ $unit->building->name }}
                                </td>

                                {{-- رقم الغرفة --}}
                                <td class="px-4 py-4 text-sm text-gray-900 text-right">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ $unit->unit_number }}
                                    </span>
                                </td>

                                {{-- نوع الغرفة --}}
                                <td class="px-4 py-4 text-sm text-gray-900 font-medium text-right">
                                    {{ __('messages.unit_type_' . $unit->unit_type) }}
                                </td>

                                {{-- السعر --}}
                                <td class="px-4 py-4 text-sm text-right">
                                    <span class="text-sm font-semibold text-blue-600">
                                        {{ number_format($rent, 2) }} {{ __('messages.currency') }}
                                    </span>
                                    @if ($hasDiscount && $originalRent && $originalRent != $rent)
                                        <br>
                                        <span class="text-xs text-gray-400 line-through">
                                            {{ number_format($originalRent, 2) }} {{ __('messages.currency') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- الحالة --}}
                                <td class="px-4 py-4 text-sm text-right">
                                    <span
                                        class="px-2 py-1 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-xs font-semibold">
                                        {{ __('messages.' . $unit->status) }}
                                    </span>
                                </td>

                                {{-- المستأجر --}}
                                <td class="px-4 py-4 text-sm text-right">
                                    @if ($unit->status === 'occupied' && $tenant)
                                        <span class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $tenant->name }}
                                            <a href="{{ route('admin.tenants.show', $tenant->id) }}"
                                                class="ml-1 text-blue-600 hover:text-blue-800"
                                                title="{{ __('messages.view') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>

                                {{-- الأكشنات --}}
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- زر التأجير --}}
                                        <a href="{{ route('admin.contracts.create', ['unit_id' => $unit->id]) }}"
                                            class="{{ $unit->status === 'available' || $unit->status === 'booked' ? 'text-green-600 hover:text-green-900' : 'invisible' }} p-1 rounded-full hover:bg-green-50 transition-colors"
                                            title="{{ __('messages.rent_unit') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </a>

                                        {{-- زر التعديل --}}
                                        @can('edit units')
                                            <a href="{{ route('admin.units.edit', $unit->id) }}"
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50 transition-colors"
                                                title="{{ __('messages.edit') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- زر العرض --}}
                                        @can('view unit details')
                                            <a href="{{ route('admin.units.show', $unit->id) }}"
                                                class="text-gray-600 hover:text-gray-900 p-1 rounded-full hover:bg-gray-100 transition-colors"
                                                title="{{ __('messages.view') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- زر الحذف --}}
                                        @can('delete units')
                                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50 transition-colors"
                                                    title="{{ __('messages.delete') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
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
        </div>

        <script>
            function filterBy(status) {
                // إظهار/إخفاء الصفوف في الجدول والموبايل
                const rows = document.querySelectorAll('tbody tr, .sm\\:hidden .bg-white');
                rows.forEach(row => {
                    const current = row.getAttribute('data-status');
                    row.style.display = (status === 'all' || status === current) ? '' : 'none';
                });

                // تحديث البطاقات النشطة
                document.querySelectorAll('[onclick^="filterBy"]').forEach(card => {
                    const cardStatus = card.getAttribute('onclick').match(/'([^']+)'/)[1];
                    if (status === cardStatus) {
                        card.classList.add('ring-1', 'ring-offset-1', 'ring-opacity-50',
                            `ring-${card.classList.contains('border-blue-500') ? 'blue' : 
                       card.classList.contains('border-green-500') ? 'green' :
                       card.classList.contains('border-red-500') ? 'red' :
                       card.classList.contains('border-yellow-500') ? 'yellow' :
                       card.classList.contains('border-purple-500') ? 'purple' : 'indigo'}-500`);
                    } else {
                        card.classList.remove('ring-1', 'ring-offset-1', 'ring-opacity-50',
                            'ring-blue-500', 'ring-green-500', 'ring-red-500',
                            'ring-yellow-500', 'ring-purple-500', 'ring-indigo-500');
                    }
                });
            }

            // ✅ الكود الخاص بالفلاتر الأخرى (خارج دالة filterBy)
            document.getElementById('buildingSelect').addEventListener('change', function() {
                const buildingId = this.value;
                const search = document.getElementById('unitSearchInput').value;
                window.location.href = `?building_id=${buildingId}&search=${encodeURIComponent(search)}`;
            });

            document.getElementById('unitSearchInput').addEventListener('input', function() {
                const search = this.value;
                const buildingId = document.getElementById('buildingSelect').value;
                clearTimeout(this.delay);
                this.delay = setTimeout(() => {
                    window.location.href = `?building_id=${buildingId}&search=${encodeURIComponent(search)}`;
                }, 600);
            });

            document.getElementById('unitTypeSelect').addEventListener('change', function() {
                const buildingId = document.getElementById('buildingSelect').value;
                const search = document.getElementById('unitSearchInput').value;
                const unitType = this.value;
                window.location.href =
                    `?building_id=${buildingId}&search=${encodeURIComponent(search)}&unit_type=${unitType}`;
            });
        </script>

        <style>
            /* تحسينات للبطاقات على الجوال */
            @media (max-width: 640px) {
                .unit-card-mobile {
                    transition: all 0.3s ease;
                }

                .unit-card-mobile:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                /* تحسينات للأيقونات على الجوال */
                .action-icon-mobile {
                    transition: all 0.2s ease;
                }

                .action-icon-mobile:hover {
                    transform: scale(1.1);
                }
            }

            /* تحسينات للغة العربية */
            [dir="rtl"] .unit-card-mobile {
                text-align: right;
            }

            [dir="rtl"] .action-buttons-mobile {
                justify-content: flex-start;
            }
        </style>
        {{-- 👁️ Modal عرض بيانات المستأجر --}}
        <div id="tenantModal" x-data="{ showTenantModal: false, tenantHtml: '' }" x-cloak>
            <div x-show="showTenantModal"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center" x-transition.opacity>
                <div @click.away="showTenantModal = false"
                    class="bg-white max-w-2xl w-full mx-4 sm:mx-0 rounded-lg shadow-lg p-6 relative z-50 overflow-y-auto max-h-[90vh]"
                    x-transition>
                    <button @click="showTenantModal = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 8.586l4.95-4.95 1.414 1.414L11.414 10l4.95 4.95-1.414 1.414L10 11.414l-4.95 4.95-1.414-1.414L8.586 10 3.636 5.05l1.414-1.414L10 8.586z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-html="tenantHtml"></div>
                </div>
            </div>
        </div>
    @endsection
