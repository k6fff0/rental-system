@extends('layouts.app')

@section('title', __('vehicles.reports.title'))

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
        <div class="container mx-auto px-4">

            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-emerald-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ __('vehicles.reports.title') }}
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('vehicles.reports.subtitle') }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="flex gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $expenses->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('vehicles.reports.expenses_count') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $violations->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('vehicles.reports.violations_count') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-emerald-600">
                                {{ number_format($expenses->sum('amount') + $violations->sum('amount')) }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('vehicles.reports.total_cost') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            @if ($expenses->count() > 0 || $violations->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        {{ __('vehicles.reports.summary') }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                            <div class="text-sm text-blue-600 dark:text-blue-400">
                                {{ __('vehicles.reports.total_expenses') }}</div>
                            <div class="text-xl font-bold text-blue-900 dark:text-blue-100">
                                {{ number_format($expenses->sum('amount')) }}</div>
                            <div class="text-xs text-blue-500">{{ $expenses->count() }} {{ __('vehicles.reports.items') }}
                            </div>
                        </div>

                        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4">
                            <div class="text-sm text-red-600 dark:text-red-400">{{ __('vehicles.reports.total_fines') }}
                            </div>
                            <div class="text-xl font-bold text-red-900 dark:text-red-100">
                                {{ number_format($violations->sum('cost')) }}</div>
                            <div class="text-xs text-red-500">{{ $violations->count() }}
                                {{ __('vehicles.reports.violations') }}</div>
                        </div>

                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-4">
                            <div class="text-sm text-emerald-600 dark:text-emerald-400">
                                {{ __('vehicles.reports.grand_total') }}</div>
                            <div class="text-xl font-bold text-emerald-900 dark:text-emerald-100">
                                {{ number_format($expenses->sum('amount') + $violations->sum('cost')) }}</div>
                            <div class="text-xs text-emerald-500">{{ __('vehicles.reports.currency') }}</div>
                        </div>

                        
                    </div>
                </div>
            @endif

            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                    </svg>
                    {{ __('vehicles.reports.filter_data') }}
                </h2>

                <form method="GET" action="{{ route('vehicles.reports') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('vehicles.reports.date_from') }}
                        </label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('vehicles.reports.date_to') }}
                        </label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('vehicles.reports.vehicle') }}
                        </label>
                        <select name="vehicle_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('vehicles.reports.all_vehicles') }}</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->plate_category }} {{ $vehicle->plate_number }} - {{ $vehicle->brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('vehicles.reports.driver') }}
                        </label>
                        <select name="user_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('vehicles.reports.all_drivers') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-4 flex flex-wrap gap-2 mt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ __('vehicles.reports.show_report') }}
                        </button>

                        <a href="{{ route('vehicles.reports.pdf', request()->all()) }}"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('vehicles.reports.download_pdf') }}
                        </a>

                        <a href="{{ route('vehicles.reports.excel', request()->all()) }}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('vehicles.reports.download_excel') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Expenses Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            {{ __('vehicles.reports.expenses') }}
                        </h2>
                        <div class="text-sm">
                            <span class="font-semibold">{{ __('vehicles.reports.total') }}:</span>
                            <span class="text-blue-600">{{ number_format($expenses->sum('amount')) }}
                                {{ __('vehicles.reports.currency') }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if ($expenses->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.vehicle') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.type') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.date') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.cost') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.notes') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($expenses as $expense)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ optional($expense->expensable)->plate_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                                {{ $expense->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $expense->expense_date }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                            {{ number_format($expense->amount) }} {{ __('vehicles.reports.currency') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $expense->description ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">
                                {{ __('vehicles.reports.no_expenses') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('vehicles.reports.no_expenses_desc') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Violations Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="bg-red-50 dark:bg-red-900/20 px-6 py-4 border-b border-red-200 dark:border-red-800">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('vehicles.reports.violations') }}
                        </h2>
                        <div class="text-sm">
                            <span class="font-semibold">{{ __('vehicles.reports.total_fines') }}:</span>
                            <span class="text-red-600">{{ number_format($violations->sum('cost')) }}
                                {{ __('vehicles.reports.currency') }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if ($violations->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.vehicle') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.driver') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.type') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.date') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.fine') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('vehicles.reports.notes') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($violations as $violation)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $violation->vehicle->plate_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $violation->user ? $violation->user->name : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                {{ $violation->violation_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $violation->date }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600 dark:text-red-400">
                                            {{ number_format($violation->cost) }} {{ __('vehicles.reports.currency') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $violation->notes ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">
                                {{ __('vehicles.reports.no_violations') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('vehicles.reports.no_violations_desc') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            /* RTL Support */
            [dir="rtl"] .text-start {
                text-align: right;
            }

            [dir="ltr"] .text-start {
                text-align: left;
            }

            /* Simple transitions */
            button,
            a {
                transition: all 0.2s ease;
            }

            /* Table hover effect */
            tr {
                transition: background-color 0.2s ease;
            }

            /* Print styles */
            @media print {
                .no-print {
                    display: none !important;
                }

                body {
                    background: white !important;
                }

                .container {
                    max-width: none !important;
                }

                .shadow-sm {
                    box-shadow: none !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form validation
                const form = document.querySelector('form');
                if (form) {
                    const startDate = form.querySelector('input[name="start_date"]');
                    const endDate = form.querySelector('input[name="end_date"]');

                    form.addEventListener('submit', function(e) {
                        if (startDate.value && endDate.value) {
                            if (new Date(startDate.value) > new Date(endDate.value)) {
                                e.preventDefault();
                                alert('{{ __('vehicles.reports.date_error') }}');
                            }
                        }
                    });
                }

                
            });
        </script>
    @endpush
@endsection
