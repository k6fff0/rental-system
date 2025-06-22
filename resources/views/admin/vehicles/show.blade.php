@extends('layouts.app')

@section('title', __('Vehicle Details'))

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 py-6 max-w-7xl">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    {{ __('Vehicle Details') }}
                </h1>

                <a href="{{ route('vehicles.index') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Vehicles') }}
                </a>
            </div>

            <!-- Vehicle Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        {{ __('Vehicle Information') }}
                    </h2>

                    <!-- Vehicle Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label
                                class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Plate Number') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="font-mono text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $vehicle->plate_category }} - {{ $vehicle->plate_number }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Brand') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">{{ $vehicle->brand }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Model') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">{{ $vehicle->model }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Driver') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">{{ $vehicle->user->name ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">{{ __($vehicle->status) }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('License Expiry Date') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ $vehicle->license_expiry_date?->format('Y-m-d') ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Insurance Expiry Date') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ $vehicle->insurance_expiry_date?->format('Y-m-d') ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Notes') }}</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border">
                                <p class="text-gray-900 dark:text-white">{{ $vehicle->notes ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Photo -->
                    @if ($vehicle->photo)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Vehicle Photo') }}
                            </h3>
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="{{ __('Vehicle Photo') }}"
                                    class="max-w-full h-auto rounded-lg shadow-md border border-gray-200 dark:border-gray-700"
                                    style="max-height: 400px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Expenses Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        {{ __('Expenses') }}
                    </h2>

                    <!-- Add Expense Form -->
                    <div
                        class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <form action="{{ route('vehicles.expenses.store', $vehicle->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <input name="type"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="{{ __('Expense Type') }}" required>
                                </div>
                                <div>
                                    <input type="date" name="expense_date"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <input type="number" step="0.01" name="amount"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="0.00" required>
                                </div>
                                <div class="flex gap-2">
                                    <input name="description"
                                        class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="{{ __('Notes (optional)') }}">
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Expenses Table - Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Type') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Date') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Cost') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Notes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicle->expenses as $expense)
                                    <tr
                                        class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="py-3 px-4 text-gray-900 dark:text-white">{{ $expense->type }}</td>
                                        <td class="py-3 px-4 text-gray-900 dark:text-white">{{ $expense->expense_date }}
                                        </td>
                                        <td class="py-3 px-4 text-gray-900 dark:text-white font-semibold">
                                            {{ number_format($expense->amount, 2) }}</td>
                                        <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                            {{ $expense->description ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No expenses found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Expenses Cards - Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse($vehicle->expenses as $expense)
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $expense->type }}</h4>
                                    <span
                                        class="font-bold text-green-600 dark:text-green-400">{{ number_format($expense->amount, 2) }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ $expense->expense_date }}</p>
                                @if ($expense->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $expense->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                {{ __('No expenses found') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Violations Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        {{ __('Violations') }}
                    </h2>

                    <!-- Add Violation Form -->
                    <div
                        class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <form action="{{ route('vehicles.violations.store', $vehicle->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                                <div>
                                    <input name="violation_type"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="{{ __('Violation Type') }}" required>
                                </div>
                                <div>
                                    <input type="date" name="date"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <input type="number" step="0.01" name="cost"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="0.00" required>
                                </div>
                                <div>
                                    <select name="user_id"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="">{{ __('No Driver') }}</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <input name="notes"
                                        class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="{{ __('Notes (optional)') }}">
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Violations Table - Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Type') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Date') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Fine') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Driver') }}</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Notes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicle->violations as $violation)
                                    <tr
                                        class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="py-3 px-4 text-gray-900 dark:text-white">
                                            {{ $violation->violation_type }}</td>
                                        <td class="py-3 px-4 text-gray-900 dark:text-white">{{ $violation->date }}</td>
                                        <td class="py-3 px-4 text-gray-900 dark:text-white font-semibold">
                                            {{ number_format($violation->cost, 2) }}</td>
                                        <td class="py-3 px-4 text-gray-900 dark:text-white">
                                            {{ $violation->user->name ?? '-' }}</td>
                                        <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                            {{ $violation->notes ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No violations found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Violations Cards - Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse($vehicle->violations as $violation)
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $violation->violation_type }}
                                    </h4>
                                    <span
                                        class="font-bold text-red-600 dark:text-red-400">{{ number_format($violation->cost, 2) }}</span>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p>{{ $violation->date }}</p>
                                    <p>{{ __('Driver') }}: {{ $violation->user->name ?? '-' }}</p>
                                    @if ($violation->notes)
                                        <p>{{ $violation->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                {{ __('No violations found') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* RTL Support */
        [dir="rtl"] .rtl\:rotate-180 {
            transform: rotate(180deg);
        }

        /* Dark mode transitions */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        /* Focus styles */
        .focus\:ring-2:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        /* Print styles */
        @media print {

            .bg-gray-50,
            .dark\:bg-gray-900 {
                background: white !important;
            }

            .text-gray-900,
            .dark\:text-white {
                color: black !important;
            }

            .border-gray-200,
            .dark\:border-gray-700 {
                border-color: #e5e7eb !important;
            }
        }
    </style>
@endsection
