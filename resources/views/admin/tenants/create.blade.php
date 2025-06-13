@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-6 px-4 sm:px-6 lg:px-8"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('messages.add_tenant') }}</h1>
                <p class="text-gray-600 max-w-md mx-auto">قم بإدخال جميع البيانات المطلوبة لإضافة مستأجر جديد</p>
            </div>

            <!-- Main Form -->
            <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                @csrf

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        بيانات المستأجر
                    </h2>
                </div>

                <div class="p-6 sm:p-8">
                    <!-- Personal Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-sm font-bold">1</span>
                            </div>
                            المعلومات الشخصية
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="space-y-2">
                                <label for="name"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('messages.full_name') }}
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="أدخل الاسم الكامل">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ID Number -->
                            <div class="space-y-2">
                                <label for="id_number"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                        </path>
                                    </svg>
                                    {{ __('messages.id_number') }}
                                </label>
                                <input type="text"
    name="id_number"
    id="id_number"
    value="{{ old('id_number') }}"
    minlength="15"
    maxlength="15"
    pattern="\d{15}"
    inputmode="numeric"
    title="يجب أن يكون 15 رقمًا"
    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
    placeholder="رقم الهوية">

                                @error('id_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Family Type -->
                            <div class="space-y-2">
                                <label for="family_type"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    نوع المستأجر
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="family_type" id="family_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="" disabled selected>اختر نوع المستأجر</option>
                                    <option value="individual" {{ old('family_type') == 'individual' ? 'selected' : '' }}>
                                        فرد</option>
                                    <option value="family" {{ old('family_type') == 'family' ? 'selected' : '' }}>عائلة
                                    </option>
                                </select>
                                @error('family_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Identity Images (Front + Back) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Front Image -->
                                <div class="space-y-2">
                                    <label for="id_front"
                                        class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-2.828-2.828z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 4l3.5 3.5"></path>
                                        </svg>
                                        {{ __('messages.id_front') ?? 'صورة الهوية (الوجه)' }}
                                    </label>
                                    <input type="file" name="id_front" id="id_front" accept="image/*"
                                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200" />
                                    @error('id_front')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Back Image -->
                                <div class="space-y-2">
                                    <label for="id_back"
                                        class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        {{ __('messages.id_back') ?? 'صورة الهوية (الظهر)' }}
                                    </label>
                                    <input type="file" name="id_back" id="id_back" accept="image/*"
                                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200" />
                                    @error('id_back')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-sm font-bold">2</span>
                            </div>
                            معلومات التواصل
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div class="space-y-2">
                                <label for="phone"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ __('messages.phone') }}
                                </label>
                                <input type="tel"
       name="phone"
       id="phone"
       value="{{ old('phone', $tenant->phone ?? '') }}"
       pattern="0\d{9}"
       maxlength="10"
       inputmode="numeric"
       title="رقم الجوال يجب أن يبدأ بـ 0 ويحتوي على 10 أرقام"
       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
       placeholder="0501234567">
<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_whatsapp" value="1" class="form-checkbox text-green-500">
        <span class="ml-2 text-sm text-gray-700">رقم الجوال عليه واتساب</span>
    </label>
</div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ __('messages.email') }}
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="البريد الإلكتروني">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Secondary Phone -->
                            <div class="space-y-2 md:col-span-2" x-data="{ showExtra: {{ old('phone_secondary') ? 'true' : 'false' }} }">
                                <template x-if="showExtra">
                                    <div class="space-y-2">
                                        <label for="secondary_phone"
                                            class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ __('messages.secondary_phone') }}
                                        </label>
                                        <input type="text" name="secondary_phone" id="phone_secondary"
                                            value="{{ old('phone_secondary') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                            placeholder="رقم إضافي">
                                    </div>
                                </template>

                                <button type="button" @click="showExtra = true" x-show="!showExtra"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('messages.add_another_phone') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <span class="text-yellow-600 text-sm font-bold">3</span>
                            </div>
                            المعلومات المالية
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Debt -->
                            <div class="space-y-2">
                                <label for="debt"
                                    class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    {{ __('messages.debt') }}
                                </label>
                                <div class="relative">
                                    <input type="number" name="debt" id="debt" step="0.01" min="0"
                                        value="{{ old('debt', 0) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 pr-12"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm">ر.س</span>
                                    </div>
                                </div>
                                @error('debt')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 text-sm font-bold">4</span>
                            </div>
                            معلومات إضافية
                        </h3>

                        <!-- Notes -->
                        <div class="space-y-2">
                            <label for="notes"
                                class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                {{ __('messages.notes') }}
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 resize-none"
                                placeholder="أضف أي ملاحظات إضافية هنا...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="bg-gray-50 px-6 py-4 sm:px-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <a href="{{ route('admin.tenants.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 order-2 sm:order-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl order-1 sm:order-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/css/intlTelInput.css" />
    <style>
        /* International Tel Input Styles */
        .iti {
            width: 100% !important;
        }

        .iti__flag-container {
            padding: 0 12px;
        }

        .iti__selected-flag {
            padding: 0 12px 0 16px;
            border-radius: 0.5rem 0 0 0.5rem;
        }

        .iti__dropdown-content {
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* RTL/LTR Support for Phone Input */
        [dir="ltr"] .iti--allow-dropdown input {
            text-align: right !important;
            padding-right: 70px !important;
            padding-left: 16px !important;
            border-radius: 0 0.5rem 0.5rem 0 !important;
        }

        [dir="rtl"] .iti--allow-dropdown input {
            text-align: left !important;
            padding-left: 70px !important;
            padding-right: 16px !important;
            border-radius: 0.5rem 0 0 0.5rem !important;
        }

        [dir="rtl"] .iti__selected-flag {
            border-radius: 0 0.5rem 0.5rem 0;
        }

        /* Focus states */
        .iti.iti--allow-dropdown input:focus {
            border-color: #3b82f6 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
        }

        /* Custom scrollbar for better UX */
        .iti__dropdown-content {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .iti__dropdown-content::-webkit-scrollbar {
            width: 6px;
        }

        .iti__dropdown-content::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .iti__dropdown-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        /* Animation for smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Custom gradient backgrounds */
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        /* Form validation styles */
        input:invalid:not(:focus):not(:placeholder-shown),
        select:invalid:not(:focus),
        textarea:invalid:not(:focus):not(:placeholder-shown) {
            border-color: #ef4444;
            box-shadow: 0 0 0 1px #ef4444;
        }

        input:valid:not(:focus):not(:placeholder-shown),
        select:valid:not(:focus),
        textarea:valid:not(:focus):not(:placeholder-shown) {
            border-color: #10b981;
        }

        /* Loading state for submit button */
        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Mobile responsiveness improvements */
        @media (max-width: 640px) {
            .iti__selected-flag {
                padding: 0 8px 0 12px;
            }

            [dir="ltr"] .iti--allow-dropdown input {
                padding-right: 60px !important;
                padding-left: 12px !important;
            }

            [dir="rtl"] .iti--allow-dropdown input {
                padding-left: 60px !important;
                padding-right: 12px !important;
            }
        }
    </style>
@endpush

{{-- Alpine.js for interactive components --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize International Tel Input
            const phoneInput = document.querySelector("#phone");
            let iti;

            if (phoneInput) {
                iti = window.intlTelInput(phoneInput, {
                    initialCountry: "auto",
                    geoIpLookup: function(callback) {
                        fetch('https://ipapi.co/json/')
                            .then(res => res.json())
                            .then(data => callback(data.country_code))
                            .catch(() => callback("ae"));
                    },
                    preferredCountries: ["ae", "sa", "eg", "kw", "qa", "bh", "om"],
                    separateDialCode: true,
                    hiddenInput: "full_phone",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/utils.js"
                });

                // Real-time validation for phone number
                phoneInput.addEventListener('input', function() {
                    if (iti.isValidNumber()) {
                        phoneInput.classList.remove('border-red-500');
                        phoneInput.classList.add('border-green-500');
                    } else if (phoneInput.value.length > 0) {
                        phoneInput.classList.remove('border-green-500');
                        phoneInput.classList.add('border-red-500');
                    } else {
                        phoneInput.classList.remove('border-red-500', 'border-green-500');
                    }
                });
            }

            // Form validation and submission
            const form = phoneInput ? phoneInput.closest('form') : document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Show loading state
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;

                    // Handle phone number formatting
                    if (phoneInput && phoneInput.value && iti) {
                        if (iti.isValidNumber()) {
                            phoneInput.value = iti.getNumber();
                        } else {
                            e.preventDefault();
                            submitBtn.classList.remove('btn-loading');
                            submitBtn.disabled = false;

                            // Show error message
                            showNotification('يرجى إدخال رقم هاتف صحيح', 'error');
                            phoneInput.focus();
                            return;
                        }
                    }

                    // Basic form validation
                    const requiredFields = form.querySelectorAll('[required]');
                    let hasErrors = false;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.classList.add('border-red-500');
                            hasErrors = true;
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    if (hasErrors) {
                        e.preventDefault();
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                        showNotification('يرجى ملء جميع الحقول المطلوبة', 'error');

                        // Focus on first error field
                        const firstError = form.querySelector('.border-red-500');
                        if (firstError) {
                            firstError.focus();
                        }
                    }
                });
            }

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
                field.classList.remove('border-red-500', 'border-green-500');

                if (isRequired && !value) {
                    field.classList.add('border-red-500');
                    return false;
                }

                // Email validation
                if (field.type === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.classList.add('border-red-500');
                        return false;
                    }
                }

                // ID number validation (assuming Saudi ID format)
                if (field.name === 'id_number' && value) {
                    const idRegex = /^[0-9]{15}$/;
                    if (!idRegex.test(value)) {
                        field.classList.add('border-red-500');
                        return false;
                    }
                }

                // If validation passes and field has value
                if (value) {
                    field.classList.add('border-green-500');
                }

                return true;
            }

            // Auto-format ID number input
            const idInput = document.querySelector('#id_number');
            if (idInput) {
                idInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    let value = e.target.value.replace(/\D/g, '');

                    // Limit to 10 digits
                    if (value.length > 15) {
                        value = value.substring(0, 15);
                    }

                    e.target.value = value;
                });
            }

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

            // Smooth scrolling to form sections
            const sectionTitles = document.querySelectorAll('h3');
            sectionTitles.forEach(title => {
                title.style.cursor = 'pointer';
                title.addEventListener('click', function() {
                    this.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // Auto-save to localStorage (if needed for draft functionality)
            let autoSaveTimeout;
            const formData = {};

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(() => {
                        saveFormData();
                    }, 1000);
                });
            });

            function saveFormData() {
                const formElements = form.querySelectorAll('input, select, textarea');
                const data = {};

                formElements.forEach(element => {
                    if (element.name && element.value) {
                        data[element.name] = element.value;
                    }
                });

                // Note: localStorage is not supported in Claude artifacts
                // This would work in a real application
                // localStorage.setItem('tenant_form_draft', JSON.stringify(data));
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

            // Add loading animation to form
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Animate form sections on scroll
            const sections = document.querySelectorAll('form > div > div');
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });
        });
    </script>
