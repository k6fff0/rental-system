@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_contract') }}</h1>

    <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6">
        @csrf

        {{-- المستأجر --}}
        <div class="mb-4">
            <label for="tenant_id" class="block text-sm font-medium text-gray-700">{{ __('messages.tenant') }}</label>
            <select name="tenant_id" id="tenant_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.choose_tenant') }}</option>
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>
            @error('tenant_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- الوحدة --}}
        <div class="mb-4">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" id="unit_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.choose_unit') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_number }}
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- تاريخ البداية --}}
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('messages.start_date') }}</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('start_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- تاريخ النهاية --}}
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('messages.end_date') }}</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('end_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- قيمة الإيجار --}}
        <div class="mb-4">
            <label for="rent_amount" class="block text-sm font-medium text-gray-700">{{ __('messages.rent_amount') }}</label>
            <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}" required step="0.01"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('rent_amount')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
        </div>

        {{-- رفع ملف العقد --}}
        <div class="mb-4">
            <label for="contract_file" class="block text-sm font-medium text-gray-700">{{ __('messages.contract_file') }}</label>
            <input type="file" name="contract_file" id="contract_file"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('contract_file')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.contracts.index') }}"
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
@endsection
