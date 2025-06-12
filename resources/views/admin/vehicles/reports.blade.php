@extends('layouts.app')

@section('title', __('messages.vehicle_report'))

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        {{ __('messages.vehicle_report') }}
    </h1>

    <!-- فلتر التاريخ -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ __('messages.from_date') }}
            </label>
            <input type="date" name="from"
                   value="{{ request('from', now()->startOfMonth()->toDateString()) }}"
                   class="w-full px-3 py-2 border rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ __('messages.to_date') }}
            </label>
            <input type="date" name="to"
                   value="{{ request('to', now()->endOfMonth()->toDateString()) }}"
                   class="w-full px-3 py-2 border rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
        </div>
        <div class="md:col-span-2 flex items-end">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition w-full md:w-auto">
                <i class="fas fa-search mr-2"></i>{{ __('messages.apply_filters') }}
            </button>
        </div>
    </form>

    @if($vehicle)
        <!-- بيانات السيارة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                {{ __('messages.vehicle') }}: {{ $vehicle->plate_number }} - {{ $vehicle->brand }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.report_period') }}:
                {{ $from->format('Y-m-d') }} → {{ $to->format('Y-m-d') }}
            </p>
        </div>

        <!-- إجمالي -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">{{ __('messages.total_expenses') }}</h3>
                <p class="text-2xl font-bold mt-2">
                    {{ number_format($vehicle->expenses->sum('amount'), 2) }} {{ __('messages.currency') }}
                </p>
            </div>
            <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">{{ __('messages.total_violations') }}</h3>
                <p class="text-2xl font-bold mt-2">
                    {{ $vehicle->violations->count() }} {{ __('messages.violations') }}
                </p>
            </div>
        </div>

        <!-- المصاريف -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                {{ __('messages.vehicle_expenses') }}
            </h2>
            @if($vehicle->expenses->count())
                <ul class="space-y-3">
                    @foreach($vehicle->expenses as $expense)
                        <li class="flex justify-between border-b pb-2 dark:border-gray-700">
                            <span>{{ $expense->date }} – {{ $expense->description }}</span>
                            <span>{{ number_format($expense->amount, 2) }} {{ __('messages.currency') }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_expenses_found') }}</p>
            @endif
        </div>

        <!-- المخالفات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                {{ __('messages.vehicle_violations') }}
            </h2>
            @if($vehicle->violations->count())
                <ul class="space-y-3">
                    @foreach($vehicle->violations as $violation)
                        <li class="flex justify-between border-b pb-2 dark:border-gray-700">
                            <span>{{ $violation->date }} – {{ $violation->reason }}</span>
                            <span>{{ number_format($violation->amount, 2) }} {{ __('messages.currency') }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_violations_found') }}</p>
            @endif
        </div>
    @else
        <div class="text-gray-600 dark:text-gray-400">
            {{ __('messages.no_report_data') }}
        </div>
    @endif
</div>
@endsection
