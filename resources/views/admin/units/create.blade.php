@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

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
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.add_unit') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">إضافة وحدة جديدة إلى النظام</p>
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

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mb-6">
                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                                {{ __('messages.validation_errors') }}</h3>
                            <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main Form Section --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <form method="POST" action="{{ route('admin.units.store') }}" id="unitForm">
                    @csrf

                    {{-- Basic Information Section --}}
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            المعلومات الأساسية
                        </h2>
                        <p class="text-blue-100 text-sm mt-1">أدخل البيانات الأساسية للوحدة</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- المبنى --}}
                            <div class="md:col-span-2 space-y-2">
                                <label for="building_id"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ __('messages.building') }}
                                    <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <select name="building_id" id="building_id"
                                        class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ $errors->has('building_id') ? 'border-red-500 ring-red-500' : '' }}"
                                        required>
                                        <option value="">اختر المبنى</option>
                                        @foreach ($buildings as $building)
                                            <option value="{{ $building->id }}"
                                                {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                                {{ $building->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                                @error('building_id')
                                    <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- رقم الوحدة --}}
                            <div class="space-y-2">
                                <label for="unit_number"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    {{ __('messages.unit_number') }}
                                    <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="unit_number" id="unit_number"
                                        value="{{ old('unit_number') }}"
                                        class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 {{ $errors->has('unit_number') ? 'border-red-500 ring-red-500' : '' }}"
                                        placeholder="{{ __('messages.enter_unit_number') }}" required>
                                    <div
                                        class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                </div>
                                @error('unit_number')
                                    <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- الطابق --}}
                            <div class="space-y-2">
                                <label for="floor"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                    </svg>
                                    {{ __('messages.floor') }}
                                </label>
                                <input type="number" name="floor" id="floor" value="{{ old('floor') }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200"
                                    placeholder="0">
                                @error('floor')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- نوع الوحدة --}}
                            <div class="space-y-2">
                                <label for="unit_type"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-teal-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ __('messages.unit_type') }}
                                </label>
                                <select name="unit_type" id="unit_type"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                                    @php
                                        use App\Enums\UnitType;
                                        $types = UnitType::cases();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type->value }}"
                                            {{ old('unit_type') === $type->value ? 'selected' : '' }}>
                                            {{ __('messages.unit_type_' . $type->value) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_type')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- السعر --}}
                            <div class="space-y-2">
                                <label for="rent_price"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    {{ __('messages.rent_price') }}
                                    <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="rent_price" id="rent_price"
                                        value="{{ old('rent_price') }}" step="0.01" min="0"
                                        class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 {{ $errors->has('rent_price') ? 'border-red-500 ring-red-500' : '' }}"
                                        placeholder="0.00" required>
                                    <div
                                        class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                        <span class="text-orange-500 font-medium text-sm">AED</span>
                                    </div>
                                </div>
                                @error('rent_price')
                                    <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- موقع الوحدة --}}
                            <div class="space-y-2">
                                <label for="location"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('messages.unit_location') }}
                                </label>
                                <select name="location" id="location"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    @php
                                        use App\Enums\UnitLocation;
                                        $locations = UnitLocation::cases();
                                    @endphp
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->value }}"
                                            {{ old('location', $unit->location ?? null) === $location->value ? 'selected' : '' }}>
                                            {{ __('messages.' . $location->value) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status Section --}}
                    <div class="border-t border-gray-200 dark:border-gray-600">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                حالة الوحدة
                            </h2>
                            <p class="text-emerald-100 text-sm mt-1">اختر الحالة الحالية للوحدة</p>
                        </div>

                        <div class="p-6">
                            @php
                                $statuses = [
                                    'available' => [
                                        'label' => 'status_available',
                                        'color' => 'green',
                                        'icon' =>
                                            'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                                    ],
                                    'booked' => [
                                        'label' => 'status_booked',
                                        'color' => 'purple',
                                        'icon' =>
                                            'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                    ],
                                    'cleaning' => [
                                        'label' => 'status_cleaning',
                                        'color' => 'indigo',
                                        'icon' =>
                                            'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                                    ],
                                    'maintenance' => [
                                        'label' => 'status_maintenance',
                                        'color' => 'yellow',
                                        'icon' =>
                                            'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                                    ],
                                ];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($statuses as $value => $config)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="{{ $value }}"
                                            class="sr-only peer"
                                            {{ old('status', 'available') === $value ? 'checked' : '' }}>
                                        <div
                                            class="flex items-center p-4 bg-{{ $config['color'] }}-50 dark:bg-{{ $config['color'] }}-900/20 border-2 border-{{ $config['color'] }}-200 dark:border-{{ $config['color'] }}-800 rounded-xl transition-all duration-200 peer-checked:border-{{ $config['color'] }}-500 peer-checked:bg-{{ $config['color'] }}-100 dark:peer-checked:bg-{{ $config['color'] }}-900/40 hover:shadow-md">
                                            <div
                                                class="w-10 h-10 bg-{{ $config['color'] }}-500 rounded-lg flex items-center justify-center mr-3 rtl:ml-3 flex-shrink-0">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $config['icon'] }}" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p
                                                    class="font-medium text-{{ $config['color'] }}-800 dark:text-{{ $config['color'] }}-200">
                                                    {{ __('messages.' . $config['label']) }}
                                                </p>
                                                <p
                                                    class="text-sm text-{{ $config['color'] }}-600 dark:text-{{ $config['color'] }}-300">
                                                    @if ($value === 'available')
                                                        متاحة للإيجار
                                                    @elseif($value === 'booked')
                                                        محجوزة من قبل عميل
                                                    @elseif($value === 'cleaning')
                                                        قيد التنظيف
                                                    @else
                                                        قيد الصيانة
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('status')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Notes Section --}}
                    <div class="border-t border-gray-200 dark:border-gray-600">
                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                ملاحظات إضافية
                            </h2>
                            <p class="text-gray-100 text-sm mt-1">أضف أي ملاحظات أو تفاصيل إضافية (اختيارية)</p>
                        </div>

                        <div class="p-6">
                            <div class="space-y-2">
                                <label for="notes"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    {{ __('messages.notes') }}
                                </label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 resize-none"
                                    placeholder="أدخل أي ملاحظات أو تفاصيل إضافية عن الوحدة...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Submit Section --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                الحقول المميزة بـ * مطلوبة
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.units.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('messages.cancel') }}
                                </a>

                                <button type="button" onclick="resetForm()"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-500 dark:bg-yellow-600 hover:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded-xl transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    إعادة تعيين
                                </button>

                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('messages.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Reset form
        function resetForm() {
            if (confirm('هل أنت متأكد من إعادة تعيين النموذج؟ سيتم فقدان جميع البيانات المدخلة.')) {
                document.getElementById('unitForm').reset();

                // Reset radio buttons to default (available)
                document.querySelector('input[name="status"][value="available"]').checked = true;

                // Remove any error classes
                document.querySelectorAll('.border-red-500, .ring-red-500').forEach(element => {
                    element.classList.remove('border-red-500', 'ring-red-500');
                });

                // Remove any error messages
                document.querySelectorAll('.error-message').forEach(element => {
                    element.remove();
                });
            }
        }

        // Form validation
        document.getElementById('unitForm').addEventListener('submit', function(e) {
            const requiredFields = ['building_id', 'unit_number', 'rent_price'];
            let hasErrors = false;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                const value = input.type === 'select-one' ? input.value : input.value.trim();

                if (!value) {
                    hasErrors = true;
                    input.classList.add('border-red-500', 'ring-red-500');

                    // Show error message
                    let errorMsg = input.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className =
                            'error-message text-sm text-red-600 dark:text-red-400 flex items-center mt-1';
                        errorMsg.innerHTML =
                            '<svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>هذا الحقل مطلوب';
                        input.parentNode.appendChild(errorMsg);
                    }
                } else {
                    input.classList.remove('border-red-500', 'ring-red-500');
                    const errorMsg = input.parentNode.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });

            // Validate rent price is positive
            const rentPrice = document.getElementById('rent_price');
            if (rentPrice.value && parseFloat(rentPrice.value) <= 0) {
                hasErrors = true;
                rentPrice.classList.add('border-red-500', 'ring-red-500');

                let errorMsg = rentPrice.parentNode.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className =
                        'error-message text-sm text-red-600 dark:text-red-400 flex items-center mt-1';
                    errorMsg.innerHTML =
                        '<svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>يجب أن يكون السعر أكبر من صفر';
                    rentPrice.parentNode.appendChild(errorMsg);
                }
            }

            if (hasErrors) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });

        // Real-time validation
        document.querySelectorAll('input[required], select[required]').forEach(input => {
            input.addEventListener('blur', function() {
                const value = this.type === 'select-one' ? this.value : this.value.trim();
                if (value) {
                    this.classList.remove('border-red-500', 'ring-red-500');
                    const errorMsg = this.parentNode.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
        });

        // Building selection enhancement
        document.getElementById('building_id').addEventListener('change', function() {
            if (this.value) {
                // You can add logic here to fetch building info or units
                console.log('Building selected:', this.options[this.selectedIndex].text);
            }
        });

        // Unit number validation (alphanumeric)
        document.getElementById('unit_number').addEventListener('input', function(e) {
            // Allow letters, numbers, and common symbols
            const value = e.target.value;
            const filtered = value.replace(/[^a-zA-Z0-9\u0600-\u06FF\-\_\/\.]/g, '');
            if (value !== filtered) {
                e.target.value = filtered;
            }
        });

        // Price formatting
        document.getElementById('rent_price').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            if (value && value > 0) {
                // Add visual feedback for valid price
                this.classList.add('border-green-500');
                this.classList.remove('border-red-500');
            } else if (e.target.value) {
                this.classList.add('border-red-500');
                this.classList.remove('border-green-500');
            } else {
                this.classList.remove('border-green-500', 'border-red-500');
            }
        });

        // Auto-save to localStorage (draft)
        function saveDraft() {
            const formData = new FormData(document.getElementById('unitForm'));
            const draft = {};
            for (let [key, value] of formData.entries()) {
                draft[key] = value;
            }
            localStorage.setItem('unitDraft', JSON.stringify(draft));
        }

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('unitDraft');
            if (draft) {
                const data = JSON.parse(draft);
                for (let [key, value] of Object.entries(data)) {
                    const input = document.getElementById(key) || document.querySelector(`input[name="${key}"]`) ||
                        document.querySelector(`select[name="${key}"]`) || document.querySelector(
                            `textarea[name="${key}"]`);
                    if (input) {
                        if (input.type === 'radio') {
                            const radioInput = document.querySelector(`input[name="${key}"][value="${value}"]`);
                            if (radioInput) radioInput.checked = true;
                        } else {
                            input.value = value;
                        }
                    }
                }
            }
        });

        // Save draft on input change
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', debounce(saveDraft, 1000));
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Clear draft on successful submit
        document.getElementById('unitForm').addEventListener('submit', function() {
            if (this.checkValidity()) {
                localStorage.removeItem('unitDraft');
            }
        });

        // Add loading state to submit button
        document.getElementById('unitForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && this.checkValidity()) {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<svg class="animate-spin h-5 w-5 mr-2 rtl:ml-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>جاري الحفظ...';
            }
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

        /* Form improvements */
        .form-input:focus {
            outline: none;
            transform: translateY(-1px);
        }

        /* Radio button improvements */
        input[type="radio"]:checked+div {
            transform: scale(1.02);
        }

        /* Status selection improvements */
        .peer:checked+div {
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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

        [dir="rtl"] input,
        [dir="rtl"] select,
        [dir="rtl"] textarea {
            text-align: right;
        }

        [dir="rtl"] .pl-12 {
            padding-left: 1rem;
            padding-right: 3rem;
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
        }

        /* Error states */
        .border-red-500 {
            border-color: #ef4444 !important;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .ring-red-500 {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        /* Success states */
        .border-green-500 {
            border-color: #10b981 !important;
        }

        .ring-green-500 {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Form section dividers */
        .section-divider {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endsection
