@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
         dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-2xl mx-auto">
            {{-- Header Section - Mobile Optimized --}}
            <div class="text-center mb-4 px-2">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/50 dark:to-red-900/50 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight mb-1">
                    {{ __('messages.edit_tenant') }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.edit_tenant_data') }} : {{ $tenant->name }}
                </p>
            </div>

            {{-- Alert Messages --}}
            @if ($errors->any())
                <div class="mb-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
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
                <div class="mb-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-700 dark:text-green-200 text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Main Form --}}
            <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST"
                  class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mx-2 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                @csrf
                @method('PUT')

                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-orange-600 to-red-600 dark:from-orange-700 dark:to-red-700 px-4 py-3">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('messages.edit_tenant_data') }}
                    </h2>
                </div>

                <div class="p-4 space-y-6">
                    {{-- Personal Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-bold">1</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.personal_information') }}</h3>
                        </div>

                        {{-- Full Name --}}
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('messages.full_name') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="{{ __('messages.full_name_placeholder') }}">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ID Number --}}
                        <div class="space-y-2">
                            <label for="id_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    {{ __('messages.id_number') }}
                                </span>
                            </label>
                            <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $tenant->id_number) }}"
                                minlength="15" maxlength="15" pattern="\d{15}" inputmode="numeric"
                                title="يجب أن يكون 15 رقمًا"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="{{ __('messages.id_number_placeholder') }}">
                            @error('id_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Family Type --}}
                        <div class="space-y-2">
                            <label for="family_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ __('messages.family_type') }}
                                </span>
                            </label>
                            <select name="family_type" id="family_type"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                <option value="individual" {{ old('family_type', $tenant->family_type) === 'individual' ? 'selected' : '' }}>
                                    {{ __('messages.individual') }}
                                </option>
                                <option value="family" {{ old('family_type', $tenant->family_type) === 'family' ? 'selected' : '' }}>
                                    {{ __('messages.family') }}
                                </option>
                            </select>
                            @error('family_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status and Financial Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/50 rounded-full flex items-center justify-center">
                                <span class="text-yellow-600 dark:text-yellow-400 text-sm font-bold">2</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.status_financial_info') }}</h3>
                        </div>

                        {{-- Tenant Status --}}
                        <div class="space-y-2">
                            <label for="tenant_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('messages.tenant_status') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <select name="tenant_status" id="tenant_status" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                <option value="active" {{ old('tenant_status', $tenant->tenant_status) == 'active' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_active') }}
                                </option>
                                <option value="late_payer" {{ old('tenant_status', $tenant->tenant_status) == 'late_payer' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_late_payer') }}
                                </option>
                                <option value="has_debt" {{ old('tenant_status', $tenant->tenant_status) == 'has_debt' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_has_debt') }}
                                </option>
                                <option value="absent" {{ old('tenant_status', $tenant->tenant_status) == 'absent' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_absent') }}
                                </option>
                                <option value="abroad" {{ old('tenant_status', $tenant->tenant_status) == 'abroad' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_abroad') }}
                                </option>
                                <option value="legal_issue" {{ old('tenant_status', $tenant->tenant_status) == 'legal_issue' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_legal_issue') }}
                                </option>
                                <option value="blocked" {{ old('tenant_status', $tenant->tenant_status) == 'blocked' ? 'selected' : '' }}>
                                    {{ __('messages.tenant_status_blocked') }}
                                </option>
                            </select>
                            @error('tenant_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Debt Amount --}}
                        <div class="space-y-2">
                            <label for="debt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    {{ __('messages.debt') }}
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" name="debt" id="debt" min="0" step="0.01"
                                    value="{{ old('debt', $tenant->debt) }}"
                                    class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 {{ app()->getLocale() === 'ar' ? 'pl-16' : 'pr-16' }}"
                                    placeholder="0.00">
                                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">AED</span>
                                </div>
                            </div>
                            @error('debt')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Contact Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                <span class="text-green-600 dark:text-green-400 text-sm font-bold">3</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.contact_information') }}</h3>
                        </div>

                        {{-- Primary Phone --}}
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ __('messages.phone') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $tenant->phone ?? '') }}" required
                                pattern="^\+\d{6,15}$" title="يرجى إدخال الرقم مع مفتاح الدولة مثل: +971501234567"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="+971501234567">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Secondary Phone with Toggle --}}
                        <div x-data="{ showSecondary: {{ old('phone_secondary', $tenant->phone_secondary) ? 'true' : 'false' }} }" class="space-y-2">
                            <template x-if="showSecondary">
                                <div class="space-y-2">
                                    <label for="phone_secondary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ __('messages.secondary_phone') }}
                                        </span>
                                    </label>
                                    <input type="tel" name="phone_secondary" id="phone_secondary"
                                        value="{{ old('phone_secondary', $tenant->phone_secondary ?? '') }}"
                                        pattern="^\+\d{6,15}$" title="يرجى إدخال الرقم مع مفتاح الدولة مثل: +971501234567"
                                        class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        placeholder="+971501234567">
                                </div>
                            </template>

                            <button type="button" @click="showSecondary = true" x-show="!showSecondary"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200 border border-blue-200 dark:border-blue-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('messages.add_another_phone') }}
                            </button>
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('messages.email') }}
                                </span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="البريد الإلكتروني (اختياري)">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    {{ __('messages.notes') }}
                                </span>
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none"
                                placeholder="أضف أي ملاحظات إضافية هنا...">{{ old('notes', $tenant->notes) }}</textarea>
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
                        <a href="{{ route('admin.tenants.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>
                        
                        {{-- Update Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            {{ __('messages.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    
    <script>
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
                    showNotification('يرجى ملء جميع الحقول المطلوبة', 'error');
                    
                    // Focus on first error field
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
                    جاري التحديث...
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
                field.classList.remove('border-red-500', 'border-green-500', 'dark:border-red-500', 'dark:border-green-500');

                if (isRequired && !value) {
                    field.classList.add('border-red-500', 'dark:border-red-500');
                    return false;
                }

                // Email validation
                if (field.type === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        return false;
                    }
                }

                // ID number validation
                if (field.name === 'id_number' && value) {
                    const idRegex = /^[0-9]{15}$/;
                    if (!idRegex.test(value)) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        return false;
                    }
                }

                // Phone validation
                if (field.name === 'phone' && value) {
                    const phoneRegex = /^\+\d{6,15}$/;
                    if (!phoneRegex.test(value)) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        return false;
                    }
                }

                // Debt validation
                if (field.name === 'debt' && value) {
                    const debtValue = parseFloat(value);
                    if (isNaN(debtValue) || debtValue < 0) {
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

            // Auto-format ID number input
            const idInput = document.querySelector('#id_number');
            if (idInput) {
                idInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    let value = e.target.value.replace(/\D/g, '');

                    // Limit to 15 digits
                    if (value.length > 15) {
                        value = value.substring(0, 15);
                    }

                    e.target.value = value;
                });
            }

            // Auto-format phone inputs
            const phoneInputs = document.querySelectorAll('input[type="tel"]');
            phoneInputs.forEach(phoneInput => {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value;

                    // Ensure it starts with + if user types numbers
                    if (value.length > 0 && !value.startsWith('+') && /^\d/.test(value)) {
                        value = '+' + value;
                    }

                    // Remove invalid characters (keep only + and numbers)
                    value = value.replace(/[^\d+]/g, '');

                    // Ensure only one + at the beginning
                    if (value.indexOf('+') > 0) {
                        value = '+' + value.replace(/\+/g, '');
                    }

                    // Limit total length
                    if (value.length > 16) {
                        value = value.substring(0, 16);
                    }

                    e.target.value = value;
                });

                // Add country code placeholder helper
                phoneInput.addEventListener('focus', function(e) {
                    if (!e.target.value) {
                        e.target.placeholder = '+971501234567';
                    }
                });
            });

            // Auto-format debt input
            const debtInput = document.querySelector('#debt');
            if (debtInput) {
                debtInput.addEventListener('input', function(e) {
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

            // Status change visual feedback
            const statusSelect = document.querySelector('#tenant_status');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    const value = this.value;
                    const statusColors = {
                        'active': 'border-green-500 dark:border-green-500',
                        'late_payer': 'border-yellow-500 dark:border-yellow-500',
                        'has_debt': 'border-orange-500 dark:border-orange-500',
                        'absent': 'border-gray-500 dark:border-gray-500',
                        'abroad': 'border-blue-500 dark:border-blue-500',
                        'legal_issue': 'border-red-500 dark:border-red-500',
                        'blocked': 'border-red-600 dark:border-red-600'
                    };

                    // Remove all status colors
                    Object.values(statusColors).forEach(colorClass => {
                        this.classList.remove(...colorClass.split(' '));
                    });

                    // Add current status color
                    if (statusColors[value]) {
                        this.classList.add(...statusColors[value].split(' '));
                    }
                });

                // Trigger initial status color
                statusSelect.dispatchEvent(new Event('change'));
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
                notification.className = `notification fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

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
                    const interactiveElements = document.querySelectorAll('button, select');
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
                    const backButton = document.querySelector('a[href*="tenants.index"]');
                    if (backButton && confirm('هل تريد الخروج بدون حفظ التغييرات؟')) {
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
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
        });
    </script>
@endsection