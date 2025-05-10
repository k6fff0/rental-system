@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.contract_details') }}</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        {{-- المستأجر --}}
        <div>
            <span class="font-semibold text-gray-700">{{ __('messages.tenant') }}:</span>
            <span class="text-gray-900">{{ $contract->tenant->name ?? '-' }}</span>
        </div>

        {{-- الوحدة --}}
        <div>
            <span class="font-semibold text-gray-700">{{ __('messages.unit') }}:</span>
            <span class="text-gray-900">{{ $contract->unit->unit_number ?? '-' }}</span>
        </div>

        {{-- تاريخ البداية --}}
        <div>
            <span class="font-semibold text-gray-700">{{ __('messages.start_date') }}:</span>
            <span class="text-gray-900">{{ $contract->start_date }}</span>
        </div>

        {{-- تاريخ النهاية --}}
        <div>
            <span class="font-semibold text-gray-700">{{ __('messages.end_date') }}:</span>
            <span class="text-gray-900">{{ $contract->end_date }}</span>
        </div>

        {{-- قيمة الإيجار --}}
        <div>
            <span class="font-semibold text-gray-700">{{ __('messages.rent_amount') }}:</span>
            <span class="text-gray-900">{{ $contract->rent_amount }} {{ __('messages.currency') }}</span>
        </div>

        {{-- ملاحظات --}}
        @if ($contract->notes)
            <div>
                <span class="font-semibold text-gray-700">{{ __('messages.notes') }}:</span>
                <p class="text-gray-900 mt-1">{{ $contract->notes }}</p>
            </div>
        @endif

        {{-- ملف العقد --}}
        @if ($contract->contract_file)
            <div>
                <span class="font-semibold text-gray-700">{{ __('messages.contract_file') }}:</span>
                <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                   class="text-blue-600 hover:underline {{ app()->getLocale() === 'ar' ? 'ms-2' : 'me-2' }}">
                    {{ __('messages.view_contract') }}
                </a>
            </div>
        @endif

        {{-- أزرار التحكم --}}
        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('admin.contracts.edit', $contract->id) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.edit') }}
            </a>

            <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST"
                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
