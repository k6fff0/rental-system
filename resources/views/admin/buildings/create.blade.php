@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <!-- Title Section -->
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.add_new_building') }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">إضافة مبنى جديد إلى النظام</p>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('admin.buildings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('messages.back_to_buildings_list') }}
                </a>
            </div>
        </div>

        {{-- Main Form Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('admin.buildings.store') }}" method="POST" enctype="multipart/form-data" id="buildingForm">
                @csrf
                
                {{-- Basic Information Section --}}
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        المعلومات الأساسية
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">أدخل البيانات الأساسية للمبنى</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- اسم المبنى --}}
                        <div class="lg:col-span-2 space-y-2">
                            <label for="name" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ __('messages.building_name') }}
                                <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ $errors->has('name') ? 'border-red-500 ring-red-500' : '' }}"
                                       placeholder="أدخل اسم المبنى"
                                       required>
                                <div class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- رقم المبنى --}}
                        <div class="space-y-2">
                            <label for="building_number" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                {{ __('messages.building_number') }}
                            </label>
                            <input type="text" 
                                   name="building_number" 
                                   id="building_number" 
                                   value="{{ old('building_number') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                   placeholder="123">
                            @error('building_number')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- العنوان --}}
                        <div class="lg:col-span-3 space-y-2">
                            <label for="address" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ __('messages.address') }}
                                <span class="text-red-500 mr-1 rtl:ml-1">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="address" 
                                          id="address" 
                                          rows="3"
                                          class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none {{ $errors->has('address') ? 'border-red-500 ring-red-500' : '' }}"
                                          placeholder="أدخل العنوان الكامل للمبنى"
                                          required>{{ old('address') }}</textarea>
                                <div class="absolute top-3 left-3 rtl:right-3 rtl:left-auto pointer-events-none">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('address')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- رابط Google Maps --}}
                        <div class="lg:col-span-2 space-y-2">
                            <label for="location_url" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                {{ __('messages.google_maps_url') }}
                            </label>
                            <div class="relative">
                                <input type="url" 
                                       name="location_url" 
                                       id="location_url" 
                                       value="{{ old('location_url') }}"
                                       class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="https://maps.google.com/...">
                                <div class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                </div>
                            </div>
                            @error('location_url')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم البلدية --}}
                        <div class="space-y-2">
                            <label for="municipality_number" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ __('messages.municipality_number') }}
                            </label>
                            <input type="text" 
                                   name="municipality_number" 
                                   id="municipality_number" 
                                   value="{{ old('municipality_number') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200"
                                   placeholder="رقم البلدية">
                            @error('municipality_number')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Owner Information Section --}}
                <div class="border-t border-gray-200 dark:border-gray-600">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            معلومات المالك
                        </h2>
                        <p class="text-purple-100 text-sm mt-1">بيانات مالك المبنى (اختيارية)</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- اسم المالك --}}
                            <div class="space-y-2">
                                <label for="owner_name" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('messages.owner_name') }}
                                </label>
                                <input type="text" 
                                       name="owner_name" 
                                       id="owner_name" 
                                       value="{{ old('owner_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                @error('owner_name')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- الجنسية --}}
                            <div class="space-y-2">
                                <label for="owner_nationality" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                    </svg>
                                    {{ __('messages.owner_nationality') }}
                                </label>
                                <input type="text" 
                                       name="owner_nationality" 
                                       id="owner_nationality" 
                                       value="{{ old('owner_nationality') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                @error('owner_nationality')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- رقم الهوية --}}
                            <div class="space-y-2">
                                <label for="owner_id_number" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    {{ __('messages.owner_id_number') }}
                                </label>
                                <input type="text" 
                                       name="owner_id_number" 
                                       id="owner_id_number" 
                                       value="{{ old('owner_id_number') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                @error('owner_id_number')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- رقم الجوال --}}
                            <div class="space-y-2">
                                <label for="owner_phone" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ __('messages.owner_phone') }}
                                </label>
                                <input type="tel" 
                                       name="owner_phone" 
                                       id="owner_phone" 
                                       value="{{ old('owner_phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200"
                                       placeholder="+971501234567">
                                @error('owner_phone')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Financial Information Section --}}
                <div class="border-t border-gray-200 dark:border-gray-600">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            المعلومات المالية
                        </h2>
                        <p class="text-orange-100 text-sm mt-1">الأسعار والتكاليف (اختيارية)</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- سعر الإيجار --}}
                            <div class="space-y-2">
                                <label for="rent_amount" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    {{ __('messages.rent_amount') }} (درهم)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="rent_amount" 
                                           id="rent_amount" 
                                           value="{{ old('rent_amount') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                        <span class="text-orange-500 font-medium text-sm">AED</span>
                                    </div>
                                </div>
                                @error('rent_amount')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- التعديل الأولي --}}
                            <div class="space-y-2">
                                <label for="initial_renovation_cost" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    {{ __('messages.initial_renovation_cost') }} (درهم)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="initial_renovation_cost" 
                                           id="initial_renovation_cost" 
                                           value="{{ old('initial_renovation_cost') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 pl-12 rtl:pr-12 rtl:pl-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 left-3 rtl:right-3 rtl:left-auto flex items-center pointer-events-none">
                                        <span class="text-orange-500 font-medium text-sm">AED</span>
                                    </div>
                                </div>
                                @error('initial_renovation_cost')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image Upload Section --}}
                <div class="border-t border-gray-200 dark:border-gray-600">
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('messages.building_image') }}
                        </h2>
                        <p class="text-teal-100 text-sm mt-1">رفع صورة للمبنى (اختيارية)</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-2xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-4 text-gray-500 dark:text-gray-400 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">اضغط لرفع صورة</span> أو اسحب الصورة هنا
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG (أقصى حجم: 2MB)</p>
                                    </div>
                                    <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(this)">
                                </label>
                            </div>
                            
                            {{-- Image Preview --}}
                            <div id="imagePreview" class="hidden">
                                <div class="relative w-32 h-32 mx-auto">
                                    <img id="previewImg" src="" alt="معاينة الصورة" class="w-32 h-32 object-cover rounded-xl shadow-lg border-2 border-teal-500">
                                    <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @error('image')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Section --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            الحقول المميزة بـ * مطلوبة
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <button type="button" 
                                    onclick="resetForm()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                إعادة تعيين
                            </button>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('messages.save_building') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove image preview
function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
}

// Reset form
function resetForm() {
    if (confirm('هل أنت متأكد من إعادة تعيين النموذج؟ سيتم فقدان جميع البيانات المدخلة.')) {
        document.getElementById('buildingForm').reset();
        removeImage();
        
        // Remove any error classes
        document.querySelectorAll('.border-red-500, .ring-red-500').forEach(element => {
            element.classList.remove('border-red-500', 'ring-red-500');
        });
    }
}

// Form validation
document.getElementById('buildingForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'address'];
    let hasErrors = false;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        const value = input.value.trim();
        
        if (!value) {
            hasErrors = true;
            input.classList.add('border-red-500', 'ring-red-500');
            
            // Show error message
            let errorMsg = input.parentNode.querySelector('.error-message');
            if (!errorMsg) {
                errorMsg = document.createElement('p');
                errorMsg.className = 'error-message text-sm text-red-600 dark:text-red-400 flex items-center mt-1';
                errorMsg.innerHTML = '<svg class="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>هذا الحقل مطلوب';
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
    
    if (hasErrors) {
        e.preventDefault();
        // Scroll to first error
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

// Real-time validation
document.querySelectorAll('input[required]').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500', 'ring-red-500');
            const errorMsg = this.parentNode.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    });
});

// Auto-format phone number
document.getElementById('owner_phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('971')) {
        value = '+' + value;
    } else if (value.startsWith('05') || value.startsWith('50') || value.startsWith('52') || value.startsWith('54') || value.startsWith('55') || value.startsWith('56') || value.startsWith('58')) {
        value = '+971' + value;
    }
    e.target.value = value;
});

// Auto-save to localStorage (draft)
function saveDraft() {
    const formData = new FormData(document.getElementById('buildingForm'));
    const draft = {};
    for (let [key, value] of formData.entries()) {
        if (key !== 'image') { // Don't save file input
            draft[key] = value;
        }
    }
    localStorage.setItem('buildingDraft', JSON.stringify(draft));
}

// Load draft on page load
window.addEventListener('load', function() {
    const draft = localStorage.getItem('buildingDraft');
    if (draft) {
        const data = JSON.parse(draft);
        for (let [key, value] of Object.entries(data)) {
            const input = document.getElementById(key);
            if (input && input.type !== 'file') {
                input.value = value;
            }
        }
    }
});

// Save draft on input change
document.querySelectorAll('input, textarea').forEach(input => {
    if (input.type !== 'file') {
        input.addEventListener('input', debounce(saveDraft, 1000));
    }
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
document.getElementById('buildingForm').addEventListener('submit', function() {
    if (this.checkValidity()) {
        localStorage.removeItem('buildingDraft');
    }
});
</script>

<style>
/* Custom animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* Loading spinner */
@keyframes spin {
    to { transform: rotate(360deg); }
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

/* Image preview improvements */
#imagePreview img {
    transition: transform 0.3s ease;
}

#imagePreview:hover img {
    transform: scale(1.05);
}

/* Button hover effects */
button, a {
    transition: all 0.2s ease;
}

/* RTL Support improvements */
[dir="rtl"] .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 1;
}

[dir="rtl"] input, [dir="rtl"] textarea {
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
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
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

/* Drag and drop improvements */
.drag-over {
    border-color: #06b6d4 !important;
    background-color: rgba(6, 182, 212, 0.1) !important;
}

/* Form section headers */
.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection