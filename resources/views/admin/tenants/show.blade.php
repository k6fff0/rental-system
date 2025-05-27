@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان وزر الرجوع --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.tenant_details') }}</h1>
        <a href="{{ url()->previous() }}"
           class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded font-semibold">
            {{ __('messages.back') }}
        </a>
    </div>

    {{-- ✅ بيانات المستأجر --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-800">

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
                <div class="flex items-center gap-2">
                    <span>{{ $tenant->phone ?? '-' }}</span>
                    @if($tenant->phone)
                    <a href="tel:{{ $tenant->phone }}" class="sm:hidden text-green-600 hover:text-green-800" title="{{ __('messages.call') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.email') }}:</strong>
                <span>{{ $tenant->email ?? '-' }}</span>
            </div>

            <div>
    <strong class="block text-gray-600">{{ __('messages.unit') }}:</strong>
    <div class="flex flex-wrap gap-2 mt-1">
        @forelse ($tenant->activeContracts as $contract)
            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                {{ $contract->unit->unit_number }}
            </span>
        @empty
            <span class="text-gray-500 text-sm">{{ __('messages.no_unit_assigned') }}</span>
        @endforelse
    </div>
</div>


            <div>
                <strong class="block text-gray-600">{{ __('messages.building') }}:</strong>
                <span>{{ $tenant->unit->building->name ?? '-' }}</span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.created_at') }}:</strong>
                <span>
                    {{ $tenant->created_at->format('Y-m-d H:i') }}
                    ({{ $tenant->created_at->diffForHumans() }})
                </span>
            </div>

            <div>
                <strong class="block text-gray-600">{{ __('messages.updated_at') }}:</strong>
                <span>
                    {{ $tenant->updated_at->format('Y-m-d H:i') }}
                    ({{ $tenant->updated_at->diffForHumans() }})
                </span>
            </div>

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

            <div>
                <strong class="block text-gray-600">{{ __('messages.status') }}:</strong>
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
    </div>

    {{-- ✅ الغرفة الحالية --}}
    @if ($activeContracts->count())
    <div class="mt-8 bg-green-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-green-800 mb-2">{{ __('messages.current_unit') }}</h3>
        <ul class="text-sm text-gray-700 space-y-1">
            @foreach ($activeContracts as $contract)
                <li>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        {{ $contract->unit->unit_number }}
                    </span>
                    - {{ $contract->unit->building->name }}
                    ({{ __('messages.from') }} {{ $contract->start_date }} {{ __('messages.to') }} {{ $contract->end_date }})
                </li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- 📜 سجل الغرف السابقة --}}
    @if ($pastContracts->count())
        <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('messages.past_units') }}</h3>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                @foreach ($pastContracts as $contract)
                    <li>
                        {{ $contract->unit->unit_number }} - {{ $contract->unit->building->name }}
                        ({{ __('messages.from') }} {{ $contract->start_date }} {{ __('messages.to') }} {{ $contract->end_date }})
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection
