@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        {{-- 🔧 العنوان --}}
        <div
            class="bg-gradient-to-r from-blue-500 to-blue-300 text-white p-6 rounded-lg shadow-md mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-2xl font-bold">{{ __('messages.maintenance_requests') }}</h1>
            </div>
            <a href="{{ route('admin.maintenance_requests.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow-md transition duration-300 whitespace-nowrap flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('messages.add_new_request') }}
            </a>
        </div>

        {{-- 🎚️ فلتر Tabs حسب الحالة --}}
        <div class="bg-white p-1 rounded-lg shadow-md mb-6 overflow-x-auto">
            <div class="flex space-x-1 min-w-max">
                @php
                    $statusTabs = [
                        'all' => [
                            'color' => 'bg-gray-100 hover:bg-gray-200',
                            'active' => 'bg-gray-300',
                            'text' => 'text-gray-800',
                        ],
                        'new' => [
                            'color' => 'bg-yellow-100 hover:bg-yellow-200',
                            'active' => 'bg-yellow-300',
                            'text' => 'text-yellow-800',
                        ],
                        'in_progress' => [
                            'color' => 'bg-blue-100 hover:bg-blue-200',
                            'active' => 'bg-blue-300',
                            'text' => 'text-blue-800',
                        ],
                        'completed' => [
                            'color' => 'bg-green-100 hover:bg-green-200',
                            'active' => 'bg-green-300',
                            'text' => 'text-green-800',
                        ],
                        'rejected' => [
                            'color' => 'bg-red-100 hover:bg-red-200',
                            'active' => 'bg-red-300',
                            'text' => 'text-red-800',
                        ],
                        'delayed' => [
                            'color' => 'bg-orange-100 hover:bg-orange-200',
                            'active' => 'bg-orange-300',
                            'text' => 'text-orange-800',
                        ],
                        'waiting_materials' => [
                            'color' => 'bg-purple-100 hover:bg-purple-200',
                            'active' => 'bg-purple-300',
                            'text' => 'text-purple-800',
                        ],
                        'customer_unavailable' => [
                            'color' => 'bg-pink-100 hover:bg-pink-200',
                            'active' => 'bg-pink-300',
                            'text' => 'text-pink-800',
                        ],
                        'other' => [
                            'color' => 'bg-gray-100 hover:bg-gray-200',
                            'active' => 'bg-gray-300',
                            'text' => 'text-gray-800',
                        ],
                    ];
                @endphp

                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap flex items-center gap-2 
                      {{ !request('status') ? $statusTabs['all']['active'] : $statusTabs['all']['color'] }} {{ $statusTabs['all']['text'] }}">
                    <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                    {{ __('messages.all_statuses') }}
                    <span class="bg-white text-gray-800 text-xs px-2 py-0.5 rounded-full ml-1">{{ $totalCount }}</span>
                </a>

                @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                    @if (isset($statusCounts[$status]))
                        <a href="{{ request()->fullUrlWithQuery(['status' => $status]) }}"
                            class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap flex items-center gap-2 
                          {{ request('status') == $status ? $statusTabs[$status]['active'] : $statusTabs[$status]['color'] }} {{ $statusTabs[$status]['text'] }}">
                            <span class="w-2 h-2 rounded-full {{ $statusTabs[$status]['active'] }}"></span>
                            {{ __('messages.status_' . $status) }}
                            <span
                                class="bg-white {{ $statusTabs[$status]['text'] }} text-xs px-2 py-0.5 rounded-full ml-1">{{ $statusCounts[$status] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- 🔍 الفلاتر المتقدمة --}}
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <form id="filterForm" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-center">
                {{-- المبنى --}}
                <div class="relative">
                    <label
                        class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.filter_by_building') }}</label>
                    <div class="relative">
                        <select name="building_id"
                            class="filter-select w-full border rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                            <option value="">{{ __('messages.all_buildings') }}</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}"
                                    {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- نوع العطل (المهمة الفرعية) --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.sub_specialty') }}</label>
                    <div class="relative">
                        <select name="sub_specialty_id"
                            class="filter-select w-full border rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                            <option value="">{{ __('messages.all_sub_specialties') }}</option>
                            @foreach ($subSpecialties as $sub)
                                <option value="{{ $sub->id }}"
                                    {{ request('sub_specialty_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->parent->name ?? '❓' }} - {{ $sub->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>


                {{-- الفني --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.technician') }}</label>
                    <div class="relative">
                        <select name="technician_id"
                            class="filter-select w-full border rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                            <option value="">{{ __('messages.all_technicians') }}</option>
                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->id }}"
                                    {{ request('technician_id') == $technician->id ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- 🔢 بحث برقم الغرفة --}}
                <div class="relative">
                    <label
                        class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.search_by_unit_number') }}</label>
                    <div class="relative">
                        <input type="text" name="unit_number" placeholder="123" value="{{ request('unit_number') }}"
                            class="filter-input w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} text-gray-500 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- حقول مخفية للحفاظ على حالة الفلترة --}}
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if (request('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif
            </form>
        </div>

        {{-- مؤشر التحميل --}}
        <div id="loadingIndicator"
            class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center gap-4">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-lg font-medium">{{ __('messages.loading') }}...</span>
            </div>
        </div>

        {{-- 📋 عرض الطلبات (Tabs للجوال/جدول للشاشات الكبيرة) --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold mb-2 sm:mb-0">{{ __('messages.requests_table') }}</h2>
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-500 whitespace-nowrap">{{ __('messages.total_requests') }}:
                        {{ $requests->total() }}</p>
                    <div class="relative">
                        <select onchange="updatePerPage(this.value)"
                            class="border rounded px-3 py-1 pr-6 text-xs focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                                {{ __('messages.items') }}</option>
                            <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25
                                {{ __('messages.items') }}</option>
                            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50
                                {{ __('messages.items') }}</option>
                            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100
                                {{ __('messages.items') }}</option>
                        </select>
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- عرض Tabs للشاشات الصغيرة --}}
            <div class="md:hidden">
                @forelse($requests as $request)
                    @php
                        $statusTextColors = [
                            'new' => 'bg-yellow-100 text-yellow-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'delayed' => 'bg-orange-100 text-orange-800',
                            'waiting_materials' => 'bg-purple-100 text-purple-800',
                            'customer_unavailable' => 'bg-pink-100 text-pink-800',
                            'other' => 'bg-gray-100 text-gray-800',
                        ];
                    @endphp
                    <div class="border-b p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                                <span class="font-medium">#{{ $request->id }}</span>
                            </div>
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $statusTextColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ __('messages.status_' . $request->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                            <div>
                                <span class="text-gray-500">{{ __('messages.building') }}:</span>
                                <span>{{ $request->building->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">{{ __('messages.unit') }}:</span>
                                <span>{{ $request->unit->unit_number ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">{{ __('messages.category') }}:</span>
                                <span>{{ $request->subSpecialty->parent->name ?? '-' }} -
                                    {{ $request->subSpecialty->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">{{ __('messages.technician') }}:</span>
                                <span>{{ $request->technician->name ?? __('messages.no_technician') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                class="bg-gray-100 px-3 py-1 rounded text-xs hover:bg-gray-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('messages.show') }}
                            </a>
                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-xs hover:bg-blue-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                {{ __('messages.edit') }}
                            </a>
                            @if ($request->image)
                                <a href="{{ asset('storage/' . $request->image) }}" target="_blank"
                                    class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded text-xs hover:bg-indigo-200 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('messages.image') }}
                                </a>
                            @endif
                        </div>

                        <form method="POST"
                            action="{{ route('admin.maintenance_requests.update_status', $request->id) }}"
                            class="mt-3">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()"
                                class="w-full text-xs border rounded px-2 py-1 pr-6 focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                                @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                    <option value="{{ $status }}"
                                        {{ $request->status == $status ? 'selected' : '' }}>
                                        {{ __('messages.status_' . $status) }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        {{ __('messages.no_requests_found') }}
                    </div>
                @endforelse
            </div>

            {{-- عرض الجدول للشاشات الكبيرة --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.status') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.id') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.building') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.unit') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.category') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.technician') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.actions') }}</th>
                            <th class="px-4 py-3 whitespace-nowrap">{{ __('messages.change_status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($requests as $request)
                            @php
                                $colors = [
                                    'new' => 'bg-yellow-400 animate-pulse',
                                    'in_progress' => 'bg-blue-400 animate-pulse',
                                    'completed' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    'delayed' => 'bg-orange-400',
                                    'waiting_materials' => 'bg-purple-400',
                                    'customer_unavailable' => 'bg-pink-400',
                                    'other' => 'bg-gray-400',
                                ];
                                $statusColors = [
                                    'new' => 'bg-yellow-100 text-yellow-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'delayed' => 'bg-orange-100 text-orange-800',
                                    'waiting_materials' => 'bg-purple-100 text-purple-800',
                                    'customer_unavailable' => 'bg-pink-100 text-pink-800',
                                    'other' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-2">
                                        <span
                                            class="w-3 h-3 rounded-full {{ $colors[$request->status] ?? 'bg-gray-300' }}"
                                            title="{{ __('messages.status_' . $request->status) }}"></span>
                                        <span
                                            class="px-2 py-1 rounded-full text-xs {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ __('messages.status_' . $request->status) }}
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium">#{{ $request->id }}</td>
                                <td class="px-4 py-3">{{ $request->building->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $request->unit->unit_number ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    {{ $request->subSpecialty->parent->name ?? '-' }} -
                                    {{ $request->subSpecialty->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1">
                                        @if ($request->technician)
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            {{ $request->technician->name }}
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                            {{ __('messages.no_technician') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                            class="bg-gray-100 px-2 py-1 rounded text-xs hover:bg-gray-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ __('messages.show') }}
                                        </a>
                                        <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
                                            class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs hover:bg-blue-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            {{ __('messages.edit') }}
                                        </a>
                                        @if ($request->image)
                                            <a href="{{ asset('storage/' . $request->image) }}" target="_blank"
                                                class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs hover:bg-indigo-200 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ __('messages.image') }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST"
                                        action="{{ route('admin.maintenance_requests.update_status', $request->id) }}"
                                        class="relative">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-xs border rounded px-2 py-1 pr-6 focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                                            @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $request->status == $status ? 'selected' : '' }}>
                                                    {{ __('messages.status_' . $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-500">
                                    {{ __('messages.no_requests_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($requests->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t">
                    {{ $requests->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // جميع عناصر الفلتر
            const filterForm = document.getElementById('filterForm');
            const filterSelects = document.querySelectorAll('.filter-select');
            const filterInput = document.querySelector('.filter-input');
            const loadingIndicator = document.getElementById('loadingIndicator');

            // إضافة حدث تغيير لجميع عناصر الفلتر
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    submitFilterForm();
                });
            });

            // إضافة حدث إدخال لبحث رقم الغرفة مع تأخير
            if (filterInput) {
                let searchTimer;
                filterInput.addEventListener('input', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        submitFilterForm();
                    }, 500); // تأخير 500 مللي ثانية بعد آخر كتابة
                });
            }

            // دعم زر الإدخال في حقل البحث
            filterInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitFilterForm();
                }
            });

            // دالة لإرسال النموذج
            function submitFilterForm() {
                loadingIndicator.classList.remove('hidden');

                // إضافة تأثير التعتيم أثناء التحميل
                document.body.style.opacity = '0.8';

                // إرسال النموذج
                filterForm.submit();
            }
        });

        // تحديث عدد العناصر المعروضة لكل صفحة
        function updatePerPage(value) {
            const form = document.getElementById('filterForm');
            let perPageInput = form.querySelector('input[name="per_page"]');

            if (!perPageInput) {
                perPageInput = document.createElement('input');
                perPageInput.type = 'hidden';
                perPageInput.name = 'per_page';
                form.appendChild(perPageInput);
            }

            perPageInput.value = value;
            form.submit();
        }
    </script>
@endsection
