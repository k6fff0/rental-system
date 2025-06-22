@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
         dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-2xl mx-auto">
            {{-- Header Section - Mobile Optimized --}}
            <div class="text-center mb-4 px-2">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight mb-1">
                    {{ __('messages.add_tenant') }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.fill_required_fields') }}
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

            {{-- Main Form --}}
            <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mx-2 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                @csrf

                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 px-4 py-3">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('messages.tenant_details') }}
                    </h2>
                </div>

                <div class="p-4 space-y-6">
                    {{-- Personal Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-bold">1</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.personal_info') }}</h3>
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
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Full Name">
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
                            <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}"
                                minlength="15" maxlength="15" pattern="\d{15}" inputmode="numeric"
                                title="يجب أن يكون 15 رقمًا"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="UAE id Number">
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
                                    {{ __('messages.tenant_type') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <select name="family_type" id="family_type" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="" disabled selected>{{ __('messages.select_tenant_type') }}</option>
                                <option value="individual" {{ old('family_type') == 'individual' ? 'selected' : '' }}>{{ __('messages.individual') }}</option>
                                <option value="family" {{ old('family_type') == 'family' ? 'selected' : '' }}>{{ __('messages.family') }}</option>
                            </select>
                            @error('family_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Identity Images --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Front ID Image --}}
                            <div class="space-y-2">
                                <label for="id_front" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ __('messages.id_front') }}
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="id_front" id="id_front" class="hidden" accept="image/*"
                                        onchange="showFileName(this, 'front-file-name')">
                                    <label for="id_front" class="block w-full cursor-pointer">
                                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30">
                                            <svg class="mx-auto h-6 w-6 text-gray-400 dark:text-gray-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-blue-600 dark:text-blue-400">{{ __('messages.choose_image') }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG</p>
                                            <p id="front-file-name" class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden font-medium"></p>
                                        </div>
                                    </label>
                                </div>
                                @error('id_front')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Back ID Image --}}
                            <div class="space-y-2">
                                <label for="id_back" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ __('messages.id_back') }}
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="id_back" id="id_back" class="hidden" accept="image/*"
                                        onchange="showFileName(this, 'back-file-name')">
                                    <label for="id_back" class="block w-full cursor-pointer">
                                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30">
                                            <svg class="mx-auto h-6 w-6 text-gray-400 dark:text-gray-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-blue-600 dark:text-blue-400">{{ __('messages.choose_image') }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG</p>
                                            <p id="back-file-name" class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden font-medium"></p>
                                        </div>
                                    </label>
                                </div>
                                @error('id_back')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Contact Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                <span class="text-green-600 dark:text-green-400 text-sm font-bold">2</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.contact_info') }}</h3>
                        </div>

                        {{-- Phone --}}
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
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                pattern="0\d{9}" maxlength="10" inputmode="numeric"
                                title="رقم الجوال يجب أن يبدأ بـ 0 ويحتوي على 10 أرقام"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="0501234567">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- WhatsApp Checkbox --}}
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_whatsapp" value="1" {{ old('is_whatsapp') ? 'checked' : '' }}
                                    class="w-4 h-4 text-green-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-green-500 dark:focus:ring-green-600 focus:ring-2">
                                <span class="mr-2 text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335 .157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.787"/>
                                    </svg>
                                    <span class="mr-2">{{__('messages.whatsapp_number') }}</span>
                                </span>
                            </label>
                        </div>
                        {{-- Secondary Phone with Alpine.js --}}
                        <div x-data="{ showExtra: {{ old('phone_secondary') ? 'true' : 'false' }} }" class="space-y-2">
                            <template x-if="showExtra">
                                <div class="space-y-2">
                                    <label for="phone_secondary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ __('messages.secondary_phone') ?? 'رقم إضافي' }}
                                        </span>
                                    </label>
                                    <input type="tel" name="phone_secondary" id="phone_secondary"
                                        value="{{ old('phone_secondary') }}"
                                        class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        placeholder="رقم إضافي">
                                </div>
                            </template>
                            <button type="button" @click="showExtra = true" x-show="!showExtra"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200 border border-blue-200 dark:border-blue-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('messages.add_another_phone') ?? 'إضافة رقم آخر' }}
                            </button>
                        </div>
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('messages.tenant_email') }}
                                </span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="{{ __('messages.email') }}"
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
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                placeholder="أضف أي ملاحظات إضافية هنا...">{{ old('notes') }}</textarea>
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
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>
                        
                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    
    <script>
        // File name display function
        function showFileName(input, targetId) {
            const fileNameElement = document.getElementById(targetId);
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
                    جاري الحفظ...
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
                    const phoneRegex = /^0\d{9}$/;
                    if (!phoneRegex.test(value)) {
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
                    // Remove non-numeric characters
                    let value = e.target.value.replace(/\D/g, '');

                    // Ensure it starts with 0 and limit to 10 digits
                    if (value.length > 0 && !value.startsWith('0')) {
                        value = '0' + value.substring(0, 9);
                    }
                    
                    if (value.length > 10) {
                        value = value.substring(0, 10);
                    }

                    e.target.value = value;
                });
            });

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
                    const interactiveElements = document.querySelectorAll('button, label[for], input[type="checkbox"]');
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
                    if (backButton && confirm('هل تريد الخروج بدون حفظ؟')) {
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
        });
    </script>
@endsection