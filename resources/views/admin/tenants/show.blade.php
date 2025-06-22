@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300" 
         dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

       <div class="max-w-7xl mx-auto px-2 sm:px-4"> {{-- نفس عرض الجدول --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 sm:mb-2">{{ __('messages.tenant_details') }}</h1>
                <p class="text-blue-100 dark:text-blue-200 opacity-90 text-sm sm:text-base">
                    {{ __('messages.view_complete_tenant_information') }}
                </p>
            </div>
            <a href="{{ url()->previous() }}"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('messages.back') }}
            </a>
        </div>
    </div>
</div>

        <div class="max-w-7xl mx-auto px-2 sm:px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

                {{-- Main Information Card --}}
                <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                    {{-- Personal Information --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-600">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('messages.personal_information') }}
                            </h2>
                        </div>

                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

                                <div class="group">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.full_name') }}</label>
                                    <div class="mt-1 sm:mt-2 text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors break-words">
                                        {{ $tenant->name }}
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.id_number') }}</label>
                                    <div class="mt-1 sm:mt-2 text-base sm:text-lg font-mono text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors break-all">
                                        {{ $tenant->id_number ?? '-' }}
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.phone') }}</label>
                                    <div class="mt-1 sm:mt-2 flex items-center gap-2 sm:gap-3 flex-wrap">
                                        <span class="text-base sm:text-lg text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors break-all">
                                            {{ $tenant->phone ?? '-' }}
                                        </span>
                                        @if ($tenant->phone)
                                            <a href="tel:{{ $tenant->phone }}"
                                                class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-green-100 dark:bg-green-900/30 hover:bg-green-200 dark:hover:bg-green-900/50 text-green-600 dark:text-green-400 rounded-full transition-all duration-200 hover:scale-105"
                                                title="{{ __('messages.call') }}">
                                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.family_type') }}</label>
                                    <div class="mt-1 sm:mt-2 text-base sm:text-lg text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ __('messages.' . $tenant->family_type) }}
                                    </div>
                                </div>

                                <div class="group sm:col-span-2">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.email') }}</label>
                                    <div class="mt-1 sm:mt-2 text-base sm:text-lg text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors break-all">
                                        {{ $tenant->email ?? '-' }}
                                    </div>
                                </div>

                                {{-- ID Images Section --}}
                                @if ($tenant->id_front || $tenant->id_back)
                                    <div class="sm:col-span-2 mt-4 sm:mt-6">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 sm:mb-4">{{ __('messages.id_images') }}</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                            @if ($tenant->id_front)
                                                <div>
                                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">{{ __('messages.id_front') }}</p>
                                                    <a data-fancybox="id_card" href="{{ asset('storage/' . $tenant->id_front) }}">
                                                        <img src="{{ asset('storage/' . $tenant->id_front) }}"
                                                             alt="{{ __('messages.id_front') }}"
                                                             class="rounded-lg shadow-md w-full h-32 sm:h-48 object-cover hover:scale-105 transition-transform duration-200 cursor-pointer">
                                                    </a>
                                                </div>
                                            @endif

                                            @if ($tenant->id_back)
                                                <div>
                                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">{{ __('messages.id_back') }}</p>
                                                    <a data-fancybox="id_card" href="{{ asset('storage/' . $tenant->id_back) }}">
                                                        <img src="{{ asset('storage/' . $tenant->id_back) }}"
                                                             alt="{{ __('messages.id_back') }}"
                                                             class="rounded-lg shadow-md w-full h-32 sm:h-48 object-cover hover:scale-105 transition-transform duration-200 cursor-pointer">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="sm:col-span-2">
                                    <label class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.notes') }}</label>
                                    <div class="mt-1 sm:mt-2 p-3 sm:p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-gray-100 whitespace-pre-wrap min-h-[80px] sm:min-h-[100px] text-sm sm:text-base">
                                        {{ $tenant->notes ?? __('messages.no_notes') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Current Units --}}
                    @if ($activeContracts->count())
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-green-200 dark:border-green-700">
                                <h2 class="text-lg sm:text-xl font-semibold text-green-800 dark:text-green-300 flex items-center gap-2 flex-wrap">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span>{{ __('messages.current_unit') }}</span>
                                    <span class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-200 text-xs px-2 py-1 rounded-full">{{ $activeContracts->count() }}</span>
                                </h2>
                            </div>

                            <div class="p-4 sm:p-6">
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach ($activeContracts as $contract)
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 sm:p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700 hover:shadow-md transition-shadow gap-3 sm:gap-4">
                                            <div class="flex items-center gap-3 sm:gap-4">
                                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-800/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M10.5 3L12 2l1.5 1H21l-9 9H3l7-9z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="font-semibold text-base sm:text-lg text-gray-900 dark:text-gray-100 truncate">
                                                        {{ __('messages.unit') }} {{ $contract->unit->unit_number }}
                                                    </div>
                                                    <div class="text-sm sm:text-base text-gray-600 dark:text-gray-400 truncate">{{ $contract->unit->building->name }}</div>
                                                </div>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('messages.contract_period') }}</div>
                                                <div class="font-medium text-sm sm:text-base text-gray-900 dark:text-gray-100">
                                                    {{ $contract->start_date }} - {{ $contract->end_date }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Past Units --}}
                    @if ($pastContracts->count())
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-600">
                                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2 flex-wrap">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ __('messages.past_units') }}</span>
                                    <span class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs px-2 py-1 rounded-full">{{ $pastContracts->count() }}</span>
                                </h2>
                            </div>

                            <div class="p-4 sm:p-6">
                                <div class="space-y-2 sm:space-y-3">
                                    @foreach ($pastContracts as $contract)
                                        <div class="flex items-center gap-3 sm:gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-sm sm:text-base text-gray-900 dark:text-gray-100 truncate">
                                                    {{ __('messages.unit') }} {{ $contract->unit->unit_number }} - {{ $contract->unit->building->name }}
                                                </div>
                                                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $contract->start_date }} - {{ $contract->end_date }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-4 sm:space-y-6">

                    {{-- Status Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-indigo-200 dark:border-indigo-700">
                            <h3 class="text-base sm:text-lg font-semibold text-indigo-800 dark:text-indigo-300">{{ __('messages.status_information') }}</h3>
                        </div>

                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            @php
                                $status = $tenant->tenant_status;
                                $colors = [
                                    'active' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-700',
                                    'late_payer' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-700',
                                    'has_debt' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-700',
                                    'absent' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                                    'abroad' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-700',
                                    'legal_issue' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border-purple-200 dark:border-purple-700',
                                    'blocked' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-700',
                                ];
                            @endphp

                            <div class="text-center">
                                <div class="inline-flex items-center px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold border {{ $colors[$status] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 border-gray-200 dark:border-gray-600' }}">
                                    {{ __('messages.tenant_status_' . $status) }}
                                </div>
                            </div>

                            {{-- Debt Information --}}
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 sm:p-4">
                                <div class="text-center">
                                    <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.debt') }}</div>
                                    <div class="text-xl sm:text-2xl font-bold {{ $tenant->debt > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Account Status --}}
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.has_account') }}</span>
                                <span class="inline-flex items-center gap-1 text-xs sm:text-sm font-semibold {{ $tenant->user ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    @if ($tenant->user)
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('messages.yes') }}
                                    @else
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        {{ __('messages.no') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-purple-200 dark:border-purple-700">
                            <h3 class="text-base sm:text-lg font-semibold text-purple-800 dark:text-purple-300">{{ __('messages.timeline') }}</h3>
                        </div>

                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-green-500 dark:bg-green-400 rounded-full flex-shrink-0"></div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.created_at') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $tenant->created_at->format('Y-m-d H:i') }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $tenant->created_at->diffForHumans() }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-blue-500 dark:bg-blue-400 rounded-full flex-shrink-0"></div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.updated_at') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $tenant->updated_at->format('Y-m-d H:i') }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $tenant->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Units Summary --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-orange-200 dark:border-orange-700">
                            <h3 class="text-base sm:text-lg font-semibold text-orange-800 dark:text-orange-300">{{ __('messages.units_summary') }}</h3>
                        </div>

                        <div class="p-4 sm:p-6">
                            <div class="text-center space-y-2 sm:space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ __('messages.current_units') }}</span>
                                    <span class="font-bold text-green-600 dark:text-green-400">{{ $activeContracts->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ __('messages.past_units') }}</span>
                                    <span class="font-bold text-gray-600 dark:text-gray-400">{{ $pastContracts->count() }}</span>
                                </div>
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">{{ __('messages.total_units') }}</span>
                                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $activeContracts->count() + $pastContracts->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Styles for Mobile and Dark Mode --}}
    <style>
        /* Enhanced responsive design */
        @media (max-width: 640px) {
            .grid-cols-1.lg\\:grid-cols-3 {
                gap: 1rem;
            }
            
            /* Better text wrapping on mobile */
            .break-all {
                word-break: break-all;
                overflow-wrap: break-word;
            }
            
            .break-words {
                word-break: break-word;
                overflow-wrap: break-word;
            }
            
            /* Improve touch targets */
            .group {
                min-height: 44px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            /* Extra small screens */
            .text-xl {
                font-size: 1.125rem;
                line-height: 1.75rem;
            }
            
            .text-2xl {
                font-size: 1.25rem;
                line-height: 1.75rem;
            }
            
            .p-6 {
                padding: 1rem;
            }
            
            .px-6 {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .py-4 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }

        /* Enhanced hover effects */
        .group:hover .group-hover\\:text-blue-600 {
            color: #2563eb;
        }

        .dark .group:hover .dark\\:group-hover\\:text-blue-400 {
            color: #60a5fa;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .transition-colors {
            transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
        }

        .transition-transform {
            transition: transform 0.2s ease-in-out;
        }

        .transition-shadow {
            transition: box-shadow 0.2s ease-in-out;
        }

        /* Enhanced hover effects */
        .hover\\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dark .hover\\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        /* Focus styles for accessibility */
        .focus\\:outline-none:focus {
            outline: none;
        }

        .focus\\:ring-2:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        /* Custom scrollbar for better UX */
        .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .dark .overflow-y-auto {
            scrollbar-color: #64748b #374151;
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark .overflow-y-auto::-webkit-scrollbar-track {
            background: #374151;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #64748b;
        }

        /* Enhanced gradient backgrounds for dark mode */
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        /* Image optimization */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Loading state for images */
        img[src] {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        img[src].loaded {
            opacity: 1;
        }

        /* Enhanced card shadows for dark mode */
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        /* Status badge animations */
        .status-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        /* Better text contrast in dark mode */
        .dark .text-gray-900 {
            color: #f9fafb;
        }

        .dark .text-gray-800 {
            color: #f3f4f6;
        }

        .dark .text-gray-700 {
            color: #e5e7eb;
        }

        .dark .text-gray-600 {
            color: #d1d5db;
        }

        .dark .text-gray-500 {
            color: #9ca3af;
        }

        .dark .text-gray-400 {
            color: #6b7280;
        }

        /* Enhanced button styles */
        .btn-hover {
            position: relative;
            overflow: hidden;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover:hover::before {
            left: 100%;
        }

        /* Print styles */
        @media print {
            .bg-gradient-to-r {
                background: #f8fafc !important;
                color: #1e293b !important;
            }
            
            .shadow-lg {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
            
            .rounded-lg,
            .rounded-xl {
                border-radius: 0 !important;
            }
            
            .text-white {
                color: #1e293b !important;
            }
        }

        /* Animation for loading states */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        .dark .skeleton {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .bg-gray-50 {
                background-color: #ffffff;
            }
            
            .dark .bg-gray-800 {
                background-color: #000000;
            }
            
            .text-gray-600 {
                color: #000000;
            }
            
            .dark .text-gray-400 {
                color: #ffffff;
            }
        }
    </style>

    {{-- JavaScript for enhanced functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lazy load images
            const images = document.querySelectorAll('img[src]');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
                
                // If image is already loaded
                if (img.complete) {
                    img.classList.add('loaded');
                }
            });

            // Add loading state to phone call links
            const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
            phoneLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Add haptic feedback for mobile
                    if ('vibrate' in navigator) {
                        navigator.vibrate(50);
                    }
                    
                    // Visual feedback
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });

            // Smooth scroll for anchor links
            const anchorLinks = document.querySelectorAll('a[href^="#"]');
            anchorLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add intersection observer for animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Observe cards for animation
            const cards = document.querySelectorAll('.bg-white, .dark\\:bg-gray-800');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Copy to clipboard functionality
            function copyToClipboard(text) {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        showToast('{{ __('messages.copied_to_clipboard') }}', 'success');
                    });
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showToast('{{ __('messages.copied_to_clipboard') }}', 'success');
                }
            }

            // Add click to copy functionality for ID number and phone
            const copyableElements = document.querySelectorAll('.font-mono, [href^="tel:"]');
            copyableElements.forEach(element => {
                element.style.cursor = 'pointer';
                element.title = '{{ __('messages.click_to_copy') }}';
                
                element.addEventListener('click', function(e) {
                    if (!this.href) { // Only for non-link elements
                        e.preventDefault();
                        copyToClipboard(this.textContent.trim());
                    }
                });
            });

            // Toast notification system
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
                    type === 'success' ? 'bg-green-500 text-white' : 
                    type === 'error' ? 'bg-red-500 text-white' : 
                    'bg-blue-500 text-white'
                }`;
                
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="flex-1 text-sm font-medium">${message}</div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Make function globally available
            window.showToast = showToast;
        });
    </script>
@endsection