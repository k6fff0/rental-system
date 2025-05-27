@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان وزر الرجوع --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.contract_details') }}</h1>
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    {{-- ✅ محتوى العقد --}}
    <div class="bg-white shadow rounded-xl p-6 space-y-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-800">
            <div>
                <strong class="block text-gray-600">{{ __('messages.tenant') }}:</strong>
                <span>{{ $contract->tenant->name ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.unit') }}:</strong>
                <span>{{ $contract->unit->unit_number ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.start_date') }}:</strong>
                <span>{{ $contract->start_date }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.end_date') }}:</strong>
                <span>{{ $contract->end_date }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.rent_amount') }}:</strong>
                <span>{{ $contract->rent_amount }} {{ __('messages.currency') }}</span>
            </div>

            @if ($contract->contract_file)
                <div>
                    <strong class="block text-gray-600">{{ __('messages.contract_file') }}:</strong>
                    <a href="{{ asset('storage/' . $contract->contract_file) }}" target="_blank"
                       class="text-blue-600 hover:underline">
                        {{ __('messages.view_contract') }}
                    </a>
                </div>
            @endif

            <div class="sm:col-span-2">
                @if ($contract->notes)
                    <strong class="block text-gray-600">{{ __('messages.notes') }}:</strong>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $contract->notes }}</p>
                @endif
            </div>
        </div>

        {{-- ✅ أزرار التحكم --}}
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('admin.contracts.edit', $contract->id) }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                {{ __('messages.edit') }}
            </a>

            <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST"
                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('messages.delete') }}
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
