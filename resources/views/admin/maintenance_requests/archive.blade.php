@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <!-- Header Section with Back Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center p-2 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-200">
                    {{ __('messages.maintenance_archive') }}
                </h1>
            </div>

            <!-- Export Buttons -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.maintenance_requests.exportPdf') }}"
                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z" />
                    </svg>
                    {{ __('messages.export_pdf') }}
                </a>
                <a href="{{ route('admin.maintenance_requests.exportExcel') }}"
                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm8 6V7h4v2h-4zM4 7h4v2H4V7zm0 4h4v2H4v-2zm0 4h4v2H4v-2zm8 0h4v2h-4v-2zm0-4h4v2h-4v-2z" />
                    </svg>
                    {{ __('messages.export_excel') }}
                </a>
            </div>
        </div>

        <!-- Smart Filters Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.553.894l-2 1A1 1 0 018 16v-4.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        {{ __('messages.smart_filters') }}
                    </h2>
                    <button type="button" id="toggleFilters" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <span id="filterToggleText">{{ __('messages.show_filters') }}</span>
                        <svg id="filterToggleIcon"
                            class="w-4 h-4 inline {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }} transform transition-transform"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Quick Search -->
                <div class="mb-4">
                    <div class="relative">
                        <input type="text" id="quickSearch"
                            placeholder="{{ __('messages.search_anything_placeholder') }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-2' : 'right-2' }} flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <form method="GET" id="filtersForm" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-4">

                        <!-- Issue Type Filter with Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.issue_type') }}
                            </label>
                            <div class="relative">
                                <select name="sub_specialty_id"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                                    <option value="">{{ __('messages.all_issue_types') }}</option>
                                    @foreach (App\Models\Specialty::whereNotNull('parent_id')->get() as $issue)
                                        <option value="{{ $issue->id }}"
                                            {{ request('sub_specialty_id') == $issue->id ? 'selected' : '' }}>
                                            {{ $issue->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Smart Unit Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.unit_number') }}
                            </label>
                            <div class="relative">
                                <input type="text" name="unit_search" id="unitSearch"
                                    value="{{ request('unit_search') }}"
                                    placeholder="{{ __('messages.type_to_search_units') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                                <div id="unitSuggestions"
                                    class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg mt-1 max-h-48 overflow-y-auto hidden shadow-lg">
                                    <!-- Dynamic suggestions will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- Technician Filter with Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.technician') }}
                            </label>
                            <div class="relative">
                                <input type="text" id="technicianSearch"
                                    placeholder="{{ __('messages.type_to_search_technicians') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                                <select name="assigned_worker_id" id="technicianSelect"
                                    class="hidden w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                                    <option value="">{{ __('messages.all_technicians') }}</option>
                                    @foreach (App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'technician'))->get() as $tech)
                                        <option value="{{ $tech->id }}"
                                            {{ request('assigned_worker_id') == $tech->id ? 'selected' : '' }}>
                                            {{ $tech->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="technicianSuggestions"
                                    class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg mt-1 max-h-48 overflow-y-auto hidden shadow-lg">
                                    <!-- Dynamic suggestions will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.status') }}
                            </label>
                            <div class="relative">
                                <select name="status"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                                    <option value="">{{ __('messages.all_statuses') }}</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        {{ __('messages.completed') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('messages.pending') }}</option>
                                    <option value="in_progress"
                                        {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                                        {{ __('messages.in_progress') }}</option>
                                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>
                                        {{ __('messages.canceled') }}</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-2' : 'right-2' }} flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.from_date') }}
                            </label>
                            <input type="date" name="from" value="{{ request('from') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.to_date') }}
                            </label>
                            <input type="date" name="to" value="{{ request('to') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.apply_filters') }}
                        </button>
                        <a href="{{ route('admin.maintenance_requests.index') }}"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.reset_filters') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.showing_results', ['total' => $requests->total()]) }}
            </p>

            <!-- Sorting Options -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.sort_by') }}:</span>
                <select id="sortSelect"
                    class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 bg-white dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                    <option value="newest">{{ __('messages.newest_first') }}</option>
                    <option value="oldest">{{ __('messages.oldest_first') }}</option>
                    <option value="status">{{ __('messages.status') }}</option>
                </select>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">

            <!-- Mobile Cards View (Hidden on larger screens) -->
            <div class="block lg:hidden">
                @foreach ($requests as $req)
                    <div
                        class="border-b border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <span
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">#{{ $req->id }}</span>
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $req->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                            {{ $req->status == 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : '' }}
                            {{ $req->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                            {{ $req->status == 'canceled' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}">
                                    {{ __('messages.' . $req->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.building') }}:</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ $req->building->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.unit') }}:</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ $req->unit->unit_number ?? '-' }}</span>
                                </div>
                                <div>
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.issue_type') }}:</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ $req->subSpecialty->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.technician') }}:</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ $req->technician->name ?? __('messages.not_assigned') }}</span>
                                </div>
                                <div>
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.date') }}:</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ $req->created_at->translatedFormat('Y-m-d h:i A') }}</span>
                                </div>
                            </div>

                            <div class="pt-2 flex justify-between items-center">
                                <a href="{{ route('admin.maintenance_requests.show', $req->id) }}"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ __('messages.view_details') }}
                                </a>

                                @if ($req->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        <svg class="w-3 h-3 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ __('messages.requires_action') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table View (Hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.request_id') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.building') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.unit') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.issue_type') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.technician') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.date') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.status') }}
                            </th>
                            <th
                                class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($requests as $req)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    #{{ $req->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $req->building->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $req->unit->unit_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $req->subSpecialty->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $req->technician->name ?? __('messages.not_assigned') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $req->created_at->translatedFormat('Y-m-d h:i A') }}
                                </td>
                                @php
                                    $statusColor = match ($req->status) {
                                        'completed'
                                            => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ __('messages.' . $req->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.maintenance_requests.show', $req->id) }}"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ __('messages.view') }}
                                        </a>

                                        @if ($req->status === 'pending')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                <svg class="w-3 h-3 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('messages.requires_action') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $requests->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter toggle functionality
            const toggleFilters = document.getElementById('toggleFilters');
            const filtersForm = document.getElementById('filtersForm');
            const toggleText = document.getElementById('filterToggleText');
            const toggleIcon = document.getElementById('filterToggleIcon');

            toggleFilters.addEventListener('click', function() {
                if (filtersForm.classList.contains('hidden')) {
                    filtersForm.classList.remove('hidden');
                    toggleText.textContent = '{{ __('messages.hide_filters') }}';
                    toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    filtersForm.classList.add('hidden');
                    toggleText.textContent = '{{ __('messages.show_filters') }}';
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            });

            // Smart unit search functionality
            const unitSearch = document.getElementById('unitSearch');
            const unitSuggestions = document.getElementById('unitSuggestions');
            let unitSearchTimeout;

            unitSearch.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(unitSearchTimeout);

                if (query.length === 0) {
                    unitSuggestions.classList.add('hidden');
                    return;
                }

                unitSearchTimeout = setTimeout(() => {
                    fetch(`{{ route('admin.units.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            unitSuggestions.innerHTML = '';

                            if (data.length > 0) {
                                data.forEach(unit => {
                                    const div = document.createElement('div');
                                    div.className =
                                        'px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-sm text-gray-700 dark:text-gray-300';
                                    div.textContent = unit.unit_number + (unit
                                        .building ? ` - ${unit.building.name}` : '');
                                    div.addEventListener('click', function() {
                                        unitSearch.value = unit.unit_number;
                                        unitSuggestions.classList.add('hidden');
                                        document.getElementById('filtersForm')
                                            .submit();
                                    });
                                    unitSuggestions.appendChild(div);
                                });
                                unitSuggestions.classList.remove('hidden');
                            } else {
                                const div = document.createElement('div');
                                div.className =
                                    'px-3 py-2 text-sm text-gray-500 dark:text-gray-400';
                                div.textContent = '{{ __('messages.no_units_found') }}';
                                unitSuggestions.appendChild(div);
                                unitSuggestions.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Unit search error:', error);
                            unitSuggestions.classList.add('hidden');
                        });
                }, 300);
            });

            // Smart technician search functionality
            const technicianSearch = document.getElementById('technicianSearch');
            const technicianSelect = document.getElementById('technicianSelect');
            const technicianSuggestions = document.getElementById('technicianSuggestions');
            let techSearchTimeout;

            technicianSearch.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(techSearchTimeout);

                if (query.length === 0) {
                    technicianSuggestions.classList.add('hidden');
                    return;
                }

                techSearchTimeout = setTimeout(() => {
                    fetch(
                            `{{ route('admin.technicians.search') }}?q=${encodeURIComponent(query)}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            technicianSuggestions.innerHTML = '';

                            if (data.length > 0) {
                                data.forEach(tech => {
                                    const div = document.createElement('div');
                                    div.className =
                                        'px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-sm text-gray-700 dark:text-gray-300';
                                    div.textContent = tech.name;
                                    div.addEventListener('click', function() {
                                        technicianSearch.value = tech.name;
                                        technicianSelect.value = tech.id;
                                        technicianSuggestions.classList.add(
                                            'hidden');
                                        document.getElementById('filtersForm')
                                            .submit();
                                    });
                                    technicianSuggestions.appendChild(div);
                                });
                                technicianSuggestions.classList.remove('hidden');
                            } else {
                                const div = document.createElement('div');
                                div.className =
                                    'px-3 py-2 text-sm text-gray-500 dark:text-gray-400';
                                div.textContent = '{{ __('messages.no_technicians_found') }}';
                                technicianSuggestions.appendChild(div);
                                technicianSuggestions.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Technician search error:', error);
                            technicianSuggestions.classList.add('hidden');
                        });
                }, 300);
            });

            // Quick search functionality
            const quickSearch = document.getElementById('quickSearch');
            let quickSearchTimeout;

            quickSearch.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(quickSearchTimeout);

                if (query.length === 0) {
                    return;
                }

                quickSearchTimeout = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('quick_search', query);
                    window.location.href = url.toString();
                }, 500);
            });

            // Sorting functionality
            const sortSelect = document.getElementById('sortSelect');
            sortSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                window.location.href = url.toString();
            });

            // Set current sort value
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('sort')) {
                sortSelect.value = urlParams.get('sort');
            }

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!unitSearch.contains(event.target) && !unitSuggestions.contains(event.target)) {
                    unitSuggestions.classList.add('hidden');
                }

                if (!technicianSearch.contains(event.target) && !technicianSuggestions.contains(event
                        .target)) {
                    technicianSuggestions.classList.add('hidden');
                }
            });

            // Show filters if there are active filters
            if (urlParams.get('sub_specialty_id') || urlParams.get('unit_search') || urlParams.get(
                    'assigned_worker_id') ||
                urlParams.get('status') || urlParams.get('from') || urlParams.get('to') || urlParams.get(
                    'quick_search')) {
                toggleFilters.click();
            }

            // Set technician search value if technician is selected
            const selectedTechId = urlParams.get('assigned_worker_id');
            if (selectedTechId) {
                const selectedOption = technicianSelect.querySelector(`option[value="${selectedTechId}"]`);
                if (selectedOption) {
                    technicianSearch.value = selectedOption.textContent;
                }
            }
        });
    </script>
@endsection
