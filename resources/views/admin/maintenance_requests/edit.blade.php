@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300"
        dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            {{-- Header Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <!-- Back Button -->
                    <a href="{{ route('admin.maintenance_requests.index') }}" 
                        class="inline-flex items-center p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>

                    <!-- Icon -->
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.edit_maintenance_request') }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">تعديل طلب الصيانة #{{ $maintenance->id }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Container --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <form action="{{ route('admin.maintenance_requests.update', $maintenance->id) }}" method="POST"
                    enctype="multipart/form-data" id="maintenanceForm">
                    @csrf
                    @method('PUT')

                    {{-- Form Header --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            تفاصيل الطلب
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Request Information (Read Only) --}}
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                            <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                معلومات الطلب الأساسية
                            </h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Building -->
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wider">
                                        {{ __('messages.building') }}
                                    </label>
                                    <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-600">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $maintenance->building->name ?? '-' }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="building_id" value="{{ $maintenance->building_id }}">
                                </div>

                                <!-- Unit -->
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wider">
                                        {{ __('messages.unit') }}
                                    </label>
                                    <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-600">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $maintenance->unit->unit_number ?? '-' }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="unit_id" value="{{ $maintenance->unit_id }}">
                                </div>

                                <!-- Category -->
                                <div class="space-y-2 sm:col-span-2">
                                    <label class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wider">
                                        {{ __('messages.sub_specialty') }}
                                    </label>
                                    <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-600">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $maintenance->subSpecialty->parent->name ?? '---' }} → {{ $maintenance->subSpecialty->name ?? '-' }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="sub_specialty_id" value="{{ $maintenance->sub_specialty_id }}">
                                </div>

                                <!-- Created By -->
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wider">
                                        {{ __('messages.created_by') }}
                                    </label>
                                    <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-600">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $maintenance->creator->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Created Date -->
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wider">
                                        تاريخ الإنشاء
                                    </label>
                                    <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-600">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $maintenance->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Editable Fields --}}
                        <div class="space-y-6">
                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ __('messages.description') }}
                                </label>
                                <textarea name="description" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none"
                                    placeholder="اكتب وصف مفصل للمشكلة...">{{ $maintenance->description }}</textarea>
                            </div>

                            <!-- Technician Assignment -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('messages.technician') }}
                                </label>
                                <div class="relative">
                                    <select name="technician_id" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none">
                                        <option value="">{{ __('messages.select_technician') }}</option>
                                        @foreach ($technicians as $technician)
                                            <option value="{{ $technician->id }}"
                                                {{ $maintenance->assigned_worker_id == $technician->id ? 'selected' : '' }}>
                                                {{ $technician->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ __('messages.status') }}
                                </label>
                                <div class="relative">
                                    <select name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none">
                                        @foreach (['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                                            <option value="{{ $status }}" {{ $maintenance->status == $status ? 'selected' : '' }}>
                                                {{ __('messages.status_' . $status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    {{ __('messages.cost') }}
                                </label>
                                <div class="relative">
                                    <input type="number" name="cost" step="0.01" value="{{ $maintenance->cost }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">AED</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="space-y-3">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('messages.image') }}
                                </label>

                                @if ($maintenance->image)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">الصورة الحالية:</p>
                                        <div class="flex justify-center">
                                            <img src="{{ asset('storage/' . $maintenance->image) }}" 
                                                class="max-h-48 w-auto rounded-lg shadow-md border border-gray-200 dark:border-gray-600" 
                                                alt="Current Image">
                                        </div>
                                    </div>
                                @endif

                                <div class="relative">
                                    <input type="file" name="image" accept="image/*" id="imageInput"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="flex items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-200 bg-gray-50 dark:bg-gray-700">
                                        <div class="text-center">
                                            <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-blue-600 dark:text-blue-400">انقر لتحديد صورة</span>
                                                أو اسحب الصورة هنا
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG حتى 10MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                آخر تحديث: {{ $maintenance->updated_at->diffForHumans() }}
                            </div>

                            <div class="flex items-center space-x-3 rtl:space-x-reverse w-full sm:w-auto">
                                <a href="{{ route('admin.maintenance_requests.index') }}"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded-xl transition-colors duration-200 font-medium">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    إلغاء
                                </a>

                                <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 font-medium">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    {{ __('messages.save_changes') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image upload preview
            const imageInput = document.getElementById('imageInput');
            
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create preview if needed
                        console.log('File selected:', file.name);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form validation
            const form = document.getElementById('maintenanceForm');
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                
                // Add loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin w-4 h-4 mr-2 rtl:ml-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    جاري الحفظ...
                `;
            });

            // Auto-resize textarea
            const textarea = document.querySelector('textarea[name="description"]');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            }
        });
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            input, select, textarea {
                font-size: 16px !important; /* Prevents zoom on iOS */
            }

            .min-h-44 {
                min-height: 44px; /* Apple's recommended touch target size */
            }
        }

        /* Form focus styles */
        .focus\:ring-2:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
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

        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
        }

        [dir="rtl"] .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Enhanced shadows for dark mode */
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }

        /* Drag and drop styles */
        .drag-over {
            border-color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        /* Transition improvements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Button hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        /* File input styling */
        input[type="file"] {
            cursor: pointer;
        }

        /* Loading state styling */
        .loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* Error states */
        .error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
        }

        /* Success states */
        .success {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
        }

        /* Responsive text sizing */
        @media (max-width: 768px) {
            .text-xl {
                font-size: 1.125rem;
            }
            
            .text-2xl {
                font-size: 1.25rem;
            }
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background: white !important;
            }
        }
    </style>
@endsection