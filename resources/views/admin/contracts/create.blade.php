@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🧾 العنوان --}}
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

        {{-- 🖨️ الطباعة / التصدير --}}
        <div class="flex gap-3 w-full md:w-auto">
            <button type="button" onclick="window.print()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                {{ __('messages.print') }}
            </button>
            <button type="button" id="exportPdf" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                {{ __('messages.export_pdf') }}
            </button>
        </div>
    </div>

    {{-- 📄 نموذج العقد --}}
    <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data" id="contractForm"
          class="bg-white shadow rounded-lg p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- المستأجر --}}
            <div>
                <label for="tenant_id" class="block text-sm font-medium text-gray-700">{{ __('messages.tenant') }}</label>
                <select name="tenant_id" id="tenant_id" required
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="">{{ __('messages.choose_tenant') }}</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- المبنى --}}
            <div>
                <label for="building_id" class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
                <select name="building_id" id="building_id" required
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="">{{ __('messages.choose_building') }}</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- الوحدة --}}
            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
                <select name="unit_id" id="unit_id" required
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="">{{ __('messages.choose_unit') }}</option>
                </select>
            </div>
            {{-- مبلغ الإيجار --}}
            <div>
                <label for="rent_amount" class="block text-sm font-medium text-gray-700">{{ __('messages.rent_amount') }}</label>
                <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}" step="0.01" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            {{-- التاريخ من وإلى --}}
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            {{-- ملف العقد --}}
            <div>
                <label for="contract_file" class="block text-sm font-medium text-gray-700">{{ __('messages.contract_file') }}</label>
                <input type="file" name="contract_file" id="contract_file"
                       class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            {{-- الملاحظات --}}
            <div class="md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- 🧾 المعاينة --}}
        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-semibold mb-3">{{ __('messages.contract_preview') }}</h3>
            <div id="contractPreview" class="bg-gray-50 border border-gray-200 rounded p-4 text-sm text-gray-700">
                {{ __('messages.fill_form_to_preview') }}
            </div>
        </div>

        {{-- الأزرار --}}
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.contracts.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded text-sm font-medium">
                {{ __('messages.back') }}
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">
                {{ __('messages.save_contract') }}
            </button>
        </div>
    </form>
</div>

<script>
    const chooseUnitText = "{{ __('messages.choose_unit') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const buildingSelect = document.getElementById('building_id');
        const unitSelect = document.getElementById('unit_id');
        const tenantSelect = document.getElementById('tenant_id');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const rentAmount = document.getElementById('rent_amount');

        // ✅ جلب الوحدات عند اختيار المبنى
        buildingSelect.addEventListener('change', function () {
            const buildingId = this.value;
            unitSelect.innerHTML = `<option value="">${chooseUnitText}</option>`;
            
            if (buildingId) {
                fetch(`/admin/api/units-by-building/${buildingId}`)
                    .then(response => response.json())
                    .then(units => {
                        units.forEach(unit => {
                            const option = document.createElement('option');
                            option.value = unit.id;
                            option.textContent = unit.unit_number;
                            unitSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching units:', error));
            }
        });

        // ✅ جلب بيانات المستأجر عند اختياره
        tenantSelect.addEventListener('change', function () {
            const tenantId = this.value;
            if (!tenantId) return;

            fetch(`/admin/api/tenant/${tenantId}`)
                .then(response => response.json())
                .then(data => {
                    updateContractPreview(data); // بترجع البيانات للمعاينة
                });
        });

        // ✅ تحديث المعاينة عند تغيير أي بيانات
        [unitSelect, startDate, endDate, rentAmount].forEach(el => {
            el.addEventListener('input', () => updateContractPreview());
        });

        // ✅ تحديث المعاينة تلقائياً
        function updateContractPreview(tenant = {}) {
            const tenantName = tenant.name || tenantSelect.options[tenantSelect.selectedIndex]?.text || '________';
            const idNumber = tenant.id_number || '________';
            const phone = tenant.phone || '________';
            const email = tenant.email || '________';
            const unitNumber = unitSelect.options[unitSelect.selectedIndex]?.text || '________';
            const start = startDate.value || '________';
            const end = endDate.value || '________';
            const rent = rentAmount.value ? `${rentAmount.value} {{ __('messages.currency') }}` : '________';

            document.getElementById('contractPreview').innerHTML = `
                <div class="space-y-4 text-sm">
                    <h2 class="text-base font-bold text-gray-800 mb-2">{{ __('messages.contract_summary') }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <strong>{{ __('messages.tenant') }}:</strong> ${tenantName}<br>
                            <strong>{{ __('messages.id_number') }}:</strong> ${idNumber}<br>
                            <strong>{{ __('messages.phone') }}:</strong> ${phone}<br>
                            <strong>{{ __('messages.email') }}:</strong> ${email}<br>
                        </div>
                        <div>
                            <strong>{{ __('messages.unit') }}:</strong> ${unitNumber}<br>
                            <strong>{{ __('messages.start_date') }}:</strong> ${start}<br>
                            <strong>{{ __('messages.end_date') }}:</strong> ${end}<br>
                            <strong>{{ __('messages.rent_amount') }}:</strong> ${rent}<br>
                        </div>
                    </div>
                </div>
            `;
        }
    });
</script>

@endsection
