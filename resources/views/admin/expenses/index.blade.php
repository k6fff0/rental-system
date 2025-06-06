@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-red-800">
                            {{ __('messages.expense_list') }}
                        </span>
                    </h1>
                    <p class="text-sm text-gray-500 mt-2">{{ __('messages.total_expenses') }}:
                        {{ number_format($totalExpenses, 2) }} {{ __('messages.currency') }}</p>
                </div>

                <a href="{{ route('admin.expenses.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('messages.add_expense') }}
                </a>
            </div>

            <!-- Filters Section -->
            <div class="bg-white p-4 rounded-xl shadow-md mb-8">
                <form method="GET" action="{{ route('admin.expenses.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Building Filter -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.building') }}</label>
                            <select name="building_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                                <option value="">{{ __('messages.all') }}</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.type') }}</label>
                            <select name="type"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                                <option value="">{{ __('messages.all') }}</option>
                                <option value="furniture" {{ request('type') == 'furniture' ? 'selected' : '' }}>
                                    {{ __('messages.furniture') }}</option>
                                <option value="painting" {{ request('type') == 'painting' ? 'selected' : '' }}>
                                    {{ __('messages.painting') }}</option>
                                <option value="plumbing" {{ request('type') == 'plumbing' ? 'selected' : '' }}>
                                    {{ __('messages.plumbing') }}</option>
                                <option value="electronics" {{ request('type') == 'electronics' ? 'selected' : '' }}>
                                    {{ __('messages.electronics') }}</option>
                                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>
                                    {{ __('messages.other') }}</option>
                            </select>
                        </div>

                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date') }}</label>
                            <input type="date" name="expense_date" value="{{ request('expense_date') }}"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                        </div>

                        <!-- Filter Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0 mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                {{ __('messages.filter') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Expenses List -->
            @if ($expenses->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('messages.no_expenses_found') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('messages.try_changing_filters') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.expenses.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('messages.add_first_expense') }}
                        </a>
                    </div>
                </div>
            @else
                <!-- Expenses Table (Desktop) -->
                <div class="hidden lg:block bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.type') }}</th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.building') }}</th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.unit') }}</th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.amount') }}</th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.date') }}</th>
                                    <th
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.description') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($expenses as $expense)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ __('messages.' . $expense->type) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $expense->building->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $expense->unit->unit_number ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-red-600">
                                                {{ number_format($expense->amount, 2) }} {{ __('messages.currency') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $expense->expense_date }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 truncate max-w-xs">
                                                {{ $expense->description ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                                <a href="{{ route('admin.expenses.edit', $expense->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $expenses->links() }}
                    </div>
                </div>
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('messages.total_expenses') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalExpenses, 2) }}
                                    {{ __('messages.currency') }}</p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('messages.this_month') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($thisMonthExpenses, 2) }}
                                    {{ __('messages.currency') }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('messages.last_month') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($lastMonthExpenses, 2) }}
                                    {{ __('messages.currency') }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('messages.average_monthly') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($averageMonthlyExpenses, 2) }} {{ __('messages.currency') }}</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expenses Cards (Mobile) -->
                <div class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($expenses as $expense)
                        <div
                            class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ __('messages.' . $expense->type) }}</h3>
                                            <p class="text-sm text-gray-500">{{ $expense->expense_date }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ number_format($expense->amount, 2) }} {{ __('messages.currency') }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <div class="text-sm text-gray-600">
                                        <p><strong>{{ __('messages.building') }}:</strong>
                                            {{ $expense->building->name ?? '-' }}</p>
                                        <p><strong>{{ __('messages.unit') }}:</strong>
                                            {{ $expense->unit->unit_number ?? '-' }}</p>
                                        @if ($expense->description)
                                            <p class="mt-1"><strong>{{ __('messages.description') }}:</strong> <span
                                                    class="line-clamp-2">{{ $expense->description }}</span></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 flex justify-end space-x-3 rtl:space-x-reverse">
                                <a href="{{ route('admin.expenses.edit', $expense->id) }}"
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('messages.edit') }}
                                </a>
                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST"
                                    onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination for Mobile -->
                <div class="lg:hidden mt-6">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
