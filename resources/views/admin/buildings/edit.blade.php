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
                            class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.edit_building') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">تعديل بيانات المبنى: {{ $building->name }}</p>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('admin.buildings.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_buildings') }}
                    </a>
                </div>
            </div>

            {{-- Main Form Section --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Left Column - Main Form --}}
                <div class="xl:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                معلومات المبنى الأساسية
                            </h2>
                        </div>

                        <form action="{{ route('admin.buildings.update', $building->id) }}" method="POST"
                            enctype="multipart/form-data" class="p-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Building Basic Info --}}
                                @php
                                    $basicFields = [
                                        [
                                            'name' => 'name',
                                            'label' => 'اسم المبنى',
                                            'type' => 'text',
                                            'required' => true,
                                            'icon' =>
                                                'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                                        ],
                                        [
                                            'name' => 'building_number',
                                            'label' => 'رقم المبنى',
                                            'type' => 'text',
                                            'required' => false,
                                            'icon' => 'M7 20l4-16m2 16l4-16M6 9h14M4 15h14',
                                        ],
                                        [
                                            'name' => 'address',
                                            'label' => 'العنوان',
                                            'type' => 'text',
                                            'required' => true,
                                            'icon' =>
                                                'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                                        ],
                                        [
                                            'name' => 'municipality_number',
                                            'label' => 'رقم تسجيل البلدية',
                                            'type' => 'text',
                                            'required' => false,
                                            'icon' =>
                                                'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                        ],
                                        [
                                            'name' => 'contract_start_date',
                                            'label' => 'تاريخ بداية العقد',
                                            'type' => 'date',
                                            'required' => false,
                                            'icon' =>
                                                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                        ],
                                        [
                                            'name' => 'contract_end_date',
                                            'label' => 'تاريخ نهاية العقد',
                                            'type' => 'date',
                                            'required' => false,
                                            'icon' =>
                                                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                        ],
                                    ];
                                @endphp

                                @foreach ($basicFields as $field)
                                    @php
                                        $name = $field['name'];
                                        $type = $field['type'];
                                        $required = $field['required'] ?? false;
                                        $icon = $field['icon'];

                                        // تحديد القيمة بناءً على النوع
                                        $value = old($name);
                                        if (!$value && isset($building->$name)) {
                                            if ($type === 'date' && $building->$name) {
                                                $value = optional($building->$name)->format('Y-m-d');
                                            } else {
                                                $value = $building->$name;
                                            }
                                        }
                                    @endphp

                                    <div class="space-y-2">
                                        <label for="{{ $name }}"
                                            class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $icon }}" />
                                            </svg>
                                            {{ $field['label'] }}
                                            @if ($required)
                                                <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                                            @endif
                                        </label>
                                        <div class="relative">
                                            <input type="{{ $type }}" name="{{ $name }}"
                                                id="{{ $name }}" value="{{ $value }}"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ $errors->has($name) ? 'border-red-500 ring-red-500' : '' }}"
                                                {{ $required ? 'required' : '' }}>
                                        </div>
                                        @error($name)
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
                                @endforeach



                                {{-- Location URL --}}
                                <div class="md:col-span-2 space-y-2">
                                    <label for="location_url"
                                        class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        رابط Google Maps
                                    </label>
                                    <div class="relative">
                                        <input type="url" name="location_url" id="location_url"
                                            value="{{ old('location_url', $building->location_url) }}"
                                            placeholder="https://maps.google.com/..."
                                            class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                        <div
                                            class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('location_url')
                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Owner Information Section --}}
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2 text-purple-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    معلومات المالك
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @php
                                        $ownerFields = [
                                            [
                                                'name' => 'owner_name',
                                                'label' => 'اسم المالك',
                                                'type' => 'text',
                                                'icon' =>
                                                    'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                            ],
                                            [
                                                'name' => 'owner_nationality',
                                                'label' => 'الجنسية',
                                                'type' => 'text',
                                                'icon' =>
                                                    'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9',
                                            ],
                                            [
                                                'name' => 'owner_id_number',
                                                'label' => 'رقم الهوية',
                                                'type' => 'text',
                                                'icon' =>
                                                    'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2',
                                            ],
                                            [
                                                'name' => 'owner_phone',
                                                'label' => 'رقم الموبايل',
                                                'type' => 'tel',
                                                'icon' =>
                                                    'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($ownerFields as $field)
                                        <div class="space-y-2">
                                            <label for="{{ $field['name'] }}"
                                                class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $field['icon'] }}" />
                                                </svg>
                                                {{ $field['label'] }}
                                            </label>
                                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                                id="{{ $field['name'] }}"
                                                value="{{ old($field['name'], $building->{$field['name']}) }}"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                            @error($field['name'])
                                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Financial Information Section --}}
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2 text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    المعلومات المالية
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @php
                                        $financialFields = [
                                            [
                                                'name' => 'rent_amount',
                                                'label' => 'سعر الإيجار (درهم)',
                                                'type' => 'number',
                                                'step' => '0.01',
                                                'unit' => 'AED',
                                            ],
                                            [
                                                'name' => 'initial_renovation_cost',
                                                'label' => 'تكاليف التعديل الأولي (درهم)',
                                                'type' => 'number',
                                                'step' => '0.01',
                                                'unit' => 'AED',
                                            ],
                                            [
                                                'name' => 'guarantee_cheque_amount',
                                                'label' => 'مبلغ شيك الضمان',
                                                'type' => 'number',
                                                'required' => false,
                                                'step' => '0.01',
                                                'icon' => '...',
                                                'unit' => 'AED',
                                            ],
                                            [
                                                'name' => 'grace_period_months',
                                                'label' => 'فترة السماح (بالأشهر)',
                                                'type' => 'number',
                                                'required' => false,
                                                'step' => 1,
                                                'icon' =>
                                                    'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                                'unit' => 'شهر',
                                            ],
                                        ];
                                    @endphp


                                    @foreach ($financialFields as $field)
                                        <div class="space-y-2">
                                            <label for="{{ $field['name'] }}"
                                                class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-orange-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $field['icon'] ?? 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1' }}" />
                                                </svg>
                                                {{ $field['label'] }}
                                            </label>
                                            <div class="relative">
                                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                                    id="{{ $field['name'] }}"
                                                    value="{{ old($field['name'], $building->{$field['name']}) }}"
                                                    step="{{ $field['step'] }}" min="0"
                                                    class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                                                @if (isset($field['unit']))
                                                    <div
                                                        class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                                        <span
                                                            class="text-orange-500 font-medium text-sm">{{ $field['unit'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @error($field['name'])
                                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            {{-- Image Upload Section --}}
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2 text-teal-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('messages.upload_new_image') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-center w-full">
                                        <label for="image"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">اضغط لرفع صورة</span> أو اسحب الصورة هنا
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG (أقصى
                                                    حجم: 2MB)</p>
                                            </div>
                                            <input id="image" name="image" type="file" accept="image/*"
                                                class="hidden">
                                        </label>
                                    </div>
                                    @error('image')
                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('messages.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column - Current Image & Settings --}}
                <div class="xl:col-span-1 space-y-6">
                    {{-- Current Image Card --}}
                    @if ($building->image)
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
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $building->image) }}" alt="صورة المبنى"
                                        class="w-full h-64 object-cover rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-300">

                                    <!-- View & Delete Actions -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 rounded-xl flex items-center justify-center">
                                        <div
                                            class="opacity-0 group-hover:opacity-100 flex space-x-3 rtl:space-x-reverse transition-all duration-300">
                                            <a href="{{ asset('storage/' . $building->image) }}" target="_blank"
                                                class="bg-white dark:bg-gray-800 text-gray-800 dark:text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                                <svg class="w-5 h-5 inline mr-2 rtl:ml-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                عرض كبير
                                            </a>

                                            <form action="{{ route('admin.buildings.deleteImage', $building->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                                    <svg class="w-5 h-5 inline mr-2 rtl:ml-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    حذف الصورة
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Settings Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                إعدادات المبنى
                            </h2>
                        </div>
                        <div class="p-6">
                            {{-- Family Only Toggle --}}
                            <form action="{{ route('admin.buildings.toggleFamiliesOnly', $building->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="space-y-4">
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                            <div
                                                class="w-10 h-10 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">نوع السكن</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $building->families_only ? 'عائلات فقط' : 'عام (عائلات وأفراد)' }}
                                                </p>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 {{ $building->families_only ? 'bg-pink-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                                            <span class="sr-only">تبديل الإعداد</span>
                                            <span
                                                class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $building->families_only ? 'translate-x-6 rtl:-translate-x-6' : 'translate-x-1 rtl:-translate-x-1' }}"></span>
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            تبديل نوع السكن
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Quick Stats Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                إحصائيات المبنى
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

                    {{-- Quick Actions Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
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
                            <a href="{{ route('admin.buildings.show', $building->id) }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                عرض تفاصيل المبنى
                            </a>

                            <a href="{{ route('admin.units.create', ['building_id' => $building->id]) }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                إضافة وحدة جديدة
                            </a>

                            <a href="{{ route('admin.building-utilities.create', ['building_id' => $building->id]) }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                إضافة مرفق جديد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview if needed
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        document.querySelector('form[method="POST"]').addEventListener('submit', function(e) {
            const requiredFields = ['name', 'address'];
            let hasErrors = false;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    hasErrors = true;
                    input.classList.add('border-red-500', 'ring-red-500');
                } else {
                    input.classList.remove('border-red-500', 'ring-red-500');
                }
            });

            if (hasErrors) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
            }
        });

        // Auto-save functionality (optional)
        let autoSaveTimeout;
        const inputs = document.querySelectorAll(
            'input[type="text"], input[type="number"], input[type="tel"], input[type="url"]');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Auto-save logic here if needed
                    console.log('Auto-save triggered for:', input.name);
                }, 2000);
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

        /* Form improvements */
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Custom file input styling */
        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(to right, #06b6d4, #0891b2);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(to right, #0891b2, #0e7490);
        }

        /* Toggle switch improvements */
        .toggle-switch {
            transition: all 0.3s ease;
        }

        .toggle-switch:checked {
            background-color: #ec4899;
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

        [dir="rtl"] input {
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
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        /* Error states */
        .border-red-500 {
            border-color: #ef4444 !important;
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
    </style>
@endsection
