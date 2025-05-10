@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_contract') }}</h1>

    <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        {{-- المستأجر --}}
        <div class="mb-4">
            <label for="tenant_id" class="block text-sm font-medium text-gray-700">{{ __('messages.tenant') }}</label>
            <select name="tenant_id" id="tenant_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ $contract->tenant_id == $tenant->id ? 'selected' : '' }}>
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
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ $contract->unit_id == $unit->id ? 'selected' : '' }}>
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
            <input type="date" name="start_date" id="start_date" value="{{ $contract->start_date }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('start_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- تاريخ النهاية --}}
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('messages.end_date') }}</label>
            <input type="date" name="end_date" id="end_date" value="{{ $contract->end_date }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('end_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- قيمة الإيجار --}}
        <div class="mb-4">
            <label for="rent_amount" class="block text-sm font-medium text-gray-700">{{ __('messages.rent_amount') }}</label>
            <input type="number" name="rent_amount" id="rent_amount" value="{{ $contract->rent_amount }}" required step="0.01"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('rent_amount')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ $contract->notes }}</textarea>
        </div>

        {{-- عرض الملف الحالي إن وُجد --}}
        @if ($contract->contract_file)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.existing_contract_file') }}</label>
                <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                   class="text-blue-600 hover:underline text-sm">{{ __('messages.view_contract') }}</a>
            </div>
        @endif

        {{-- رفع ملف جديد --}}
        <div class="mb-4">
            <label for="contract_file" class="block text-sm font-medium text-gray-700">{{ __('messages.upload_new_contract') }}</label>
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
                {{ __('messages.update') }}
            </button>
        </div>
    </form>
</div>
@endsection
