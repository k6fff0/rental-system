@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">تعديل العقد</h1>

    <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        {{-- المستأجر --}}
        <div class="mb-4">
            <label for="tenant_id" class="block text-sm font-medium text-gray-700">المستأجر</label>
            <select name="tenant_id" id="tenant_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ $contract->tenant_id == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الوحدة --}}
        <div class="mb-4">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">الوحدة</label>
            <select name="unit_id" id="unit_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ $contract->unit_id == $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_number }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- تاريخ البداية --}}
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">تاريخ البداية</label>
            <input type="date" name="start_date" id="start_date" value="{{ $contract->start_date }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- تاريخ النهاية --}}
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">تاريخ النهاية</label>
            <input type="date" name="end_date" id="end_date" value="{{ $contract->end_date }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- قيمة الإيجار --}}
        <div class="mb-4">
            <label for="rent_amount" class="block text-sm font-medium text-gray-700">قيمة الإيجار</label>
            <input type="number" name="rent_amount" id="rent_amount" value="{{ $contract->rent_amount }}" required step="0.01"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">ملاحظات</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ $contract->notes }}</textarea>
        </div>

        {{-- عرض الملف الحالي إن وُجد --}}
        @if ($contract->contract_file)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">العقد الحالي:</label>
                <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                   class="text-blue-600 hover:underline text-sm">عرض العقد</a>
            </div>
        @endif

        {{-- رفع ملف جديد --}}
        <div class="mb-4">
            <label for="contract_file" class="block text-sm font-medium text-gray-700">تحديث ملف العقد</label>
            <input type="file" name="contract_file" id="contract_file"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end">
            <a href="{{ route('contracts.index') }}"
               class="mr-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                رجوع
            </a>
            <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                تحديث
            </button>
        </div>
    </form>
</div>
@endsection
