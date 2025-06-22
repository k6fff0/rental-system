@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-2xl mx-auto">
            {{-- Header Section - Mobile Optimized --}}
            <div class="text-center mb-4 px-2">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-indigo-100 to-blue-100 dark:from-indigo-900/50 dark:to-blue-900/50 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight mb-1">
                    <span
                        class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-400 dark:to-blue-400 bg-clip-text text-transparent">
                        {{ __('messages.add_contract') }}
                    </span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.fill_contract_details') }}
                </p>
            </div>

            {{-- Alert Messages - Mobile Optimized --}}
            @if ($errors->any())
                <div
                    class="mb-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-700 dark:text-red-200 text-sm leading-relaxed">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main Form Container --}}
            <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data"
                id="contractForm"
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mx-2 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                @csrf

                {{-- Tenant Search Section --}}
                <div
                    class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="space-y-3">
                        <label for="tenant_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 ml-1 text-blue-500 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                {{ __('messages.tenant_search') }}
                                <span class="text-red-500 text-xs mr-1">*</span>
                            </span>
                        </label>

                        <div class="relative">
                            <input type="text" id="tenant_search" name="tenant_search" autocomplete="off"
                                placeholder="{{ __('messages.search_placeholder') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">

                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <input type="hidden" id="tenant_id" name="tenant_id">

                            <div id="tenant_results"
                                class="absolute z-50 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 w-full rounded-lg mt-1 hidden max-h-60 overflow-y-auto shadow-lg">
                            </div>
                        </div>

                        @error('tenant_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Main Form Content --}}
                <div class="p-4 space-y-4">
                    @php
                        $preselectedUnitId = request()->get('unit_id');
                        $preselectedUnit = $preselectedUnitId
                            ? \App\Models\Unit::with('building')->find($preselectedUnitId)
                            : null;
                    @endphp

                    {{-- Building and Unit Section --}}
                    @if ($preselectedUnit)
                        {{-- Hidden Fields --}}
                        <input type="hidden" name="building_id" value="{{ $preselectedUnit->building->id }}">
                        <input type="hidden" name="unit_id" value="{{ $preselectedUnit->id }}">

                        {{-- Building Display --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                {{ __('messages.building') }}
                            </label>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-white">
                                {{ $preselectedUnit->building->name }}
                            </div>
                        </div>

                        {{-- Unit Display --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 21v-4a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                </svg>
                                {{ __('messages.unit') }}
                            </label>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-white">
                                {{ $preselectedUnit->unit_number }}
                            </div>
                        </div>
                    @else
                        {{-- Building Select --}}
                        <div class="space-y-2">
                            <label for="building_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                {{ __('messages.building') }}
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <select name="building_id" id="building_id" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">{{ __('messages.choose_building') }}</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('building_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Unit Select --}}
                        <div class="space-y-2">
                            <label for="unit_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 21v-4a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                </svg>
                                {{ __('messages.unit') }}
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <select name="unit_id" id="unit_id" required disabled
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 disabled:opacity-50">
                                <option value="">{{ __('messages.choose_unit') }}</option>
                            </select>
                            @error('unit_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- Date Fields --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Start Date --}}
                        <div class="space-y-2">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('messages.start_date') }}
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            @error('start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('messages.end_date') }}
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            @error('end_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Rent Amount --}}
                    <div class="space-y-2">
                        <label for="rent_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            {{ __('messages.rent_amount') }}
                            <span class="text-red-500 text-xs">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}"
                                step="0.01" required min="0"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 {{ app()->getLocale() === 'ar' ? 'pl-16' : 'pr-16' }}">
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                <span
                                    class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ __('messages.currency') }}</span>
                            </div>
                        </div>
                        @error('rent_amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contract Image Upload --}}
                    <div class="space-y-2">
                        <label for="contract_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 16l4-4a3 3 0 014 0l4 4m4-4v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h1" />
                            </svg>
                            {{ __('messages.contract_image') }}
                        </label>

                        <div class="relative">
                            <input type="file" name="contract_image" id="contract_image" class="hidden"
                                accept="image/*" onchange="showFileName(this)">
                            <label for="contract_image" class="block w-full cursor-pointer">
                                <div
                                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500 mb-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 48 48">
                                        <path d="M14 10h20a2 2 0 012 2v24a2 2 0 01-2 2H14a2 2 0 01-2-2V12a2 2 0 012-2z"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16 20l6 6 10-10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span
                                            class="font-medium text-blue-600 dark:text-blue-400">{{ __('messages.choose_image') }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, JPEG, WEBP</p>
                                    <p id="file-name"
                                        class="text-xs text-blue-600 dark:text-blue-400 mt-2 hidden font-medium"></p>
                                </div>
                            </label>
                        </div>

                        @error('contract_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Notes --}}
                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            {{ __('messages.notes') }}
                        </label>
                        <textarea name="notes" id="notes" rows="3" placeholder="{{ __('messages.optional_notes') }}"
                            class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Terms and Conditions --}}
                    <div class="space-y-2">
                        <label for="terms" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 inline ml-1 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            {{ __('messages.terms_and_conditions') }}
                            <span class="text-red-500 text-xs">*</span>
                        </label>
                        <textarea name="terms" id="terms" rows="5" required
                            placeholder="{{ __('messages.contract_terms_placeholder') }}"
                            class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-mono resize-none">{{ old('terms', settings()->default_contract_terms ?? '') }}</textarea>
                        @error('terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Form Actions - Mobile Optimized --}}
                <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        {{-- Back Button --}}
                        <a href="{{ route('admin.contracts.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            {{ __('messages.save_contract') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Enhanced JavaScript for Mobile --}}
    <script>
        function showFileName(input) {
            const fileName = input.files[0]?.name;
            const label = document.getElementById('file-name');
            if (fileName) {
                label.textContent = fileName;
                label.classList.remove('hidden');
            } else {
                label.textContent = '';
                label.classList.add('hidden');
            }
        }

        // File name display function
        function showFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = '✓ ' + input.files[0].name;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }

        // Enhanced tenant search with mobile optimization
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('tenant_search');
            const resultsBox = document.getElementById('tenant_results');
            const hiddenInput = document.getElementById('tenant_id');
            let searchTimeout;

            // Debounced search function
            input.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(searchTimeout);

                if (query.length < 1) {
                    resultsBox.innerHTML = '';
                    resultsBox.classList.add('hidden');
                    hiddenInput.value = '';
                    return;
                }

                // Show loading state
                resultsBox.innerHTML = `
                    <div class="p-3 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                        <svg class="animate-spin h-4 w-4 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <div class="text-xs">{{ __('messages.searching') ?? 'جاري البحث...' }}</div>
                    </div>
                `;
                resultsBox.classList.remove('hidden');

                searchTimeout = setTimeout(() => {
                    fetch(`/admin/api/tenants/search?q=${encodeURIComponent(query)}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.length === 0) {
                                resultsBox.innerHTML = `
                                    <div class="p-3 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                                        <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <div class="text-sm">{{ __('messages.no_results') ?? 'لا توجد نتائج' }}</div>
                                    </div>
                                `;
                            } else {
                                resultsBox.innerHTML = data.map(tenant => `
                                    <div class="p-3 hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0 text-gray-700 dark:text-gray-300 flex items-center transition-colors duration-150"
                                         data-id="${tenant.id}" data-label="${tenant.name} - ${tenant.phone}">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full w-10 h-10 flex items-center justify-center me-3 flex-shrink-0 text-sm font-medium">
                                            ${tenant.name.charAt(0).toUpperCase()}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-gray-900 dark:text-white truncate">${tenant.name}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                ${tenant.phone}${tenant.id_number ? ' - ' + tenant.id_number : ''}
                                            </div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                `).join('');
                            }
                            resultsBox.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            resultsBox.innerHTML = `
                                <div class="p-3 text-center text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/20">
                                    <div class="text-sm">{{ __('messages.search_error') ?? 'حدث خطأ في البحث' }}</div>
                                </div>
                            `;
                        });
                }, 300);
            });

            // Handle result selection
            resultsBox.addEventListener('click', function(e) {
                const selected = e.target.closest('[data-id]');
                if (selected) {
                    input.value = selected.dataset.label;
                    hiddenInput.value = selected.dataset.id;
                    resultsBox.classList.add('hidden');

                    // Add visual feedback
                    input.classList.add('ring-2', 'ring-green-500', 'border-green-500');
                    setTimeout(() => {
                        input.classList.remove('ring-2', 'ring-green-500', 'border-green-500');
                    }, 1000);
                }
            });

            // Hide results when clicking outside
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.classList.add('hidden');
                }
            });

            // Clear selection when input is manually changed
            input.addEventListener('keydown', function() {
                if (hiddenInput.value) {
                    hiddenInput.value = '';
                }
            });
        });

        // Enhanced building and unit selection
        document.addEventListener('DOMContentLoaded', function() {
            const buildingSelect = document.getElementById('building_id');
            const unitSelect = document.getElementById('unit_id');

            if (buildingSelect && unitSelect) {
                buildingSelect.addEventListener('change', function() {
                    const buildingId = this.value;

                    // Reset unit select
                    unitSelect.disabled = true;
                    unitSelect.innerHTML = `
                        <option value="">{{ __('messages.loading') ?? 'جاري التحميل...' }}</option>
                    `;

                    if (!buildingId) {
                        unitSelect.innerHTML = `
                            <option value="">{{ __('messages.choose_building_first') ?? 'اختر المبنى أولاً' }}</option>
                        `;
                        return;
                    }

                    // Fetch available units
                    fetch(`/admin/api/buildings/${buildingId}/available-units`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(units => {
                            unitSelect.innerHTML = `
                                <option value="">{{ __('messages.choose_unit') ?? 'اختر الوحدة' }}</option>
                            `;

                            if (units.length === 0) {
                                unitSelect.innerHTML += `
                                    <option value="" disabled>{{ __('messages.no_available_units') ?? 'لا توجد وحدات متاحة' }}</option>
                                `;
                            } else {
                                units.forEach(unit => {
                                    const selected = "{{ old('unit_id') }}" == unit.id ?
                                        'selected' : '';
                                    unitSelect.innerHTML += `
                                        <option value="${unit.id}" ${selected}>${unit.unit_number}</option>
                                    `;
                                });
                            }
                            unitSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error fetching units:', error);
                            unitSelect.innerHTML = `
                                <option value="" disabled>{{ __('messages.error_loading_units') ?? 'خطأ في تحميل الوحدات' }}</option>
                            `;
                        });
                });

                // Trigger change event if building is pre-selected
                if (buildingSelect.value) {
                    buildingSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Form submission enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contractForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            form.addEventListener('submit', function(e) {
                // Prevent double submission
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Validate tenant selection
                const tenantId = document.getElementById('tenant_id').value;
                if (!tenantId) {
                    e.preventDefault();
                    alert('{{ __('messages.please_select_tenant') ?? 'الرجاء اختيار المستأجر' }}');
                    document.getElementById('tenant_search').focus();
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('messages.saving') ?? 'جاري الحفظ...' }}
                `;

                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }, 10000);
            });
        });

        // Auto-resize textareas
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });

                // Initial resize
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });

        // Mobile-specific optimizations
        document.addEventListener('DOMContentLoaded', function() {
            // Improve touch responsiveness on iOS
            if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                // Prevent zoom on input focus
                const inputs = document.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        if (this.style.fontSize !== '16px') {
                            this.style.fontSize = '16px';
                        }
                    });
                });
            }

            // Add haptic feedback for mobile interactions (if supported)
            if ('vibrate' in navigator) {
                const interactiveElements = document.querySelectorAll('button, [data-id], label[for]');
                interactiveElements.forEach(element => {
                    element.addEventListener('click', function() {
                        navigator.vibrate(10); // Short vibration
                    });
                });
            }

            // Optimize scrolling for mobile
            if (window.innerWidth <= 768) {
                const resultsBox = document.getElementById('tenant_results');
                if (resultsBox) {
                    resultsBox.style.maxHeight = '50vh';
                }
            }
        });

        // Date validation
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            if (startDate && endDate) {
                startDate.addEventListener('change', function() {
                    endDate.min = this.value;
                    if (endDate.value && endDate.value < this.value) {
                        endDate.value = '';
                    }
                });

                endDate.addEventListener('change', function() {
                    if (startDate.value && this.value < startDate.value) {
                        alert(
                            '{{ __('messages.end_date_must_be_after_start') ?? 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية' }}');
                        this.value = '';
                    }
                });
            }
        });
    </script>
@endsection
