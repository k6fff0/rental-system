@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
        <div class="max-w-full px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

            {{-- العنوان + الإحصائيات --}}
            <div class="mb-6 space-y-4">
                
                {{-- ✅ العنوان والوصف --}}
                <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 me-3 text-blue-500 dark:text-blue-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('messages.contracts') }}
                    </h1>
                    <p class="text-base text-gray-500 dark:text-gray-400 mt-2">{{ __('messages.contracts_description') }}</p>
                </div>

                {{-- 📊 بطاقات الإحصائيات --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.total_contracts') }}</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $contracts->total() }}</p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.active_contracts') }}</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $activeCount ?? 0 }}</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.expiring_soon') }}</p>
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $expiringCount ?? 0 }}</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.expired_contracts') }}</p>
                                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $expiredCount ?? 0 }}</p>
                            </div>
                            <div class="bg-red-100 dark:bg-red-900 p-4 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ✅ الفلاتر الذكية --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('admin.contracts.index') }}" id="filterForm">
                        
                        {{-- الصف الأول من الفلاتر --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            {{-- 🔍 فلتر البحث --}}
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.search') }}
                                </label>
                                <input type="text" name="q" value="{{ request('q') }}"
                                    placeholder="{{ __('messages.search_contracts_placeholder') }}"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 ps-10 pe-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 dark:placeholder-gray-400 transition-all"
                                    onkeyup="filterContracts()">
                                <div class="absolute inset-y-0 {{ app()->getLocale() === '' ? 'end-0 pe-3' : 'start-0 ps-3' }} flex items-center pointer-events-none mt-7">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- ✅ فلتر الحالة --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.status') }}
                                </label>
                                <select name="status"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 transition-all"
                                    onchange="filterContracts()">
                                    <option value="">{{ __('messages.all_statuses') }}</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('messages.expired') }}</option>
                                    <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>{{ __('messages.expiring_soon') }}</option>
                                    <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>{{ __('messages.terminated') }}</option>
                                </select>
                            </div>

                            {{-- 📅 فلتر التاريخ من --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.from_date') }}
                                </label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 transition-all"
                                    onchange="filterContracts()">
                            </div>

                            {{-- 📅 فلتر التاريخ إلى --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.to_date') }}
                                </label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 transition-all"
                                    onchange="filterContracts()">
                            </div>
                        </div>

                        {{-- الصف الثاني - عدد العناصر والأزرار --}}
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                {{-- 📊 عدد العناصر في الصفحة --}}
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('messages.show') }}
                                    </label>
                                    <select name="per_page"
                                        class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 transition-all"
                                        onchange="filterContracts()">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('messages.entries') }}
                                    </span>
                                </div>

                                {{-- زر إعادة تعيين --}}
                                <a href="{{ route('admin.contracts.index') }}"
                                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    {{ __('messages.reset') }}
                                </a>
                            </div>

                            {{-- ➕ زر الإضافة --}}
                            @can('create contracts')
                                <a href="{{ route('admin.contracts.create') }}"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-500 dark:to-blue-600 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 dark:hover:from-blue-600 dark:hover:to-blue-700 text-sm font-semibold transition-all duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ __('messages.add_contract') }}
                                </a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>

            {{-- عرض العقود --}}
            @if ($contracts->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-12 rounded-xl shadow-sm text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-xl font-medium mb-2">{{ __('messages.no_contracts_found') }}</p>
                    <p class="text-base text-gray-400 dark:text-gray-500">{{ __('messages.try_adjusting_filters') }}</p>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                    {{-- معلومات الصفحة الحالية --}}
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('messages.showing') }} 
                            <span class="text-gray-900 dark:text-gray-100">{{ $contracts->firstItem() }}</span> 
                            {{ __('messages.to') }} 
                            <span class="text-gray-900 dark:text-gray-100">{{ $contracts->lastItem() }}</span> 
                            {{ __('messages.of') }} 
                            <span class="text-gray-900 dark:text-gray-100">{{ $contracts->total() }}</span> 
                            {{ __('messages.results') }}
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        #
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.contract_number') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.tenant') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.unit') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.duration') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.monthly_rent') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                        {{ __('messages.status') }}
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">
                                        {{ __('messages.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($contracts as $index => $contract)
                                    @php
                                        $status = $contract->visual_status;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600 dark:text-gray-400">
                                            {{ $contracts->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors cursor-pointer">
                                                {{ $contract->contract_number }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center shadow-inner">
                                                        <span class="text-base font-bold text-gray-700 dark:text-gray-200">
                                                            {{ mb_substr($contract->tenant->name ?? 'N/A', 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $contract->tenant->name ?? '-' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        {{ $contract->tenant->phone ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col items-start">
                                                <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-bold shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $contract->unit->unit_number ?? '-' }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $contract->unit->building->name ?? '' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <div class="flex items-center text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $contract->start_date->format('Y-m-d') }}</span>
                                                </div>
                                                <div class="flex items-center text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $status === 'expired' ? 'text-red-500' : ($status === 'expiring' ? 'text-yellow-500' : 'text-green-500') }} {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="font-medium {{ $status === 'expired' ? 'text-red-600 dark:text-red-400' : ($status === 'expiring' ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400') }}">
                                                        {{ $contract->end_date->format('Y-m-d') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col items-start">
                                                <span class="text-lg font-bold text-blue-500 dark:text-gray-100">
                                                    {{ number_format($contract->rent_amount ?? 0, 0) }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('messages.currency') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                                                {{ match ($status) {
                                                    'expired' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 ring-1 ring-red-200 dark:ring-red-800',
                                                    'expiring' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 ring-1 ring-yellow-200 dark:ring-yellow-800',
                                                    'terminated' => 'bg-gray-100 dark:bg-gray-700/30 text-gray-700 dark:text-gray-300 ring-1 ring-gray-200 dark:ring-gray-600',
                                                    default => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800',
                                                } }}">
                                                <span class="relative flex h-2 w-2 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75
                                                        {{ match ($status) {
                                                            'expired' => 'bg-red-400',
                                                            'expiring' => 'bg-yellow-400',
                                                            'terminated' => 'bg-gray-400',
                                                            default => 'bg-green-400',
                                                        } }}"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2
                                                        {{ match ($status) {
                                                            'expired' => 'bg-red-500',
                                                            'expiring' => 'bg-yellow-500',
                                                            'terminated' => 'bg-gray-500',
                                                            default => 'bg-green-500',
                                                        } }}"></span>
                                                </span>
                                                {{ __('messages.' . $status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                {{-- 👁️ عرض العقد --}}
                                                @can('view contracts')
                                                    <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                        class="inline-flex items-center justify-center w-10 h-10 text-blue-600 dark:text-blue-400 hover:text-white hover:bg-blue-600 dark:hover:bg-blue-500 rounded-lg transition-all duration-200 group"
                                                        title="{{ __('messages.view') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                @endcan

                                                {{-- ✏️ تعديل العقد --}}
                                                @can('edit contracts')
                                                    <a href="{{ route('admin.contracts.edit', $contract->id) }}"
                                                        class="inline-flex items-center justify-center w-10 h-10 text-indigo-600 dark:text-indigo-400 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-500 rounded-lg transition-all duration-200 group"
                                                        title="{{ __('messages.edit') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                @endcan

                                                {{-- 🖨️ طباعة العقد --}}
                                                <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                                    class="inline-flex items-center justify-center w-10 h-10 text-gray-600 dark:text-gray-400 hover:text-white hover:bg-gray-600 dark:hover:bg-gray-500 rounded-lg transition-all duration-200 group"
                                                    title="{{ __('messages.print') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                </a>



                                                {{-- 🛑 إنهاء العقد --}}
                                                @can('end contract')
                                                    @if (!in_array($status, ['terminated']))
                                                        <form action="{{ route('admin.contracts.end', $contract->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                onclick="return confirm('{{ __('messages.confirm_end_contract') }}')"
                                                                class="inline-flex items-center justify-center w-10 h-10 text-orange-600 dark:text-orange-400 hover:text-white hover:bg-orange-600 dark:hover:bg-orange-500 rounded-lg transition-all duration-200 group"
                                                                title="{{ __('messages.end_contract') }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan

                                                {{-- 🗑️ حذف العقد --}}
                                                @can('delete contracts')
                                                    <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                                            class="inline-flex items-center justify-center w-10 h-10 text-red-600 dark:text-red-400 hover:text-white hover:bg-red-600 dark:hover:bg-red-500 rounded-lg transition-all duration-200 group"
                                                            title="{{ __('messages.delete') }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- التصفح (Pagination) --}}
                    @if ($contracts->hasPages())
                        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('messages.showing') }} 
                                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ $contracts->firstItem() }}</span> 
                                    {{ __('messages.to') }} 
                                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ $contracts->lastItem() }}</span> 
                                    {{ __('messages.of') }} 
                                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ $contracts->total() }}</span> 
                                    {{ __('messages.results') }}
                                </div>
                                
                                <nav class="flex items-center space-x-1 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                    {{-- Previous Page Link --}}
                                    @if ($contracts->onFirstPage())
                                        <span class="px-3 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg cursor-not-allowed">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="{{ app()->getLocale() === 'ar' ? 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' : 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' }}" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $contracts->previousPageUrl() }}" 
                                            class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors border border-gray-300 dark:border-gray-600">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="{{ app()->getLocale() === 'ar' ? 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' : 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' }}" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @php
                                        $currentPage = $contracts->currentPage();
                                        $lastPage = $contracts->lastPage();
                                        $start = max(1, $currentPage - 2);
                                        $end = min($lastPage, $currentPage + 2);
                                    @endphp

                                    @if ($start > 1)
                                        <a href="{{ $contracts->url(1) }}" 
                                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors border border-gray-300 dark:border-gray-600">
                                            1
                                        </a>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-400 dark:text-gray-600">...</span>
                                        @endif
                                    @endif

                                    @for ($i = $start; $i <= $end; $i++)
                                        @if ($i == $currentPage)
                                            <span class="px-4 py-2 text-sm font-bold text-white bg-blue-600 dark:bg-blue-500 rounded-lg shadow-md">
                                                {{ $i }}
                                            </span>
                                        @else
                                            <a href="{{ $contracts->url($i) }}" 
                                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors border border-gray-300 dark:border-gray-600">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if ($end < $lastPage)
                                        @if ($end < $lastPage - 1)
                                            <span class="px-2 text-gray-400 dark:text-gray-600">...</span>
                                        @endif
                                        <a href="{{ $contracts->url($lastPage) }}" 
                                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors border border-gray-300 dark:border-gray-600">
                                            {{ $lastPage }}
                                        </a>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($contracts->hasMorePages())
                                        <a href="{{ $contracts->nextPageUrl() }}" 
                                            class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors border border-gray-300 dark:border-gray-600">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="{{ app()->getLocale() === 'ar' ? 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' : 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' }}" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="px-3 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg cursor-not-allowed">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="{{ app()->getLocale() === 'ar' ? 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' : 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' }}" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        // الفلترة الذكية - إرسال النموذج تلقائيًا عند التغيير
        function filterContracts() {
            // إضافة تأخير صغير لتحسين الأداء
            clearTimeout(window.filterTimeout);
            window.filterTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        }

        // تأثيرات الأنيميشن عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });

            // تأثير التحميل للبطاقات الإحصائية
            const cards = document.querySelectorAll('.grid > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // إظهار مؤشر التحميل عند إرسال النموذج
        document.getElementById('filterForm').addEventListener('submit', function() {
            // يمكنك إضافة مؤشر تحميل هنا
            document.body.style.cursor = 'wait';
        });
    </script>

    <style>
        /* تحسينات CSS إضافية */
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            filter: invert(0.8);
        }

        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        /* تحسين مظهر شريط التمرير */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-400 dark:bg-gray-600 rounded-full;
        }

        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-500 dark:bg-gray-500;
        }

        /* تأثير النبض للحالات النشطة */
        @keyframes pulse-dot {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-ping {
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* تحسين الظلال في الوضع الليلي */
        @media (prefers-color-scheme: dark) {
            .shadow-sm {
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
            }
            
            .shadow-md {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.4);
            }
        }
    </style>
@endsection