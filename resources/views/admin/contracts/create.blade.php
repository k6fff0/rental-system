@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🌸 العنوان مع تأثيرات جميلة --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-500">
                    {{ __('messages.add_contract') }}
                </span>
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.fill_contract_details') }}</p>
        </div>
    </div>

    {{-- 🌺 نموذج العقد بتصميم أنيق --}}
    <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data" id="contractForm"
          class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
        @csrf

        {{-- 🌿 قسم البحث عن المستأجر --}}
        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <div class="mb-4">
                <label for="tenant_search" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('messages.tenant_search') }}
                    </span>
                </label>
                <div class="relative">
                    <input type="text" id="tenant_search" name="tenant_search" autocomplete="off"
                           placeholder="{{ __('messages.search_placeholder') }}"
                           class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border">
                    <input type="hidden" id="tenant_id" name="tenant_id">
                    <div id="tenant_results"
                         class="absolute z-10 bg-white border border-gray-200 w-full rounded-lg mt-1 hidden max-h-60 overflow-y-auto text-sm shadow-lg"></div>
                </div>
            </div>
        </div>

        {{-- 🌷 محتوى النموذج الرئيسي --}}
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- المبنى --}}
                <div class="space-y-1">
                    <label for="building_id" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.building') }}
                    </label>
                    <select name="building_id" id="building_id" required
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                        <option value="">{{ __('messages.choose_building') }}</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- الوحدة --}}
                <div class="space-y-1">
                    <label for="unit_id" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.unit') }}
                    </label>
                    <select name="unit_id" id="unit_id" required disabled
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border bg-gray-50">
                        <option value="">{{ __('messages.choose_unit') }}</option>
                    </select>
                </div>

                {{-- التاريخ من وإلى --}}
                <div class="space-y-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.start_date') }}
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border">
                </div>
                <div class="space-y-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.end_date') }}
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border">
                </div>
                {{-- مبلغ الإيجار --}}
                <div class="space-y-1">
                    <label for="rent_amount" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.rent_amount') }}
                    </label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}" step="0.01" required
                               class="block w-full pr-12 border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">{{ __('messages.currency') }}</span>
                        </div>
                    </div>
                </div>
                {{-- ملف العقد --}}
                <div class="space-y-1">
                    <label for="contract_file" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.contract_file') }}
                    </label>
                    <div class="mt-1 flex items-center">
                        <label for="contract_file" class="cursor-pointer w-full">
                            <div class="flex items-center justify-between bg-white border border-gray-300 rounded-lg shadow-sm px-4 py-2 hover:bg-gray-50">
                                <span class="text-sm text-gray-500 truncate">{{ __('messages.choose_file') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <input type="file" name="contract_file" id="contract_file" class="sr-only">
                        </label>
                    </div>
                </div>

                {{-- الملاحظات --}}
                <div class="md:col-span-2 space-y-1">
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.notes') }}
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- 🌼 قسم الشروط والأحكام --}}
            <div class="mt-8 space-y-1">
                <label for="terms" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.terms_and_conditions') }}
                </label>
                <textarea name="terms" id="terms" rows="5" required
                          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-4 border font-mono text-sm">{{ old('terms', settings()->default_contract_terms) }}</textarea>
            </div>

            {{-- 🍃 أزرار التنفيذ --}}
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.contracts.index') }}" 
                   class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('messages.back') }}
                </a>
                <button type="submit" 
                        class="flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    {{ __('messages.save_contract') }}
                </button>
            </div>
        </div>
    </form>
</div>

{{-- سكريبتات ذكية --}}
<script>
    // بحث المستأجر
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('tenant_search');
        const resultsBox = document.getElementById('tenant_results');
        const hiddenInput = document.getElementById('tenant_id');

        input.addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length < 1) {
                resultsBox.innerHTML = '';
                resultsBox.classList.add('hidden');
                return;
            }

            fetch(`/admin/api/tenants/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        resultsBox.innerHTML = '<div class="p-3 text-center text-gray-500 bg-gray-50">{{ __("messages.no_results") }}</div>';
                    } else {
                        resultsBox.innerHTML = data.map(tenant => `
                            <div class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 text-gray-700 flex items-center"
                                 data-id="${tenant.id}" data-label="${tenant.name} - ${tenant.phone}">
                                <div class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center me-2 flex-shrink-0">
                                    ${tenant.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="truncate">
                                    <div class="font-medium">${tenant.name}</div>
                                    <div class="text-xs text-gray-500">${tenant.phone} ${tenant.id_number ? ' - ' + tenant.id_number : ''}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                    resultsBox.classList.remove('hidden');
                });
        });

        resultsBox.addEventListener('click', function (e) {
            const selected = e.target.closest('[data-id]');
            if (selected) {
                input.value = selected.dataset.label;
                hiddenInput.value = selected.dataset.id;
                resultsBox.classList.add('hidden');
            }
        });

        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });
    });

    // تحميل الوحدات حسب المبنى المختار
    const buildingSelect = document.getElementById('building_id');
    const unitSelect = document.getElementById('unit_id');

    buildingSelect.addEventListener('change', function () {
        const buildingId = this.value;
        unitSelect.disabled = true;
        unitSelect.innerHTML = `<option>{{ app()->getLocale() === 'ar' ? 'جاري التحميل...' : 'Loading...' }}</option>`;

        if (!buildingId) {
            unitSelect.innerHTML = `<option value="">{{ app()->getLocale() === 'ar' ? 'اختر المبنى أولاً' : 'Choose building first' }}</option>`;
            return;
        }

        fetch(`/admin/api/buildings/${buildingId}/available-units`)
            .then(response => response.json())
            .then(units => {
                if (units.length === 0) {
                    unitSelect.innerHTML = `<option value="">{{ app()->getLocale() === 'ar' ? 'لا توجد وحدات متاحة' : 'No available units' }}</option>`;
                } else {
                    unitSelect.innerHTML = `<option value="">{{ app()->getLocale() === 'ar' ? 'اختر الوحدة' : 'Choose unit' }}</option>`;
                    units.forEach(unit => {
                        unitSelect.innerHTML += `<option value="${unit.id}">${unit.unit_number}</option>`;
                    });
                }
                unitSelect.disabled = false;
            });
    });
</script>
@endsection