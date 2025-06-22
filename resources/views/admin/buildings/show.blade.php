@extends('layouts.app')

@section('title', __('messages.building_details'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <!-- Title and Breadcrumb -->
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse mb-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ __('messages.building_details') }}</h1>
                                <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $building->name }}</p>
                            </div>
                        </div>

                        <!-- Breadcrumb -->
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse text-sm">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="inline-flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        {{ __('messages.dashboard') }}
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 text-gray-400 mx-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="{{ route('admin.buildings.index') }}"
                                            class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                            {{ __('messages.buildings') }}
                                        </a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 text-gray-400 mx-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $building->name }}</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.buildings.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('messages.back_to_buildings') }}
                        </a>

                        <a href="{{ route('admin.buildings.edit', $building->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ __('messages.edit_building') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                {{-- Left Column - Building Details --}}
                <div class="xl:col-span-2 space-y-6">
                    {{-- General Information Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.general_information') }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $generalInfo = [
                                        [
                                            'key' => 'building_name',
                                            'value' => $building->name,
                                            'icon' =>
                                                'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                                        ],
                                        [
                                            'key' => 'building_number',
                                            'value' => $building->building_number,
                                            'icon' => 'M7 20l4-16m2 16l4-16M6 9h14M4 15h14',
                                        ],
                                        [
                                            'key' => 'address',
                                            'value' => $building->address,
                                            'icon' =>
                                                'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                                        ],
                                        [
                                            'key' => 'municipality_number',
                                            'value' => $building->municipality_number,
                                            'icon' =>
                                                'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                        ],
                                        [
                                            'key' => 'units_count',
                                            'value' => $building->units()->count(),
                                            'icon' =>
                                                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                                        ],
                                        [
                                            'key' => 'created_at',
                                            'value' => $building->created_at?->format('Y-m-d H:i A'),
                                            'icon' =>
                                                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                        ],
                                    ];
                                @endphp

                                @foreach ($generalInfo as $info)
                                    <div
                                        class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                        <div
                                            class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $info['icon'] }}" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                {{ __('messages.' . $info['key']) }}
                                            </p>
                                            <p class="text-sm text-gray-900 dark:text-white font-semibold break-words">
                                                {{ $info['value'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Location URL --}}
                            @php
                                $locationUrl = is_string($building->location_url) ? trim($building->location_url) : '';
                            @endphp
                            @if (!empty($locationUrl) && filter_var($locationUrl, FILTER_VALIDATE_URL))
                                <div
                                    class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3 rtl:ml-3">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                                    {{ __('messages.location_url') }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-500">موقع المبنى على الخريطة
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ $locationUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            {{ __('messages.view_on_map') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Owner Information Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('messages.owner_information') }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $ownerInfo = [
                                        [
                                            'key' => 'owner_name',
                                            'value' => $building->owner_name,
                                            'icon' =>
                                                'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                        ],
                                        [
                                            'key' => 'owner_nationality',
                                            'value' => $building->owner_nationality,
                                            'icon' =>
                                                'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9',
                                        ],
                                        [
                                            'key' => 'owner_id_number',
                                            'value' => $building->owner_id_number,
                                            'icon' =>
                                                'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2',
                                        ],
                                        [
                                            'key' => 'owner_phone',
                                            'value' => $building->owner_phone,
                                            'icon' =>
                                                'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                                        ],
                                    ];
                                @endphp

                                @foreach ($ownerInfo as $info)
                                    <div
                                        class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                        <div
                                            class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $info['icon'] }}" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                {{ __('messages.' . $info['key']) }}
                                            </p>
                                            <p class="text-sm text-gray-900 dark:text-white font-semibold break-words">
                                                {{ $info['value'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Financial Information Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                {{ __('messages.financial_information') }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $financialInfo = [
                                        [
                                            'key' => 'rent_amount',
                                            'value' => $building->rent_amount
                                                ? number_format($building->rent_amount, 2) . ' ' . __('messages.aed')
                                                : null,
                                            'icon' =>
                                                'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1',
                                        ],
                                        [
                                            'key' => 'initial_renovation_cost',
                                            'value' => $building->initial_renovation_cost
                                                ? number_format($building->initial_renovation_cost, 2) .
                                                    ' ' .
                                                    __('messages.aed')
                                                : null,
                                            'icon' =>
                                                'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                                        ],
                                    ];
                                @endphp

                                @foreach ($financialInfo as $info)
                                    <div
                                        class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                        <div
                                            class="w-10 h-10 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $info['icon'] }}" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                {{ __('messages.' . $info['key']) }}
                                            </p>
                                            <p class="text-sm text-gray-900 dark:text-white font-semibold break-words">
                                                {{ $info['value'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column - Image and Utilities --}}
                <div class="xl:col-span-1 space-y-6">
                    {{-- Building Image Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('messages.building_image') }}
                            </h2>
                        </div>
                        <div class="p-6">
                            @if ($building->image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $building->image) }}" alt="صورة المبنى"
                                        class="w-full h-64 object-cover rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-300" />
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-xl flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $building->image) }}" target="_blank"
                                            class="opacity-0 group-hover:opacity-100 bg-white dark:bg-gray-800 text-gray-800 dark:text-white px-4 py-2 rounded-lg shadow-lg transition-all duration-300 transform scale-75 group-hover:scale-100">
                                            <svg class="w-5 h-5 inline mr-2 rtl:ml-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            عرض كبير
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="w-full h-64 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_image_available') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Utilities Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                {{ __('messages.utilities_list') }}
                            </h2>
                            <p class="text-blue-100 text-sm mt-1">
                                {{ __('messages.all_utilities_associated_with_this_building') }}</p>
                        </div>

                        @if ($building->utilities->count())
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($building->utilities as $index => $utility)
                                    <div
                                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-3 rtl:space-x-reverse flex-1">
                                                <!-- Utility Icon -->
                                                <div
                                                    class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 
                                                {{ $utility->type === 'electricity' ? 'bg-yellow-100 dark:bg-yellow-900/20' : '' }}
                                                {{ $utility->type === 'water' ? 'bg-blue-100 dark:bg-blue-900/20' : '' }}
                                                {{ $utility->type === 'gas' ? 'bg-red-100 dark:bg-red-900/20' : '' }}
                                                {{ $utility->type === 'internet' ? 'bg-purple-100 dark:bg-purple-900/20' : '' }}
                                                {{ !in_array($utility->type, ['electricity', 'water', 'gas', 'internet']) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                                    @if ($utility->type === 'electricity')
                                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                    @elseif($utility->type === 'water')
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    @elseif($utility->type === 'gas')
                                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                                        </svg>
                                                    @elseif($utility->type === 'internet')
                                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    @endif
                                                </div>

                                                <!-- Utility Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                            {{ __('messages.' . $utility->type) }}
                                                        </h4>
                                                        <span
                                                            class="text-xs text-gray-500 dark:text-gray-400">#{{ $index + 1 }}</span>
                                                    </div>

                                                    <div class="space-y-1 text-xs">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-gray-500 dark:text-gray-400">القيمة:</span>
                                                            <span
                                                                class="text-gray-900 dark:text-white font-medium">{{ $utility->value }}</span>
                                                        </div>

                                                        @if ($utility->owner_name)
                                                            <div class="flex items-center justify-between">
                                                                <span
                                                                    class="text-gray-500 dark:text-gray-400">المالك:</span>
                                                                <span
                                                                    class="text-gray-900 dark:text-white font-medium">{{ $utility->owner_name }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($utility->notes)
                                                            <div class="mt-2">
                                                                <p
                                                                    class="text-gray-600 dark:text-gray-300 text-xs bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                                                                    {{ Str::limit($utility->notes, 60) }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center space-x-2 rtl:space-x-reverse ml-3 rtl:mr-3">
                                                <a href="{{ route('admin.building-utilities.show', $utility->id) }}"
                                                    class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/20 rounded-lg transition-colors duration-200"
                                                    title="عرض">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                <a href="{{ route('admin.building-utilities.edit', $utility->id) }}"
                                                    class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-200"
                                                    title="تعديل">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Add Utility Button -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-600">
                                <a href="{{ route('admin.building-utilities.create', ['building_id' => $building->id]) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    إضافة مرفق جديد
                                </a>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.no_utilities_found') }}
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    {{ __('messages.get_started_by_adding_a_new_utility') }}
                                </p>
                                <a href="{{ route('admin.building-utilities.create', ['building_id' => $building->id]) }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    إضافة أول مرفق
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Quick Stats Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                إحصائيات سريعة
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            @php
                                $stats = [
                                    [
                                        'label' => 'إجمالي الوحدات',
                                        'value' => $building->units()->count(),
                                        'color' => 'blue',
                                        'icon' =>
                                            'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                                    ],
                                    [
                                        'label' => 'الوحدات المؤجرة',
                                        'value' => $building
                                            ->units()
                                            ->whereHas('contracts', function ($q) {
                                                $q->where('end_date', '>=', now());
                                            })
                                            ->count(),
                                        'color' => 'green',
                                        'icon' =>
                                            'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                                    ],
                                    [
                                        'label' => 'الوحدات الشاغرة',
                                        'value' => $building
                                            ->units()
                                            ->whereDoesntHave('contracts', function ($q) {
                                                $q->where('end_date', '>=', now());
                                            })
                                            ->count(),
                                        'color' => 'red',
                                        'icon' =>
                                            'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                                    ],
                                    [
                                        'label' => 'المرافق المسجلة',
                                        'value' => $building->utilities()->count(),
                                        'color' => 'purple',
                                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                    ],
                                ];
                            @endphp

                            @foreach ($stats as $stat)
                                <div
                                    class="flex items-center justify-between p-3 bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 rounded-lg border border-{{ $stat['color'] }}-200 dark:border-{{ $stat['color'] }}-800">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <div
                                            class="w-8 h-8 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $stat['icon'] }}" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $stat['label'] }}</span>
                                    </div>
                                    <span
                                        class="text-xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">{{ $stat['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        /* Hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        /* Transition improvements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Dark mode gradient backgrounds */
        .dark .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, #111827, #1f2937);
        }

        /* Enhanced shadows for dark mode */
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
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

        /* Image hover effects */
        .group img {
            transition: transform 0.3s ease;
        }

        .group:hover img {
            transform: scale(1.02);
        }

        /* Utility card hover effects */
        .utility-card {
            transition: all 0.3s ease;
        }

        .utility-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .utility-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Button hover effects */
        button,
        a {
            transition: all 0.2s ease;
        }

        /* RTL Support improvements */
        [dir="rtl"] .space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .grid {
                gap: 1rem;
            }

            .p-6 {
                padding: 1rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }

            .text-3xl {
                font-size: 1.875rem;
            }
        }

        /* Focus states */
        .focus\:ring-2:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
    </style>
@endsection
