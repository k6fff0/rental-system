@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-2xl mx-auto">
            {{-- Header Section - Mobile Optimized --}}
            <div class="text-center mb-4 px-2">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-orange-100 to-yellow-100 dark:from-orange-900/50 dark:to-yellow-900/50 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight mb-1">
                    {{ __('messages.edit_contract') }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.update_contract_details') }}
                </p>
            </div>

            {{-- Alert Messages --}}
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

            @if (session('success'))
                <div
                    class="mb-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-700 dark:text-green-200 text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Main Form --}}
            <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mx-2 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                @csrf
                @method('PUT')

                {{-- Form Header --}}
                <div
                    class="bg-gradient-to-r from-orange-600 to-yellow-600 dark:from-orange-700 dark:to-yellow-700 px-4 py-3">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        {{ __('messages.contract_information') }}
                    </h2>
                </div>

                <div class="p-4 space-y-6">
                    {{-- Contract Parties Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-bold">1</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.contract_parties') }}</h3>
                        </div>

                        {{-- Tenant Display (Read-Only) --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('messages.tenant') }}
                                </span>
                            </label>
                            <input type="text" value="{{ $contract->tenant->name ?? '' }}" readonly
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white cursor-not-allowed">
                            <input type="hidden" name="tenant_id" value="{{ $contract->tenant_id }}">
                        </div>

                        {{-- Unit Display (Read-Only) --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 21v-4a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                    </svg>
                                    {{ __('messages.unit') }}
                                </span>
                            </label>
                            <input type="text"
                                value="{{ $contract->unit->unit_number }} - {{ $contract->unit->building->name ?? '' }}"
                                readonly
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white cursor-not-allowed">
                            <input type="hidden" name="unit_id" value="{{ $contract->unit_id }}">
                        </div>

                    </div>

                    {{-- Contract Terms Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                <span class="text-green-600 dark:text-green-400 text-sm font-bold">2</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.contract_terms') }}</h3>
                        </div>

                        {{-- Date Fields --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Start Date (Disabled) --}}
                            <div class="space-y-2">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ __('messages.start_date') }}
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400">({{ __('messages.fixed') }})</span>
                                    </span>
                                </label>
                                <input type="date" id="start_date"
                                    value="{{ $contract->start_date->format('Y-m-d') }}" disabled
                                    class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                <input type="hidden" name="start_date"
                                    value="{{ $contract->start_date->format('Y-m-d') }}">
                            </div>

                            {{-- End Date --}}
                            <div class="space-y-2">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ __('messages.end_date') }}
                                        <span class="text-red-500 text-xs">*</span>
                                    </span>
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required
                                    min="{{ $contract->start_date->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Rent Amount --}}
                        <div class="space-y-2">
                            <label for="rent_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                    {{ __('messages.rent_amount') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" name="rent_amount" id="rent_amount"
                                    value="{{ old('rent_amount', $contract->rent_amount) }}" required step="0.01"
                                    min="0"
                                    class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 {{ app()->getLocale() === 'ar' ? 'pl-16' : 'pr-16' }}">
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
                    </div>

                    {{-- Files and Notes Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 dark:text-purple-400 text-sm font-bold">3</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.files_and_notes') }}</h3>
                        </div>

                        {{-- Current Contract File --}}
                        @if ($contract->contract_file)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        {{ __('messages.existing_contract_file') }}
                                    </span>
                                </label>
                                <div
                                    class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                                        class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ __('messages.view_contract') }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Upload New Contract File --}}
                        <div class="space-y-2">
                            <label for="contract_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    {{ __('messages.upload_new_contract') }}
                                </span>
                            </label>
                            <div class="relative">
                                <input type="file" name="contract_file" id="contract_file" class="hidden"
                                    accept=".pdf,.doc,.docx" onchange="showFileName(this)">
                                <label for="contract_file" class="block w-full cursor-pointer">
                                    <div
                                        class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-orange-400 dark:hover:border-orange-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span
                                                class="font-medium text-orange-600 dark:text-orange-400">{{ __('messages.choose_file') }}</span>
                                            {{ __('messages.or_drag_and_drop') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PDF, DOC, DOCX</p>
                                        <p id="file-name"
                                            class="text-xs text-orange-600 dark:text-orange-400 mt-2 hidden font-medium">
                                        </p>
                                    </div>
                                </label>
                            </div>
                            @error('contract_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    {{ __('messages.notes') }}
                                </span>
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                placeholder="{{ __('messages.contract_notes_placeholder') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none">{{ old('notes', $contract->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions - Mobile Optimized --}}
                <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        {{-- Back Button --}}
                        <a href="{{ route('admin.contracts.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>

                        {{-- Update Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            {{ __('messages.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Form validation and submission
            form.addEventListener('submit', function(e) {
                // Prevent double submission
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Basic form validation
                const requiredFields = form.querySelectorAll('[required]');
                let hasErrors = false;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        hasErrors = true;
                    } else {
                        field.classList.remove('border-red-500', 'dark:border-red-500');
                    }
                });

                if (hasErrors) {
                    e.preventDefault();
                    showNotification('{{ __('messages.please_fill_required_fields') }}', 'error');

                    // Focus on first error field
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('messages.updating') }}...
                `;

                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }, 10000);
            });

            // Real-time form validation
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-500')) {
                        validateField(this);
                    }
                });
            });

            // Field validation function
            function validateField(field) {
                const value = field.value.trim();
                const isRequired = field.hasAttribute('required');

                // Remove existing validation classes
                field.classList.remove('border-red-500', 'border-green-500', 'dark:border-red-500',
                    'dark:border-green-500');

                if (isRequired && !value) {
                    field.classList.add('border-red-500', 'dark:border-red-500');
                    return false;
                }

                // Date validation
                if (field.name === 'end_date' && value) {
                    const startDate = new Date(document.querySelector('input[name="start_date"]').value);
                    const endDate = new Date(value);

                    if (endDate <= startDate) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        return false;
                    }
                }

                // Amount validation
                if (field.name === 'rent_amount' && value) {
                    const amount = parseFloat(value);
                    if (isNaN(amount) || amount <= 0) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        return false;
                    }
                }

                // If validation passes and field has value
                if (value) {
                    field.classList.add('border-green-500', 'dark:border-green-500');
                }

                return true;
            }

            // Auto-format rent amount
            const rentInput = document.querySelector('#rent_amount');
            if (rentInput) {
                rentInput.addEventListener('input', function(e) {
                    let value = e.target.value;

                    // Remove invalid characters (keep only numbers and one decimal point)
                    value = value.replace(/[^0-9.]/g, '');

                    // Ensure only one decimal point
                    const parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }

                    // Limit decimal places to 2
                    if (parts[1] && parts[1].length > 2) {
                        value = parts[0] + '.' + parts[1].substring(0, 2);
                    }

                    e.target.value = value;
                });
            }

            // Date validation
            const endDateInput = document.querySelector('#end_date');
            const startDateValue = document.querySelector('input[name="start_date"]').value;

            if (endDateInput && startDateValue) {
                endDateInput.addEventListener('change', function() {
                    const endDate = new Date(this.value);
                    const startDate = new Date(startDateValue);

                    if (endDate <= startDate) {
                        this.classList.add('border-red-500', 'dark:border-red-500');
                        showNotification('{{ __('messages.end_date_must_be_after_start') }}', 'error');
                        this.value = '';
                    } else {
                        this.classList.remove('border-red-500', 'dark:border-red-500');
                        this.classList.add('border-green-500', 'dark:border-green-500');
                    }
                });
            }

            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });

                // Initial resize
                textarea.style.height = textarea.scrollHeight + 'px';
            });

            // Drag and drop functionality for file upload
            const fileInput = document.getElementById('contract_file');
            const fileLabel = fileInput.nextElementSibling;
            const dropZone = fileLabel.querySelector('div');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    showFileName(fileInput);
                }
            }

            // Notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotification = document.querySelector('.notification');
                if (existingNotification) {
                    existingNotification.remove();
                }

                // Create notification
                const notification = document.createElement('div');
                notification.className =
                    `notification fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

                // Set colors based on type
                if (type === 'error') {
                    notification.className += ' bg-red-500 text-white';
                } else if (type === 'success') {
                    notification.className += ' bg-green-500 text-white';
                } else {
                    notification.className += ' bg-blue-500 text-white';
                }

                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            ${type === 'error' ? 
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                                type === 'success' ?
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                            }
                        </div>
                        <div class="flex-1 text-sm font-medium">
                            ${message}
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-2 text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            // Mobile-specific optimizations
            if (window.innerWidth <= 768) {
                // Improve touch responsiveness on iOS
                if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                    // Prevent zoom on input focus
                    const allInputs = document.querySelectorAll('input, select, textarea');
                    allInputs.forEach(input => {
                        input.addEventListener('focus', function() {
                            if (this.style.fontSize !== '16px') {
                                this.style.fontSize = '16px';
                            }
                        });
                    });
                }

                // Add haptic feedback for mobile interactions (if supported)
                if ('vibrate' in navigator) {
                    const interactiveElements = document.querySelectorAll('button, select, label[for]');
                    interactiveElements.forEach(element => {
                        element.addEventListener('click', function() {
                            navigator.vibrate(10); // Short vibration
                        });
                    });
                }
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S to save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }

                // Escape to go back
                if (e.key === 'Escape') {
                    const backButton = document.querySelector('a[href*="contracts.index"]');
                    if (backButton && confirm('{{ __('messages.exit_without_saving_changes') }}')) {
                        backButton.click();
                    }
                }
            });

            // Form section animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Animate form sections on scroll
            const sections = document.querySelectorAll('.space-y-4');
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });

            // Make notification function globally available
            window.showNotification = showNotification;

            // Show success message if updated
            @if (session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
        });
    </script>
@endsection
