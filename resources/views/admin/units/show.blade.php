@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

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
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.unit_details') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">الوحدة رقم {{ $unit->unit_number }} -
                                {{ $unit->building->name }}</p>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('admin.units.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_units') }}
                    </a>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Left Column - Unit Details --}}
                <div class="xl:col-span-2 space-y-6">
                    {{-- Unit Information Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                معلومات الوحدة
                            </h2>
                        </div>

                        <div class="p-6">
                            @php
                                $statusConfig = [
                                    'available' => [
                                        'color' => 'green',
                                        'icon' =>
                                            'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                                    ],
                                    'occupied' => [
                                        'color' => 'red',
                                        'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                    ],
                                    'booked' => [
                                        'color' => 'purple',
                                        'icon' =>
                                            'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                    ],
                                    'maintenance' => [
                                        'color' => 'yellow',
                                        'icon' =>
                                            'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                                    ],
                                    'cleaning' => [
                                        'color' => 'indigo',
                                        'icon' =>
                                            'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                                    ],
                                ];
                                $status = $statusConfig[$unit->status] ?? [
                                    'color' => 'gray',
                                    'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                ];
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- رقم الوحدة --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">
                                            {{ __('messages.unit_number') }}</h3>
                                        <p class="text-xl font-bold text-blue-900 dark:text-blue-100">
                                            {{ $unit->unit_number }}</p>
                                    </div>
                                </div>

                                {{-- نوع الوحدة --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl border border-green-200 dark:border-green-800">
                                    <div
                                        class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-green-700 dark:text-green-300 mb-1">
                                            {{ __('messages.unit_type') }}</h3>
                                        <p class="text-xl font-bold text-green-900 dark:text-green-100">
                                            {{ __('messages.' . $unit->unit_type) }}</p>
                                    </div>
                                </div>

                                {{-- الطابق --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl border border-purple-200 dark:border-purple-800">
                                    <div
                                        class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-purple-700 dark:text-purple-300 mb-1">
                                            {{ __('messages.floor') }}</h3>
                                        <p class="text-xl font-bold text-purple-900 dark:text-purple-100">
                                            {{ $unit->floor ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- الحالة --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-{{ $status['color'] }}-50 to-{{ $status['color'] }}-100 dark:from-{{ $status['color'] }}-900/20 dark:to-{{ $status['color'] }}-800/20 rounded-xl border border-{{ $status['color'] }}-200 dark:border-{{ $status['color'] }}-800">
                                    <div
                                        class="w-12 h-12 bg-{{ $status['color'] }}-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $status['icon'] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-sm font-medium text-{{ $status['color'] }}-700 dark:text-{{ $status['color'] }}-300 mb-1">
                                            {{ __('messages.status') }}</h3>
                                        <p
                                            class="text-xl font-bold text-{{ $status['color'] }}-900 dark:text-{{ $status['color'] }}-100">
                                            {{ __('messages.' . $unit->status) }}</p>
                                    </div>
                                </div>

                                {{-- سعر الإيجار --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl border border-orange-200 dark:border-orange-800">
                                    <div
                                        class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-orange-700 dark:text-orange-300 mb-1">
                                            {{ __('messages.rent_price') }}</h3>
                                        <p class="text-xl font-bold text-orange-900 dark:text-orange-100">
                                            {{ number_format($unit->rent_price) }} {{ __('messages.currency') }}</p>
                                    </div>
                                </div>

                                {{-- المبنى --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl border border-teal-200 dark:border-teal-800">
                                    <div
                                        class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-1">
                                            {{ __('messages.building') }}</h3>
                                        <p class="text-xl font-bold text-teal-900 dark:text-teal-100">
                                            {{ $unit->building->name }}</p>
                                    </div>
                                </div>
                                {{-- الموقع --}}
                                <div
                                    class="flex items-start p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-xl border border-indigo-200 dark:border-indigo-800">
                                    <div
                                        class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 12.414C13.039 12.039 13.039 11.461 13.414 11.086L17.657 6.843M9 6H7a2 2 0 00-2 2v8a2 2 0 002 2h2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-indigo-700 dark:text-indigo-300 mb-1">
                                            {{ __('messages.unit_location') }}</h3>
                                        <p class="text-xl font-bold text-indigo-900 dark:text-indigo-100">
                                            {{ $unit->location ? __('messages.' . $unit->location) : __('messages.not_specified') }}

                                        </p>
                                    </div>
                                </div>

                            </div>

                            {{-- الملاحظات --}}
                            @if ($unit->notes)
                                <div
                                    class="mt-6 p-4 bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                                    <div class="flex items-start">
                                        <div
                                            class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300 mb-2">
                                                {{ __('messages.notes') }}</h3>
                                            <p
                                                class="text-sm text-yellow-900 dark:text-yellow-100 leading-relaxed whitespace-pre-line">
                                                {{ $unit->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Current Tenant Card --}}
                    @if ($unit->status === 'occupied' && $unit->latestContract && $unit->latestContract->tenant)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                                <h2 class="text-xl font-bold text-white flex items-center">
                                    <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('messages.current_tenant') }}
                                </h2>
                                <p class="text-emerald-100 text-sm mt-1">معلومات المستأجر الحالي</p>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div
                                        class="flex items-start p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <div
                                            class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300 mb-1">
                                                {{ __('messages.tenant_name') }}</h3>
                                            <p class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">
                                                {{ $unit->latestContract->tenant->name }}</p>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-start p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <div
                                            class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300 mb-1">
                                                {{ __('messages.tenant_phone') }}</h3>
                                            <p class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">
                                                {{ $unit->latestContract->tenant->phone ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-start p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <div
                                            class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300 mb-1">
                                                {{ __('messages.contract_start') }}</h3>
                                            <p class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">
                                                {{ $unit->latestContract->start_date }}</p>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-start p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <div
                                            class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300 mb-1">
                                                {{ __('messages.contract_end') }}</h3>
                                            <p class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">
                                                {{ $unit->latestContract->end_date }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-start p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <div
                                            class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300 mb-1">
                                                {{ __('messages.contract_number') }}</h3>
                                            @php
                                                $contract = $unit->contracts->last();
                                            @endphp

                                            <td
                                                class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 font-medium text-right">
                                                @if ($unit->status === 'occupied' && $contract)
                                                    {{ $contract->contract_number }}
                                                @else
                                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                                @endif
                                            </td>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Contract History Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('messages.contract_history') }}
                            </h2>
                            <p class="text-purple-100 text-sm mt-1">سجل العقود السابقة للوحدة</p>
                        </div>

                        <div class="p-6">
                            @if ($unit->contracts->count())
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.tenant_name') }}
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.contract_number') }}
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.contract_start') }}
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.contract_end') }}
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.rent_price') }}
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('messages.actions') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($unit->contracts->sortByDesc('start_date') as $contract)
                                                <tr
                                                    class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3 rtl:ml-3">
                                                                <svg class="w-4 h-4 text-white" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                            <span
                                                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $contract->tenant->name ?? '-' }}</span>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                        {{ $contract->contract_number }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                        {{ $contract->start_date }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                        {{ $contract->end_date }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                                        {{ number_format($contract->rent_amount) }}
                                                        {{ __('messages.currency') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                                            <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-colors"
                                                                title="عرض العقد">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                                                target="_blank"
                                                                class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                                title="طباعة العقد">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                        {{ __('messages.no_contracts_found') }}</h3>
                                    <p class="text-gray-500 dark:text-gray-400">لم يتم إنشاء عقود لهذه الوحدة بعد</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column - Images & Quick Actions --}}
                <div class="xl:col-span-1 space-y-6">
                    {{-- Unit Images Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('messages.unit_images') }}
                            </h2>
                            <p class="text-teal-100 text-sm mt-1">صور الوحدة ({{ $unit->images->count() }})</p>
                        </div>

                        @if ($unit->images->count())
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ __('messages.unit_images') }}
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($unit->images as $image)
                                            <div class="relative group">
                                                <a href="{{ asset('storage/' . $image->image_path) }}"
                                                    data-fancybox="gallery-{{ $unit->id }}" class="block">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        loading="lazy" alt="Unit Image"
                                                        class="w-full aspect-square object-cover rounded-xl shadow-sm hover:shadow-md transition duration-300">
                                                </a>
                                                <!-- زر المسح -->
                                                <form action="{{ route('admin.units.images.delete', $image) }}"
                                                    method="POST"
                                                    class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg transition-colors"
                                                        onclick="return confirm('{{ __('messages.confirm_delete_image') }}')">
                                                        ×
                                                    </button>
                                                </form>
                                                <!-- تأثير Hover مع أيقونة التكبير -->
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100"
                                                    style="pointer-events: none;">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>


                    {{-- Quick Actions Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                إجراءات سريعة
                            </h2>
                        </div>
                        <div class="p-6 space-y-3">
                            @can('edit units')
                                <a href="{{ route('admin.units.edit', $unit->id) }}"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    تعديل الوحدة
                                </a>
                            @endcan

                            @if ($unit->status === 'available')
                                <a href="{{ route('admin.contracts.create', ['unit_id' => $unit->id]) }}"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    إنشاء عقد جديد
                                </a>
                            @endif
                            @can('view building details')
                                <a href="{{ route('admin.buildings.show', $unit->building->id) }}"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    عرض المبنى
                                </a>
                            @endcan

                            <a href="{{ route('admin.units.index', ['building_id' => $unit->building->id]) }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                وحدات المبنى
                            </a>
                        </div>
                    </div>

                    {{-- Quick Stats Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
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
                                        'label' => 'إجمالي العقود',
                                        'value' => $unit->contracts->count(),
                                        'color' => 'blue',
                                        'icon' =>
                                            'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                    ],
                                    [
                                        'label' => 'الصور المرفوعة',
                                        'value' => $unit->images->count(),
                                        'color' => 'green',
                                        'icon' =>
                                            'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                                    ],
                                    [
                                        'label' => 'العقد النشط',
                                        'value' => $unit->status === 'occupied' ? 'نعم' : 'لا',
                                        'color' => $unit->status === 'occupied' ? 'green' : 'red',
                                        'icon' =>
                                            'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
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
                                        class="text-lg font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">{{ $stat['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        /* Status color variations */
        .status-available {
            @apply bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200;
        }

        .status-occupied {
            @apply bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200;
        }

        .status-booked {
            @apply bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200;
        }

        .status-maintenance {
            @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200;
        }

        .status-cleaning {
            @apply bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200;
        }
    </style>
@endsection
