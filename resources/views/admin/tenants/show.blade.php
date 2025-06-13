@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-8 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ __('messages.tenant_details') }}</h1>
                    <p class="text-blue-100 opacity-90">{{ __('messages.view_complete_tenant_information') }}</p>
                </div>
                <a href="{{ url()->previous() }}"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('messages.back') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Information Card --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Personal Information --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('messages.personal_information') }}
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="group">
                                <label
                                    class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('messages.full_name') }}</label>
                                <div
                                    class="mt-2 text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $tenant->name }}
                                </div>
                            </div>

                            <div class="group">
                                <label
                                    class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('messages.id_number') }}</label>
                                <div
                                    class="mt-2 text-lg font-mono text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $tenant->id_number ?? '-' }}
                                </div>
                            </div>

                            <div class="group">
                                <label
                                    class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('messages.phone') }}</label>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="text-lg text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $tenant->phone ?? '-' }}
                                    </span>
                                    @if ($tenant->phone)
                                        <a href="tel:{{ $tenant->phone }}"
                                            class="inline-flex items-center justify-center w-10 h-10 bg-green-100 hover:bg-green-200 text-green-600 rounded-full transition-all duration-200 hover:scale-105"
                                            title="{{ __('messages.call') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <tr>
                                <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                    {{ __('messages.family_type') }}
                                </th>
                                <td class="px-6 py-3 text-right text-sm text-gray-800">
                                    {{ __('messages.' . $tenant->family_type) }}
                                </td>
                            </tr>

                            <div class="group">
                                <label
                                    class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('messages.email') }}</label>
                                <div class="mt-2 text-lg text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $tenant->email ?? '-' }}
                                </div>
                            </div>
                           @if ($tenant->id_front || $tenant->id_back)
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">صور الهوية</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if ($tenant->id_front)
                <div>
                    <p class="text-sm text-gray-600 mb-1">الوجه</p>
                    <a data-fancybox="id_card" href="{{ asset('storage/' . $tenant->id_front) }}">
                        <img src="{{ asset('storage/' . $tenant->id_front) }}"
                             alt="صورة الهوية (الوجه)"
                             class="rounded shadow w-full max-h-72 object-contain hover:scale-105 transition-transform duration-200">
                    </a>
                </div>
            @endif

            @if ($tenant->id_back)
                <div>
                    <p class="text-sm text-gray-600 mb-1">الظهر</p>
                    <a data-fancybox="id_card" href="{{ asset('storage/' . $tenant->id_back) }}">
                        <img src="{{ asset('storage/' . $tenant->id_back) }}"
                             alt="صورة الهوية (الظهر)"
                             class="rounded shadow w-full max-h-72 object-contain hover:scale-105 transition-transform duration-200">
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif

                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('messages.notes') }}</label>
                                <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-900 whitespace-pre-wrap min-h-[100px]">
                                    {{ $tenant->notes ?? __('messages.no_notes') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Current Units --}}
                @if ($activeContracts->count())
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                            <h2 class="text-xl font-semibold text-green-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ __('messages.current_unit') }}
                                <span
                                    class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full">{{ $activeContracts->count() }}</span>
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($activeContracts as $contract)
                                    <div
                                        class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M10.5 3L12 2l1.5 1H21l-9 9H3l7-9z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-lg text-gray-900">{{ __('messages.unit') }}
                                                    {{ $contract->unit->unit_number }}</div>
                                                <div class="text-gray-600">{{ $contract->unit->building->name }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">{{ __('messages.contract_period') }}</div>
                                            <div class="font-medium text-gray-900">{{ $contract->start_date }} -
                                                {{ $contract->end_date }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Past Units --}}
                @if ($pastContracts->count())
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
                            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.past_units') }}
                                <span
                                    class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $pastContracts->count() }}</span>
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach ($pastContracts as $contract)
                                    <div
                                        class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ __('messages.unit') }}
                                                {{ $contract->unit->unit_number }} - {{ $contract->unit->building->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $contract->start_date }} -
                                                {{ $contract->end_date }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Status Card --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 border-b border-indigo-200">
                        <h3 class="text-lg font-semibold text-indigo-800">{{ __('messages.status_information') }}</h3>
                    </div>

                    <div class="p-6 space-y-4">
                        @php
                            $status = $tenant->tenant_status;
                            $colors = [
                                'active' => 'bg-green-100 text-green-800 border-green-200',
                                'late_payer' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'has_debt' => 'bg-red-100 text-red-800 border-red-200',
                                'absent' => 'bg-gray-100 text-gray-800 border-gray-200',
                                'abroad' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'legal_issue' => 'bg-purple-100 text-purple-800 border-purple-200',
                            ];
                        @endphp

                        <div class="text-center">
                            <div
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ __('messages.tenant_status_' . $status) }}
                            </div>
                        </div>

                        {{-- Debt Information --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-center">
                                <div class="text-sm text-gray-500 mb-1">{{ __('messages.debt') }}</div>
                                <div
                                    class="text-2xl font-bold {{ $tenant->debt > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                                </div>
                            </div>
                        </div>

                        {{-- Account Status --}}
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">{{ __('messages.has_account') }}</span>
                            <span
                                class="inline-flex items-center gap-1 text-sm font-semibold {{ $tenant->user ? 'text-green-600' : 'text-red-600' }}">
                                @if ($tenant->user)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('messages.yes') }}
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('messages.no') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Timeline Card --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                        <h3 class="text-lg font-semibold text-purple-800">{{ __('messages.timeline') }}</h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ __('messages.created_at') }}</div>
                                <div class="text-xs text-gray-500">{{ $tenant->created_at->format('Y-m-d H:i') }}</div>
                                <div class="text-xs text-gray-400">{{ $tenant->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ __('messages.updated_at') }}</div>
                                <div class="text-xs text-gray-500">{{ $tenant->updated_at->format('Y-m-d H:i') }}</div>
                                <div class="text-xs text-gray-400">{{ $tenant->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Units Summary --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-6 py-4 border-b border-orange-200">
                        <h3 class="text-lg font-semibold text-orange-800">{{ __('messages.units_summary') }}</h3>
                    </div>

                    <div class="p-6">
                        <div class="text-center space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('messages.current_units') }}</span>
                                <span class="font-bold text-green-600">{{ $activeContracts->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('messages.past_units') }}</span>
                                <span class="font-bold text-gray-600">{{ $pastContracts->count() }}</span>
                            </div>
                            <div class="pt-2 border-t">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-sm font-medium text-gray-800">{{ __('messages.total_units') }}</span>
                                    <span
                                        class="font-bold text-blue-600">{{ $activeContracts->count() + $pastContracts->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .grid-cols-1.lg\\:grid-cols-3 {
                gap: 1rem;
            }
        }

        .group:hover .group-hover\\:text-blue-600 {
            color: #2563eb;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .hover\\:scale-105:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
