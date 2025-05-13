@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_tenant') }}</h1>

    <form action="{{ route('admin.tenants.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        {{-- الاسم --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الحالة --}}
<div class="mb-4">
    <label for="tenant_status" class="block text-sm font-medium text-gray-700">{{ __('messages.tenant_status') }}</label>
    <select name="tenant_status" id="tenant_status" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        <option value="active" {{ old('tenant_status') == 'active' ? 'selected' : '' }}>{{ __('messages.tenant_status_active') }}</option>
        <option value="late_payer" {{ old('tenant_status') == 'late_payer' ? 'selected' : '' }}>{{ __('messages.tenant_status_late_payer') }}</option>
        <option value="has_debt" {{ old('tenant_status') == 'has_debt' ? 'selected' : '' }}>{{ __('messages.tenant_status_has_debt') }}</option>
        <option value="absent" {{ old('tenant_status') == 'absent' ? 'selected' : '' }}>{{ __('messages.tenant_status_absent') }}</option>
        <option value="abroad" {{ old('tenant_status') == 'abroad' ? 'selected' : '' }}>{{ __('messages.tenant_status_abroad') }}</option>
        <option value="legal_issue" {{ old('tenant_status') == 'legal_issue' ? 'selected' : '' }}>{{ __('messages.tenant_status_legal_issue') }}</option>
    </select>
</div>


        {{-- المبنى --}}
        <div class="mb-4">
            <label for="building_id" class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
            <select name="building_id" id="building_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.select_building') }}</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الوحدة --}}
        <div class="mb-4" id="unit_container">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" id="unit_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.select_unit') }}</option>
            </select>
        </div>

        {{-- باقي الحقول --}}
        <div class="mb-4">
            <label for="id_number" class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }}</label>
            <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone') }}</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="debt" class="block text-sm font-medium text-gray-700">{{ __('messages.debt') }}</label>
            <input type="number" name="debt" id="debt" step="0.01" min="0" value="{{ old('debt', 0) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.tenants.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
            <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.save') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateUnits(buildingId) {
        const unitSelect = document.getElementById('unit_id');
        unitSelect.innerHTML = `<option value="">@js(__('messages.select_unit'))</option>`;
        console.log('🔄 Fetching units for building:', buildingId);

        fetch(`{{ url('/api/units-by-building') }}/${buildingId}`)
            .then(res => res.json())
            .then(data => {
                console.log('✅ Available units:', data);
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.id;
                    option.textContent = unit.unit_number;
                    unitSelect.appendChild(option);
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const buildingSelect = document.getElementById('building_id');
        buildingSelect.addEventListener('change', function () {
            updateUnits(this.value);
        });

        const initialBuildingId = buildingSelect.value;
        if (initialBuildingId) {
            updateUnits(initialBuildingId);
        }
    });
</script>
@endpush
@endsection
