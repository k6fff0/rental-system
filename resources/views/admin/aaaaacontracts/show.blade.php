@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">تفاصيل العقد</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        {{-- المستأجر --}}
        <div>
            <span class="font-semibold text-gray-700">المستأجر:</span>
            <span class="text-gray-900">{{ $contract->tenant->name ?? '-' }}</span>
        </div>

        {{-- الوحدة --}}
        <div>
            <span class="font-semibold text-gray-700">الوحدة:</span>
            <span class="text-gray-900">{{ $contract->unit->unit_number ?? '-' }}</span>
        </div>

        {{-- تاريخ البداية --}}
        <div>
            <span class="font-semibold text-gray-700">تاريخ البداية:</span>
            <span class="text-gray-900">{{ $contract->start_date }}</span>
        </div>

        {{-- تاريخ النهاية --}}
        <div>
            <span class="font-semibold text-gray-700">تاريخ النهاية:</span>
            <span class="text-gray-900">{{ $contract->end_date }}</span>
        </div>

        {{-- قيمة الإيجار --}}
        <div>
            <span class="font-semibold text-gray-700">قيمة الإيجار:</span>
            <span class="text-gray-900">{{ $contract->rent_amount }} {{ __('messages.currency') }}</span>
        </div>

        {{-- ملاحظات --}}
        @if ($contract->notes)
            <div>
                <span class="font-semibold text-gray-700">ملاحظات:</span>
                <p class="text-gray-900 mt-1">{{ $contract->notes }}</p>
            </div>
        @endif

        {{-- ملف العقد --}}
        @if ($contract->contract_file)
            <div>
                <span class="font-semibold text-gray-700">ملف العقد:</span>
                <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                   class="text-blue-600 hover:underline ml-2">عرض / تحميل</a>
            </div>
        @endif

        {{-- أزرار التحكم --}}
        <div class="flex justify-end mt-6">
            <a href="{{ route('contracts.edit', $contract->id) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold mr-2">
                تعديل
            </a>

            <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    حذف
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
