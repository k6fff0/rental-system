@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('messages.add_contract') }}
            </h1>
            <p class="text-sm text-gray-500">{{ __('messages.fill_contract_details') }}</p>
        </div>

        <div class="flex gap-3 w-full md:w-auto">
            <button type="button" onclick="window.print()" 
                    class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-sm font-medium w-full md:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                {{ __('messages.print') }}
            </button>
            <button type="button" id="exportPdf" 
                    class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-sm font-medium w-full md:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                {{ __('messages.export_pdf') }}
            </button>
        </div>
    </div>

    <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 mb-6" id="contractForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- المستأجر --}}
            <div class="mb-4">
                <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.tenant') }}</label>
                <select name="tenant_id" id="tenant_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">{{ __('messages.choose_tenant') }}</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->name }}
                        </option>
                    @endforeach
                </select>
                @error('tenant_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- الوحدة --}}
            <div class="mb-4">
                <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.unit') }}</label>
                <select name="unit_id" id="unit_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">{{ __('messages.choose_unit') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit_number }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- تاريخ البداية --}}
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- تاريخ النهاية --}}
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- قيمة الإيجار --}}
            <div class="mb-4">
                <label for="rent_amount" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.rent_amount') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} flex items-center pl-3 pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">{{ __('messages.currency') }}</span>
                    </div>
                    <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}" required step="0.01"
                           class="block w-full pr-12 sm:text-sm border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 border pl-10">
                </div>
                @error('rent_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- رفع ملف العقد --}}
            <div class="mb-4 md:col-span-2">
                <label for="contract_file" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.contract_file') }}</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="contract_file" id="contract_file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                @error('contract_file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- ملاحظات --}}
            <div class="mb-4 md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.notes') }}</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- معاينة العقد --}}
        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.contract_preview') }}</h3>
            <div id="contractPreview" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="text-center text-gray-500">{{ __('messages.fill_form_to_preview') }}</div>
            </div>
        </div>

        {{-- الأزرار --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">
            <a href="{{ route('admin.contracts.index') }}"
               class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('messages.back') }}
            </a>
            <button type="submit"
                    class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('messages.save_contract') }}
            </button>
        </div>
    </form>
</div>

<script>
    // تحديث معاينة العقد عند تغيير المدخلات
    document.getElementById('contractForm').addEventListener('input', function() {
        updateContractPreview();
    });

    function updateContractPreview() {
        const tenantSelect = document.getElementById('tenant_id');
        const unitSelect = document.getElementById('unit_id');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const rentAmount = document.getElementById('rent_amount');
        
        const tenantName = tenantSelect.options[tenantSelect.selectedIndex]?.text || '________';
        const unitNumber = unitSelect.options[unitSelect.selectedIndex]?.text || '________';
        const start = startDate.value || '________';
        const end = endDate.value || '________';
        const rent = rentAmount.value ? `${rentAmount.value} {{ __('messages.currency') }}` : '________';

        const previewHTML = `
            <div class="space-y-4">
                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium">{{ __('messages.tenant') }}:</span>
                    <span>${tenantName}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium">{{ __('messages.unit') }}:</span>
                    <span>${unitNumber}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium">{{ __('messages.duration') }}:</span>
                    <span>${start} - ${end}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium">{{ __('messages.rent_amount') }}:</span>
                    <span>${rent}</span>
                </div>
            </div>
        `;

        document.getElementById('contractPreview').innerHTML = previewHTML;
    }

    // تصدير إلى PDF (وظيفة أساسية بدون مكتبات)
    document.getElementById('exportPdf').addEventListener('click', function() {
        alert('{{ __("messages.pdf_export_alert") }}');
        // في الواقع، تحتاج إلى مكتبة لإنشاء PDF، لكننا نكتفي بتنبيه حسب طلبك بعدم استخدام مكتبات خارجية
    });

    // التحقق من التاريخ عند الإرسال
    document.getElementById('contractForm').addEventListener('submit', function(e) {
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);
        
        if (startDate >= endDate) {
            e.preventDefault();
            alert('{{ __("messages.end_date_after_start_date") }}');
        }
    });
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #contractForm, #contractForm * {
            visibility: visible;
        }
        #contractForm {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection