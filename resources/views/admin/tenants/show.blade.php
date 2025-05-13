@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.tenant_details') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <strong class="block text-gray-600">{{ __('messages.full_name') }}:</strong>
                <span>{{ $tenant->name }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.id_number') }}:</strong>
                <span>{{ $tenant->id_number ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.phone') }}:</strong>
                <span>{{ $tenant->phone ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.email') }}:</strong>
                <span>{{ $tenant->email ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.unit') }}:</strong>
                <span>{{ $tenant->unit->unit_number ?? __('messages.no_unit_assigned') }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.building') }}:</strong>
                <span>{{ $tenant->unit->building->name ?? '-' }}</span>
            </div>

            <div>
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


            <div>
                <strong class="block text-gray-600">{{ __('messages.debt') }}:</strong>
                <span class="{{ $tenant->debt > 0 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                    {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                </span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.has_account') }}:</strong>
                <span class="{{ $tenant->user ? 'text-green-600' : 'text-red-600' }}">
                    {{ $tenant->user ? __('messages.yes') : __('messages.no') }}
                </span>
            </div>

            <div class="md:col-span-2">
                <strong class="block text-gray-600">{{ __('messages.notes') }}:</strong>
                <div class="whitespace-pre-wrap">{{ $tenant->notes ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-6 text-end">
            <a href="{{ route('admin.tenants.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>
</div>
@endsection
