@extends('layouts.app')

@section('content')
<div x-data="unitPopup()" class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_tenant') }}</h1>

    <form id="tenantForm" action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        {{-- الاسم --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

 {{-- الحالة --}}
<div class="mb-4">
    <label for="tenant_status" class="block text-sm font-medium text-gray-700">{{ __('messages.tenant_status') }}</label>
    <select name="tenant_status" id="tenant_status" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        <option value="active" {{ old('tenant_status', $tenant->tenant_status) == 'active' ? 'selected' : '' }}>{{ __('messages.tenant_status_active') }}</option>
        <option value="late_payer" {{ old('tenant_status', $tenant->tenant_status) == 'late_payer' ? 'selected' : '' }}>{{ __('messages.tenant_status_late_payer') }}</option>
        <option value="has_debt" {{ old('tenant_status', $tenant->tenant_status) == 'has_debt' ? 'selected' : '' }}>{{ __('messages.tenant_status_has_debt') }}</option>
        <option value="absent" {{ old('tenant_status', $tenant->tenant_status) == 'absent' ? 'selected' : '' }}>{{ __('messages.tenant_status_absent') }}</option>
        <option value="abroad" {{ old('tenant_status', $tenant->tenant_status) == 'abroad' ? 'selected' : '' }}>{{ __('messages.tenant_status_abroad') }}</option>
        <option value="legal_issue" {{ old('tenant_status', $tenant->tenant_status) == 'legal_issue' ? 'selected' : '' }}>{{ __('messages.tenant_status_legal_issue') }}</option>
    </select>
</div>


        {{-- المبنى --}}
        <div class="mb-4">
            <label for="building_id" class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
            <select name="building_id" id="building_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.select_building') }}</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}"
                        {{ old('building_id', optional($tenant->unit)->building_id) == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الوحدة --}}
        <div class="mb-4" id="unit_container">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" id="unit_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" disabled>
                <option value="{{ $tenant->unit_id }}" selected>
                    {{ optional($tenant->unit)->unit_number ?? __('messages.unit') }}
                </option>
            </select>
            <p class="text-xs text-gray-500 mt-1">{{ __('messages.unit_locked') }}</p>
        </div>

        {{-- المديونية --}}
        <div class="mb-4">
            <label for="debt" class="block text-sm font-medium text-gray-700">{{ __('messages.debt') }}</label>
            <input type="number" name="debt" id="debt" min="0" step="0.01" value="{{ old('debt', $tenant->debt) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- رقم الهوية --}}
        <div class="mb-4">
            <label for="id_number" class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }}</label>
            <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $tenant->id_number) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الجوال --}}
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone') }}</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $tenant->phone) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الإيميل --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes', $tenant->notes) }}</textarea>
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.tenants.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
            <button type="button"
                    class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold"
                    @click="open = true">
                + {{ __('messages.add_unit') }}
            </button>
            <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.update') }}
            </button>
        </div>
    </form>

    {{-- ✅ Popup Modal --}}
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">{{ __('messages.add_unit') }}</h2>

            {{-- اختيار المبنى --}}
            <label class="block text-sm font-medium mb-1">{{ __('messages.building') }}</label>
            <select x-model="buildingId" @change="fetchUnits" class="mb-4 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.select_building') }}</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                @endforeach
            </select>

            {{-- اختيار الوحدة --}}
            <label class="block text-sm font-medium mb-1">{{ __('messages.unit') }}</label>
            <select x-model="selectedUnit" class="mb-4 w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <template x-for="unit in units" :key="unit.id">
                    <option :value="unit.id" x-text="unit.unit_number"></option>
                </template>
            </select>

            {{-- الأزرار --}}
            <div class="flex justify-end gap-2">
                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded">{{ __('messages.cancel') }}</button>
                <button type="button" @click="addUnit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ __('messages.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function unitPopup() {
        return {
            open: false,
            buildingId: '',
            selectedUnit: '',
            units: [],
            fetchUnits() {
                if (!this.buildingId) return;
                fetch(`/api/units-by-building/${this.buildingId}?tenant_id={{ $tenant->id }}`)
                    .then(res => res.json())
                    .then(data => this.units = data);
            },
            addUnit() {
                if (!this.selectedUnit) return;

                const selected = this.units.find(u => u.id == this.selectedUnit);
                const badge = document.createElement('div');
                badge.className = 'inline-block ml-2 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded';
                badge.textContent = `+ ${selected.unit_number}`;
                document.getElementById('unit_container').appendChild(badge);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'additional_units[]';
                input.value = selected.id;
                document.getElementById('tenantForm').appendChild(input);

                this.open = false;
            }
        }
    }
</script>
@endpush
