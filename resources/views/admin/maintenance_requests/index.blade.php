@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        {{-- 🔧 العنوان --}}
        <div
            class="bg-gradient-to-r from-blue-500 to-blue-300 dark:from-blue-700 dark:to-blue-900 text-white p-6 rounded-lg shadow-md mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-2xl font-bold">{{ __('messages.maintenance_requests') }}</h1>
            </div>
            <a href="{{ route('admin.maintenance_requests.create') }}"
                class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white px-6 py-2 rounded-md text-sm font-semibold shadow-md transition duration-300 whitespace-nowrap flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('messages.add_new_request') }}
            </a>
        </div>

        {{-- 🎚️ فلتر Tabs حسب الحالة --}}
        <div class="bg-white dark:bg-gray-800 p-1 rounded-lg shadow-md mb-6 overflow-x-auto">
            <div class="flex space-x-1 rtl:space-x-reverse min-w-max">
                @php
                    $statusTabs = [
                        'all' => [
                            'color' => 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600',
                            'active' => 'bg-gray-300 dark:bg-gray-600',
                            'text' => 'text-gray-800 dark:text-gray-200',
                        ],
                        'new' => [
                            'color' => 'bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800',
                            'active' => 'bg-yellow-300 dark:bg-yellow-700',
                            'text' => 'text-yellow-800 dark:text-yellow-200',
                        ],
                        'in_progress' => [
                            'color' => 'bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800',
                            'active' => 'bg-blue-300 dark:bg-blue-700',
                            'text' => 'text-blue-800 dark:text-blue-200',
                        ],
                        'completed' => [
                            'color' => 'bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800',
                            'active' => 'bg-green-300 dark:bg-green-700',
                            'text' => 'text-green-800 dark:text-green-200',
                        ],
                        'rejected' => [
                            'color' => 'bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800',
                            'active' => 'bg-red-300 dark:bg-red-700',
                            'text' => 'text-red-800 dark:text-red-200',
                        ],
                        'delayed' => [
                            'color' => 'bg-orange-100 hover:bg-orange-200 dark:bg-orange-900 dark:hover:bg-orange-800',
                            'active' => 'bg-orange-300 dark:bg-orange-700',
                            'text' => 'text-orange-800 dark:text-orange-200',
                        ],
                        'waiting_materials' => [
                            'color' => 'bg-purple-100 hover:bg-purple-200 dark:bg-purple-900 dark:hover:bg-purple-800',
                            'active' => 'bg-purple-300 dark:bg-purple-700',
                            'text' => 'text-purple-800 dark:text-purple-200',
                        ],
                        'customer_unavailable' => [
                            'color' => 'bg-pink-100 hover:bg-pink-200 dark:bg-pink-900 dark:hover:bg-pink-800',
                            'active' => 'bg-pink-300 dark:bg-pink-700',
                            'text' => 'text-pink-800 dark:text-pink-200',
                        ],
                        'other' => [
                            'color' => 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600',
                            'active' => 'bg-gray-300 dark:bg-gray-600',
                            'text' => 'text-gray-800 dark:text-gray-200',
                        ],
                    ];
                @endphp

                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                    class="px-2 sm:px-4 py-2 rounded-md text-xs sm:text-sm font-medium transition-all duration-200 whitespace-nowrap flex items-center gap-2 
                      {{ !request('status') ? $statusTabs['all']['active'] : $statusTabs['all']['color'] }} {{ $statusTabs['all']['text'] }}">
                    <span class="w-2 h-2 rounded-full bg-gray-500 dark:bg-gray-400"></span>
                    {{ __('messages.all_statuses') }}
                    <span class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 text-xs px-2 py-0.5 rounded-full ml-1">{{ $totalCount }}</span>
                </a>

                @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                    @if (isset($statusCounts[$status]))
                        <a href="{{ request()->fullUrlWithQuery(['status' => $status]) }}"
                            class="px-2 sm:px-4 py-2 rounded-md text-xs sm:text-sm font-medium transition-all duration-200 whitespace-nowrap flex items-center gap-2 
                          {{ request('status') == $status ? $statusTabs[$status]['active'] : $statusTabs[$status]['color'] }} {{ $statusTabs[$status]['text'] }}">
                            <span class="w-2 h-2 rounded-full {{ $statusTabs[$status]['active'] }}"></span>
                            <span class="hidden sm:inline">{{ __('messages.status_' . $status) }}</span>
                            <span class="sm:hidden">{{ substr(__('messages.status_' . $status), 0, 3) }}</span>
                            <span
                                class="bg-white dark:bg-gray-900 {{ $statusTabs[$status]['text'] }} text-xs px-2 py-0.5 rounded-full ml-1">{{ $statusCounts[$status] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- 🔍 الفلاتر المتقدمة --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mb-6">
            <form id="filterForm" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-center">
                {{-- المبنى --}}
                <div class="relative">
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.filter_by_building') }}</label>
                    <div class="relative">
                        <select name="building_id"
                            class="filter-select w-full border dark:border-gray-600 rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
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
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- نوع العطل (المهمة الفرعية) --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.sub_specialty') }}</label>
                    <div class="relative">
                        <select name="sub_specialty_id"
                            class="filter-select w-full border dark:border-gray-600 rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
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
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- الفني --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.technician') }}</label>
                    <div class="relative">
                        <select name="technician_id"
                            class="filter-select w-full border dark:border-gray-600 rounded px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
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
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- 🔢 بحث برقم الغرفة --}}
                <div class="relative">
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.search_by_unit_number') }}</label>
                    <div class="relative">
                        <input type="text" name="unit_number" placeholder="123" value="{{ request('unit_number') }}"
                            class="filter-input w-full border dark:border-gray-600 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                        <button type="submit"
                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
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
            class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex items-center gap-4">
                <svg class="animate-spin h-8 w-8 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.loading') }}...</span>
            </div>
        </div>

        {{-- 📋 عرض الطلبات (Tabs للجوال/جدول للشاشات الكبيرة) --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-2 sm:mb-0 text-gray-900 dark:text-gray-100">{{ __('messages.requests_table') }}</h2>
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('messages.total_requests') }}:
                        {{ $requests->total() }}</p>
                    <div class="relative">
                        <select onchange="updatePerPage(this.value)"
                            class="border dark:border-gray-600 rounded px-3 py-1 pr-6 text-xs focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
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
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- عرض Tabs للشاشات الصغيرة --}}
            <div class="lg:hidden">
                @forelse($requests as $request)
                    @php
                        $statusTextColors = [
                            'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            'delayed' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                            'waiting_materials' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                            'customer_unavailable' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                            'other' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        ];
                    @endphp
                    <div class="border-b dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-500 dark:bg-gray-400"></span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">#{{ $request->id }}</span>
                            </div>
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $statusTextColors[$request->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ __('messages.status_' . $request->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mb-3">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.building') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $request->building->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.unit') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $request->unit->unit_number ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.category') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $request->subSpecialty->parent->name ?? '-' }} -
                                    {{ $request->subSpecialty->name ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.technician') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $request->technician->name ?? __('messages.no_technician') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-xs hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center gap-1 text-gray-900 dark:text-gray-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('messages.show') }}
                            </a>
                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
                                class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 rounded text-xs hover:bg-blue-200 dark:hover:bg-blue-800 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                {{ __('messages.edit') }}
                            </a>
                            @if ($request->image)
                                <a href="{{ asset('storage/' . $request->image) }}" target="_blank"
                                    class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 px-3 py-1 rounded text-xs hover:bg-indigo-200 dark:hover:bg-indigo-800 flex items-center gap-1">
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
                            class="mt-3 relative">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()"
                                class="w-full text-xs border dark:border-gray-600 rounded px-2 py-1 pr-6 focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                    <option value="{{ $status }}"
                                        {{ $request->status == $status ? 'selected' : '' }}>
                                        {{ __('messages.status_' . $status) }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        {{ __('messages.no_requests_found') }}
                    </div>
                @endforelse
            </div>

            {{-- عرض الجدول للشاشات الكبيرة --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
						    
							<th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.status') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.id') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.building') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.unit') }}
                            </th>
                            <th 
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.category') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.technician') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.change_status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($requests as $request)
                            @php
                                $colors = [
                                    'new' => 'bg-yellow-400 dark:bg-yellow-600 animate-pulse',
                                    'in_progress' => 'bg-blue-400 dark:bg-blue-600 animate-pulse',
                                    'completed' => 'bg-green-500 dark:bg-green-600',
                                    'rejected' => 'bg-red-500 dark:bg-red-600',
                                    'delayed' => 'bg-orange-400 dark:bg-orange-600',
                                    'waiting_materials' => 'bg-purple-400 dark:bg-purple-600',
                                    'customer_unavailable' => 'bg-pink-400 dark:bg-pink-600',
                                    'other' => 'bg-gray-400 dark:bg-gray-600',
                                ];
                                $statusColors = [
                                    'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'delayed' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                    'waiting_materials' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'customer_unavailable' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                                    'other' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-2">
                                        <span
                                            class="w-3 h-3 rounded-full {{ $colors[$request->status] ?? 'bg-gray-300 dark:bg-gray-600' }}"
                                            title="{{ __('messages.status_' . $request->status) }}"></span>
                                        <span
                                            class="px-2 py-1 rounded-full text-xs {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ __('messages.status_' . $request->status) }}
                                        </span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center font-medium text-gray-900 dark:text-gray-100">#{{ $request->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-gray-900 dark:text-gray-100">{{ $request->building->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-gray-900 dark:text-gray-100">{{ $request->unit->unit_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-100">
                                    {{ $request->subSpecialty->parent->name ?? '-' }} -
                                    {{ $request->subSpecialty->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-1">
                                        @if ($request->technician)
                                            <span class="w-2 h-2 rounded-full bg-green-500 dark:bg-green-400"></span>
                                            <span class="text-gray-900 dark:text-gray-100">{{ $request->technician->name }}</span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                            <span class="text-gray-500 dark:text-gray-400">{{ __('messages.no_technician') }}</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                            class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center gap-1 text-gray-900 dark:text-gray-100">
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
                                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded text-xs hover:bg-blue-200 dark:hover:bg-blue-800 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            {{ __('messages.edit') }}
                                        </a>
                                        @if ($request->image)
                                            <a href="{{ asset('storage/' . $request->image) }}" target="_blank"
                                                class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 px-2 py-1 rounded text-xs hover:bg-indigo-200 dark:hover:bg-indigo-800 flex items-center gap-1">
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
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form method="POST"
                                        action="{{ route('admin.maintenance_requests.update_status', $request->id) }}"
                                        class="relative">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-xs border dark:border-gray-600 rounded px-2 py-1 pr-6 focus:ring-2 focus:ring-blue-500 appearance-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $request->status == $status ? 'selected' : '' }}>
                                                    {{ __('messages.status_' . $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
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
                                <td colspan="8" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    {{ __('messages.no_requests_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- نظام ترقيم الصفحات المحسن --}}
            @if ($requests->hasPages())
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t dark:border-gray-600">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        {{-- معلومات النتائج --}}
                        <div class="text-sm text-gray-700 dark:text-gray-300 text-center sm:text-right">
                            {{ __('messages.showing') }}
                            <span class="font-medium">{{ $requests->firstItem() }}</span>
                            {{ __('messages.to') }}
                            <span class="font-medium">{{ $requests->lastItem() }}</span>
                            {{ __('messages.of') }}
                            <span class="font-medium">{{ $requests->total() }}</span>
                            {{ __('messages.results') }}
                        </div>

                        {{-- أزرار التنقل --}}
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{-- زر الصفحة السابقة --}}
                            @if ($requests->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md rounded-l-md border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-500 cursor-not-allowed">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $requests->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md rounded-l-md border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            {{-- أرقام الصفحات --}}
                            @php
                                $start = max($requests->currentPage() - 2, 1);
                                $end = min($start + 4, $requests->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <a href="{{ $requests->appends(request()->query())->url(1) }}" class="hidden sm:inline-flex relative items-center px-4 py-2 border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    1
                                </a>
                                @if($start > 2)
                                    <span class="hidden sm:inline-flex relative items-center px-4 py-2 border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        ...
                                    </span>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $requests->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border dark:border-gray-600 bg-blue-50 dark:bg-blue-900 border-blue-500 dark:border-blue-700 text-sm font-medium text-blue-600 dark:text-blue-200 z-10">
                                        {{ $i }}
                                    </span>
                                @else
                                    <a href="{{ $requests->appends(request()->query())->url($i) }}" class="hidden sm:inline-flex relative items-center px-4 py-2 border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            @if($end < $requests->lastPage())
                                @if($end < $requests->lastPage() - 1)
                                    <span class="hidden sm:inline-flex relative items-center px-4 py-2 border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        ...
                                    </span>
                                @endif
                                <a href="{{ $requests->appends(request()->query())->url($requests->lastPage()) }}" class="hidden sm:inline-flex relative items-center px-4 py-2 border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    {{ $requests->lastPage() }}
                                </a>
                            @endif

                            {{-- زر الصفحة التالية --}}
                            @if ($requests->hasMorePages())
                                <a href="{{ $requests->appends(request()->query())->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-500 cursor-not-allowed">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
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
            if (filterInput) {
                filterInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitFilterForm();
                    }
                });
            }

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