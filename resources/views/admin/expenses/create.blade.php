@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8" 
     dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    
    <!-- Container الرئيسي -->
    <div class="max-w-5xl mx-auto">
        
        <!-- Header Section -->
        <div class="relative mb-8">
            <!-- خلفية ديكورية -->
            <div class="absolute inset-0 bg-gradient-to-r from-red-100 to-red-100 rounded-2xl shadow-xl transform rotate-1"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-red-100 to-red-100 rounded-2xl shadow-x-1 transform -rotate-1"></div>
            
            <!-- المحتوى -->
            <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-8 border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                        <!-- أيقونة -->
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-red-200 to-red-300 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                {{ __('messages.add_expense') }}
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">{{ __('messages.fill_expense_details') }}</p>
                        </div>
                    </div>
                    
                    <!-- زر العودة -->
                    <a href="{{ route('admin.expenses.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-200 group text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2 rotate-180' : 'mr-2' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('messages.back_to_expenses') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-red-50 to-red-50 px-6 sm:px-8 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}"></div>
                    {{ __('messages.expense_information') }}
                </h2>
            </div>

            <!-- Form Content -->
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- الحقول الأساسية -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <!-- نوع المصروف -->
                        <div class="group">
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.type') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="type" id="type" required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white appearance-none">
                                    <option value="furniture"> {{ __('messages.furniture') }}</option>
                                    <option value="painting"> {{ __('messages.painting') }}</option>
                                    <option value="plumbing"> {{ __('messages.plumbing') }}</option>
                                    <option value="electronics"> {{ __('messages.electronics') }}</option>
                                    <option value="other"> {{ __('messages.other') }}</option>
                                </select>
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- المبنى -->
                        <div class="group">
                            <label for="building_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.building') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="building_id" id="building_id" required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white appearance-none">
                                    @foreach ($buildings as $building)
                                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- الوحدة -->
                        <div class="group">
                            <label for="unit_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.unit') }}
                            </label>
                            <div class="relative">
                                <select name="unit_id" id="unit_id"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white appearance-none">
                                    <option value="">{{ __('messages.select_unit_optional') }}</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_number }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- المبلغ -->
                        <div class="group">
                            <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.amount') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-lg">💰</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" required
                                       class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white"
                                       placeholder="0.00">
                            </div>
                        </div>

                        <!-- التاريخ -->
                        <div class="group">
                            <label for="expense_date" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.date') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-lg"></span>
                                </div>
                                <input type="date" name="expense_date" id="expense_date" required
                                       class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white">
                            </div>
                        </div>

                        <!-- صورة الفاتورة -->
                        <div class="group">
                            <label for="invoice_image" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <span class="w-2 h-2 bg-green-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.invoice_image') }}
                            </label>
                            <div class="relative">
                                <input type="file" name="invoice_image" id="invoice_image" accept="image/*"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 group-hover:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 flex items-center">
                            <span class="w-2 h-2 bg-blue-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                            {{ __('messages.description') }}
                        </label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="4"
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:bg-white resize-none"
                                      placeholder="{{ __('messages.add_description_optional') }}"></textarea>
                            <div class="absolute top-3 {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} pointer-events-none">
                                <span class="text-gray-400 text-lg"></span>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-1 h-1 bg-red-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('messages.required_fields') }}
                            </div>
                            
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 {{ app()->getLocale() == 'ar' ? 'sm:space-x-reverse' : '' }}">
                                <button type="submit"
                                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center group transform hover:scale-105">
                                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('messages.save') }}
                                </button>							
                                <button type="button" onclick="window.history.back()"
                                        class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-200 flex items-center justify-center group">
                                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ __('messages.cancel') }}
                                </button>                              
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                {{ __('messages.expense_form_footer') }}
            </p>
        </div>
    </div>
</div>

<style>
/* تحسينات إضافية للتصميم */
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
    }
}

/* تأثيرات الحركة */
.group:hover .w-2 {
    transform: scale(1.5);
    transition: transform 0.2s ease-in-out;
}

/* تحسين مظهر حقول الإدخال */
input:focus, select:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* تأثير التحويم على البطاقات */
.bg-white:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease-in-out;
}

/* تحسين شكل زر رفع الملف */
input[type="file"]::-webkit-file-upload-button {
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 8px 16px;
    margin-right: 16px;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

input[type="file"]::-webkit-file-upload-button:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-1px);
}

/* تحسينات للاتجاه العربي */
[dir="rtl"] input[type="file"]::-webkit-file-upload-button {
    margin-right: 0;
    margin-left: 16px;
}
</style>
@endsection