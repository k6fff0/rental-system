@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.tenant_details') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.full_name') }}:</strong>
                <span class="text-gray-800">{{ $tenant->name }}</span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.id_number') }}:</strong>
                <span class="text-gray-800">{{ $tenant->id_number ?? '-' }}</span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.phone') }}:</strong>
                <div class="flex items-center gap-2 text-gray-800">
                    <span>{{ $tenant->phone ?? '-' }}</span>
                    <a href="tel:{{ $tenant->phone }}" class="sm:hidden text-green-600 hover:text-green-800" title="{{ __('messages.call') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.email') }}:</strong>
                <span class="text-gray-800">{{ $tenant->email ?? '-' }}</span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.unit') }}:</strong>
                <span class="text-gray-800">{{ $tenant->unit->unit_number ?? __('messages.no_unit_assigned') }}</span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.building') }}:</strong>
                <span class="text-gray-800">{{ $tenant->unit->building->name ?? '-' }}</span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.status') }}:</strong>
                @php
                    $status = $tenant->tenant_status;
                    $colors = [
                        'active' => 'bg-green-100 text-green-800',
                        'late_payer' => 'bg-yellow-100 text-yellow-800',
                        'has_debt' => 'bg-red-100 text-red-800',
                        'absent' => 'bg-gray-100 text-gray-800',
                        'abroad' => 'bg-blue-100 text-blue-800',
                        'legal_issue' => 'bg-purple-100 text-purple-800',
                    ];
                @endphp
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ __('messages.tenant_status_' . $status) }}
                </span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.debt') }}:</strong>
                <span class="{{ $tenant->debt > 0 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                    {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                </span>
            </div>

            <div class="flex flex-col">
                <strong class="block text-gray-600">{{ __('messages.has_account') }}:</strong>
                <span class="{{ $tenant->user ? 'text-green-600' : 'text-red-600' }}">
                    {{ $tenant->user ? __('messages.yes') : __('messages.no') }}
                </span>
            </div>

            <div class="md:col-span-2">
                <strong class="block text-gray-600">{{ __('messages.notes') }}:</strong>
                <div class="whitespace-pre-wrap text-gray-800">{{ $tenant->notes ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-6 text-end">
            <a href="{{ route('admin.tenants.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>
</div>
@endsection
