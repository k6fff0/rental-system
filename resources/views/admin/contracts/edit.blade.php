@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        {{-- 🔧 عنوان الصفحة مع زر الرجوع --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4"
            dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

            {{-- 📝 العنوان في اليمين --}}
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                <svg class="w-6 h-6 text-blue-600 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                {{ __('messages.edit_contract') }}
            </h1>

            {{-- 🔙 زر الرجوع في اليسار --}}
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition">

                {{-- 🔁 سهم الرجوع يتعكس حسب اللغة --}}
                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 rotate-180' }}" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>

                {{ __('messages.back') }}
            </a>

        </div>


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

            {{-- تاريخ البداية (ثابت) --}}
            <div class="mb-4">
                <label for="start_date"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.start_date') }}</label>
                <input type="date" id="start_date" value="{{ $contract->start_date->format('Y-m-d') }}" disabled
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm bg-gray-100 cursor-not-allowed">
                <input type="hidden" name="start_date" value="{{ $contract->start_date->format('Y-m-d') }}">
            </div>

            {{-- تاريخ النهاية --}}
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" value="{{ $contract->end_date->format('Y-m-d') }}"
                    required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @error('end_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- قيمة الإيجار --}}
            <div class="mb-4">
                <label for="rent_amount"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.rent_amount') }}</label>
                <input type="number" name="rent_amount" id="rent_amount" value="{{ $contract->rent_amount }}" required
                    step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
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
                    <label
                        class="block text-sm font-medium text-gray-700">{{ __('messages.existing_contract_file') }}</label>
                    <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                        class="text-blue-600 hover:underline text-sm">{{ __('messages.view_contract') }}</a>
                </div>
            @endif

            {{-- رفع ملف جديد --}}
            <div class="mb-4">
                <label for="contract_file"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.upload_new_contract') }}</label>
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
