<div wire:poll.60000ms>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300"
        dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            {{-- Header Section --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <!-- Title Section -->
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.maintenance_requests') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">{{ __('messages.maintenance_management') }}
                            </p>
                        </div>
                    </div>

                    <!-- Add New Button -->
                    <a href="{{ route('admin.maintenance_requests.create') }}"
                        class="group flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 rtl:ml-2 group-hover:rotate-90 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('messages.add_new_request') }}
                    </a>
                </div>
            </div>

            {{-- Status Tabs Section --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h8m-8 0a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2" />
                    </svg>
                    {{ __('messages.filter_by_status') }}
                </h3>
                <div class="overflow-x-auto">
                    <div class="flex space-x-2 rtl:space-x-reverse min-w-max">
                        @php
                            $statusTabs = [
                                'all' => [
                                    'color' => 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600',
                                    'active' => 'bg-gray-300 dark:bg-gray-600',
                                    'text' => 'text-gray-800 dark:text-gray-200',
                                    'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16',
                                ],
                                'new' => [
                                    'color' =>
                                        'bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800',
                                    'active' => 'bg-yellow-300 dark:bg-yellow-700',
                                    'text' => 'text-yellow-800 dark:text-yellow-200',
                                    'icon' => 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'in_progress' => [
                                    'color' => 'bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800',
                                    'active' => 'bg-blue-300 dark:bg-blue-700',
                                    'text' => 'text-blue-800 dark:text-blue-200',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'completed' => [
                                    'color' =>
                                        'bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800',
                                    'active' => 'bg-green-300 dark:bg-green-700',
                                    'text' => 'text-green-800 dark:text-green-200',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'rejected' => [
                                    'color' => 'bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800',
                                    'active' => 'bg-red-300 dark:bg-red-700',
                                    'text' => 'text-red-800 dark:text-red-200',
                                    'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'delayed' => [
                                    'color' =>
                                        'bg-orange-100 hover:bg-orange-200 dark:bg-orange-900 dark:hover:bg-orange-800',
                                    'active' => 'bg-orange-300 dark:bg-orange-700',
                                    'text' => 'text-orange-800 dark:text-orange-200',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'waiting_materials' => [
                                    'color' =>
                                        'bg-purple-100 hover:bg-purple-200 dark:bg-purple-900 dark:hover:bg-purple-800',
                                    'active' => 'bg-purple-300 dark:bg-purple-700',
                                    'text' => 'text-purple-800 dark:text-purple-200',
                                    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                                ],
                                'customer_unavailable' => [
                                    'color' => 'bg-pink-100 hover:bg-pink-200 dark:bg-pink-900 dark:hover:bg-pink-800',
                                    'active' => 'bg-pink-300 dark:bg-pink-700',
                                    'text' => 'text-pink-800 dark:text-pink-200',
                                    'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                ],
                                'other' => [
                                    'color' => 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600',
                                    'active' => 'bg-gray-300 dark:bg-gray-600',
                                    'text' => 'text-gray-800 dark:text-gray-200',
                                    'icon' =>
                                        'M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z',
                                ],
                            ];
                        @endphp

                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 whitespace-nowrap
                              {{ !request('status') ? $statusTabs['all']['active'] : $statusTabs['all']['color'] }} {{ $statusTabs['all']['text'] }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $statusTabs['all']['icon'] }}" />
                            </svg>
                            <span class="hidden sm:inline">{{ __('messages.all_statuses') }}</span>
                            <span class="sm:hidden">{{ __('messages.all') }}</span>
                            <span
                                class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 text-xs px-2 py-1 rounded-full font-semibold">{{ $totalCount }}</span>
                        </a>

                        @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                            @if (isset($statusCounts[$status]))
                                <a href="{{ request()->fullUrlWithQuery(['status' => $status]) }}"
                                    class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 whitespace-nowrap
                                  {{ request('status') == $status ? $statusTabs[$status]['active'] : $statusTabs[$status]['color'] }} {{ $statusTabs[$status]['text'] }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $statusTabs[$status]['icon'] }}" />
                                    </svg>
                                    <span class="hidden sm:inline">{{ __('messages.status_' . $status) }}</span>
                                    <span class="sm:hidden">{{ substr(__('messages.status_' . $status), 0, 3) }}</span>
                                    <span
                                        class="bg-white dark:bg-gray-900 {{ $statusTabs[$status]['text'] }} text-xs px-2 py-1 rounded-full font-semibold">{{ $statusCounts[$status] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Search & Filter Section --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                    </svg>
                    {{ __('messages.advanced_filters') }}
                </h3>
                <form id="filterForm" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Building Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ __('messages.filter_by_building') }}
                        </label>
                        <div class="relative">
                            <select name="building_id"
                                class="filter-select w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">{{ __('messages.all_buildings') }}</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sub Specialty Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            {{ __('messages.sub_specialty') }}
                        </label>
                        <div class="relative">
                            <select name="sub_specialty_id"
                                class="filter-select w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">{{ __('messages.all_sub_specialties') }}</option>
                                @foreach ($subSpecialties as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ request('sub_specialty_id') == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->parent->name ?? '❓' }} - {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Technician Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('messages.technician') }}
                        </label>
                        <div class="relative">
                            <select name="technician_id"
                                class="filter-select w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">{{ __('messages.all_technicians') }}</option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}"
                                        {{ request('technician_id') == $technician->id ? 'selected' : '' }}>
                                        {{ $technician->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Number Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ __('messages.search_by_unit_number') }}
                        </label>
                        <div class="relative">
                            <input type="text" name="unit_number"
                                placeholder="{{ __('messages.search_unit_placeholder') }}"
                                value="{{ request('unit_number') }}"
                                class="filter-input w-full py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4' }}">
                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none {{ app()->getLocale() === 'ar' ? 'right-4' : 'left-4' }}">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if (request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                </form>
            </div>

          

            {{-- No Results Message --}}
            <div id="noResults"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center hidden">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('messages.no_results') }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.try_different_search') }}</p>
            </div>

            {{-- Mobile Cards View --}}
            <div id="requestsMobile" class="block lg:hidden space-y-4 mb-6">
                @forelse($requests as $request)
                    @php
                        $statusColors = [
                            'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            'delayed' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                            'waiting_materials' =>
                                'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                            'customer_unavailable' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                            'other' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        ];
                        $borderColors = [
                            'new' => 'border-yellow-200 dark:border-yellow-700',
                            'in_progress' => 'border-blue-200 dark:border-blue-700',
                            'completed' => 'border-green-200 dark:border-green-700',
                            'rejected' => 'border-red-200 dark:border-red-700',
                            'delayed' => 'border-orange-200 dark:border-orange-700',
                            'waiting_materials' => 'border-purple-200 dark:border-purple-700',
                            'customer_unavailable' => 'border-pink-200 dark:border-pink-700',
                            'other' => 'border-gray-200 dark:border-gray-700',
                        ];
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 {{ $borderColors[$request->status] ?? 'border-gray-200 dark:border-gray-700' }} p-6 hover:shadow-xl transition-all duration-300 mobile-card"
                        data-request-id="{{ $request->id }}"
                        data-building="{{ strtolower($request->building->name ?? '') }}"
                        data-unit="{{ strtolower($request->unit->unit_number ?? '') }}">

                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">#</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ __('messages.request_number') }} {{ $request->id }}</h3>
                                </div>
                                @if ($request->is_emergency ?? false)
                                    <div
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 mb-2">
                                        <svg class="w-3 h-3 mr-1 rtl:ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ __('messages.emergency') }}
                                    </div>
                                @endif
                            </div>
                            <!-- Status Badge -->
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ __('messages.status_' . $request->status) }}
                            </span>
                        </div>

                        <!-- Request Details -->
                        <div class="space-y-3 mb-4">
                            <!-- Building & Unit -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <div>
                                        <span
                                            class="block text-xs text-gray-500 dark:text-gray-500">{{ __('messages.building_label') }}</span>
                                        <span
                                            class="text-gray-900 dark:text-white font-medium">{{ $request->building->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <div>
                                        <span class="block text-xs text-gray-500 dark:text-gray-500">
                                            {{ __('messages.unit_label') }}
                                        </span>
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm mt-1">
                                            {{ $request->unit->unit_number ?? '-' }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            <!-- Category -->
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <div>
                                    <span
                                        class="block text-xs text-gray-500 dark:text-gray-500">{{ __('messages.fault_type') }}</span>
                                    <span class="text-gray-900 dark:text-white font-medium">
                                        {{ $request->subSpecialty->parent->name ?? '-' }} -
                                        {{ $request->subSpecialty->name ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Technician -->
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <span
                                        class="block text-xs text-gray-500 dark:text-gray-500">{{ __('messages.assigned_technician') }}</span>
                                    <span class="text-gray-900 dark:text-white font-medium">
                                        {{ $request->technician->name ?? __('messages.no_technician') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Creation Date -->
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <span
                                        class="block text-xs text-gray-500 dark:text-gray-500">{{ __('messages.creation_date') }}</span>
                                    <span
                                        class="text-gray-900 dark:text-white font-medium">{{ $request->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                    class="inline-flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ __('messages.view') }}
                                </a>

                                <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('messages.edit') }}
                                </a>

                                @if ($request->image)
                                    <a data-fancybox="request-{{ $request->id }}"
                                        href="{{ asset('storage/' . $request->image) }}"
                                        class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ __('messages.image') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Status Update Form -->
                        <form method="POST"
                            action="{{ route('admin.maintenance_requests.update_status', $request->id) }}"
                            class="mt-4">
                            @csrf
                            @method('PUT')
                            <div class="relative">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.update_status') }}</label>
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $request->status == $status ? 'selected' : '' }}>
                                            {{ __('messages.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none top-8">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>
                @empty
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            {{ __('messages.no_requests_found') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_current_requests') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div id="requestsTable"
                class="hidden lg:block bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold mb-2 sm:mb-0 text-gray-900 dark:text-gray-100">
                        {{ __('messages.requests_table') }}</h2>
                    <div class="flex items-center gap-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ __('messages.total_requests') }}: {{ $requests->total() }}</p>
                        <div class="relative">
                            <select onchange="updatePerPage(this.value)"
                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.status') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.id') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.building') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.unit') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.category') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.technician') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.actions') }}
                                </th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.change_status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="requestsTableBody"
                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($requests as $request)
                                @php
                                    $statusDotColors = [
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
                                        'new' =>
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'in_progress' =>
                                            'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'completed' =>
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'delayed' =>
                                            'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                        'waiting_materials' =>
                                            'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                        'customer_unavailable' =>
                                            'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                                        'other' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ $request->is_emergency ?? false ? 'bg-red-50 dark:bg-red-900/20' : '' }}"
                                    data-request-id="{{ $request->id }}"
                                    data-building="{{ strtolower($request->building->name ?? '') }}"
                                    data-unit="{{ strtolower($request->unit->unit_number ?? '') }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span
                                                class="w-3 h-3 rounded-full {{ $statusDotColors[$request->status] ?? 'bg-gray-300 dark:bg-gray-600' }} mr-2 rtl:ml-2"></span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ __('messages.status_' . $request->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 rtl:ml-3">
                                                <span class="text-white font-bold text-xs">#</span>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ $request->id }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $request->building->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $request->unit->unit_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        <div class="max-w-xs">
                                            {{ $request->subSpecialty->parent->name ?? '-' }} -
                                            {{ $request->subSpecialty->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($request->technician)
                                                <span
                                                    class="w-2 h-2 rounded-full bg-green-500 dark:bg-green-400 mr-2 rtl:ml-2"></span>
                                                <span
                                                    class="text-sm text-gray-900 dark:text-white">{{ $request->technician->name }}</span>
                                            @else
                                                <span
                                                    class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 mr-2 rtl:ml-2"></span>
                                                <span
                                                    class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.no_technician') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}"
                                                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                title="{{ __('messages.view') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-1 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-colors"
                                                title="{{ __('messages.edit') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            @if ($request->image)
                                                <a data-fancybox="request-{{ $request->id }}"
                                                    href="{{ asset('storage/' . $request->image) }}"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 p-1 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/20 transition-colors"
                                                    title="{{ __('messages.image') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST"
                                            action="{{ route('admin.maintenance_requests.update_status', $request->id) }}"
                                            class="relative">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()"
                                                class="w-full text-xs border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                                @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $request->status == $status ? 'selected' : '' }}>
                                                        {{ __('messages.status_' . $status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
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
            </div>

            {{-- Pagination --}}
            @if (method_exists($requests, 'hasPages') && $requests->hasPages())
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 px-6 py-4 mb-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Results Info -->
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $requests->firstItem() }} {{ __('messages.showing_results') }}
                            {{ $requests->lastItem() }} To {{ $requests->total() }}
                        </div>

                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2 rtl:space-x-reverse ">
                            {{-- Previous Button --}}
                            @if ($requests->onFirstPage())
                                <span
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $requests->appends(request()->query())->previousPageUrl() }}"
                                    class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($requests->getUrlRange(max(1, $requests->currentPage() - 2), min($requests->lastPage(), $requests->currentPage() + 2)) as $page => $url)
                                @if ($page == $requests->currentPage())
                                    <span class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Button --}}
                            @if ($requests->hasMorePages())
                                <a href="{{ $requests->appends(request()->query())->nextPageUrl() }}"
                                    class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>

                        <!-- Items per page -->
                        <div class="flex items-center space-x-2 rtl:space-x-reverse  ">
                            <label for="per_page"
                                class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.display') }}:</label>
                            <select id="per_page" onchange="changePerPage(this.value)"
                                class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                                </option>
                                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25
                                </option>
                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
			
			
			  {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-1">
                @php
                    $totalRequests = collect($statusCounts)->sum();
                    $activeRequests = ($statusCounts['new'] ?? 0) + ($statusCounts['in_progress'] ?? 0);
                @endphp

                <!-- Total Requests -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.total_requests_stat') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalRequests }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('messages.maintenance_request_unit') }}</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Requests -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.active_requests') }}</h3>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $activeRequests }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('messages.under_processing') }}</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Requests -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.completed_requests') }}</h3>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $statusCounts['completed'] ?? 0 }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('messages.completed_work') }}</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.new_requests') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $statusCounts['new'] ?? 0 }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.pending') }}</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>		
    </div>

    {{-- Loading Indicator --}}
    <div id="loadingIndicator"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex items-center gap-4">
            <svg class="animate-spin h-8 w-8 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.loading') }}...</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search and filter functionality
            const filterForm = document.getElementById('filterForm');
            const filterSelects = document.querySelectorAll('.filter-select');
            const filterInput = document.querySelector('.filter-input');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const requestsMobile = document.getElementById('requestsMobile');
            const requestsTable = document.getElementById('requestsTable');
            const noResults = document.getElementById('noResults');

            // Get all mobile cards and desktop rows
            const mobileCards = Array.from(document.querySelectorAll('.mobile-card'));
            const desktopRows = Array.from(document.querySelectorAll('#requestsTableBody tr'));

            // Check if we're on mobile/tablet
            function isMobile() {
                return window.innerWidth < 1024; // Tailwind's lg breakpoint
            }

            // Smart filtering with debounce
            if (filterInput) {
                filterInput.addEventListener('input', debounce(function() {
                    filterRequests();
                }, 300));
            }

            // Filter on dropdown change
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    submitFilterForm();
                });
            });

            function filterRequests() {
                const searchTerm = filterInput.value.toLowerCase();
                const mobile = isMobile();

                let hasVisibleItems = false;

                if (mobile && mobileCards.length > 0) {
                    // Filter mobile cards
                    mobileCards.forEach(card => {
                        const building = card.getAttribute('data-building') || '';
                        const unit = card.getAttribute('data-unit') || '';
                        const requestId = card.getAttribute('data-request-id') || '';

                        const matchesSearch = searchTerm === '' ||
                            building.includes(searchTerm) ||
                            unit.includes(searchTerm) ||
                            requestId.includes(searchTerm);

                        if (matchesSearch) {
                            card.style.display = '';
                            hasVisibleItems = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show/hide containers for mobile
                    if (!hasVisibleItems) {
                        requestsMobile.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    } else {
                        requestsMobile.classList.remove('hidden');
                        noResults.classList.add('hidden');
                    }
                } else if (!mobile && desktopRows.length > 0) {
                    // Filter desktop table rows
                    desktopRows.forEach(row => {
                        const building = row.getAttribute('data-building') || '';
                        const unit = row.getAttribute('data-unit') || '';
                        const requestId = row.getAttribute('data-request-id') || '';

                        const matchesSearch = searchTerm === '' ||
                            building.includes(searchTerm) ||
                            unit.includes(searchTerm) ||
                            requestId.includes(searchTerm);

                        if (matchesSearch) {
                            row.style.display = '';
                            hasVisibleItems = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show/hide containers for desktop
                    if (!hasVisibleItems) {
                        requestsTable.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    } else {
                        requestsTable.classList.remove('hidden');
                        noResults.classList.add('hidden');
                    }
                }
            }

            // Submit filter form
            function submitFilterForm() {
                if (loadingIndicator) {
                    loadingIndicator.classList.remove('hidden');
                }

                // Add loading effect
                document.body.style.opacity = '0.8';
                filterForm.submit();
            }

            // Listen for window resize to handle screen size changes
            window.addEventListener('resize', debounce(function() {
                filterRequests();
            }, 100));

            // Debounce function for search input
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }
        });

        // Update items per page
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

        // Change items per page
        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.delete('page'); // Reset to first page
            window.location.href = url.toString();
        }

        // Add loading states for forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                }
            });
        });

        // Smooth scrolling for pagination
        document.querySelectorAll('a[href*="page="]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                setTimeout(() => {
                    window.location.href = this.href;
                }, 300);
            });
        });
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Loading spinner */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Card hover effects */
        .mobile-card:hover {
            transform: translateY(-4px);
        }

        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
        }

        [dir="rtl"] .space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #374151;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Mobile Responsive Fixes */
        @media (max-width: 640px) {

            input,
            select,
            textarea {
                font-size: 16px !important;
            }

            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            button,
            a {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Enhanced shadows for dark mode */
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }

        /* Hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:rotate-90 {
            transform: rotate(90deg);
        }

        /* Transition improvements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Focus states */
        .focus\:ring-2:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
    </style>
</div>
