@extends('layouts.app')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <!-- Welcome Section -->
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.admin_dashboard') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">
                                {{ __('messages.welcome_back') }}, {{ Auth::user()->name }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Actions & Theme Toggle -->
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <!-- Theme Toggle -->
                        <button id="theme-toggle"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-gray-600 dark:text-gray-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-gray-600 dark:text-gray-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2L13.09 8.26L20 9L14 14.74L15.18 21.02L10 17.77L4.82 21.02L6 14.74L0 9L6.91 8.26L10 2Z">
                                </path>
                            </svg>
                        </button>

                        <!-- Notifications -->
                        @if ($expiringContracts->count() > 0)
                            <div class="relative">
                                <div
                                    class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2 rtl:space-x-reverse animate-pulse">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="font-medium text-sm">
                                        {{ __('messages.expiring_contracts_alert', ['count' => $expiringContracts->count()]) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Users Card -->
                <div
                    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 relative">
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-bl-full opacity-10">
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                            {{ __('messages.users') }}</h3>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                            {{ number_format($usersCount) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">+12% من الشهر
                                            الماضي</span>
                                    </div>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buildings Card -->
                <div
                    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 relative">
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-bl-full opacity-10">
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                            {{ __('messages.buildings') }}</h3>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                            {{ number_format($buildingsCount) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">+3 مباني
                                            جديدة</span>
                                    </div>
                                    <a href="{{ route('admin.buildings.index') }}"
                                        class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform text-green-600 dark:text-green-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Units Card -->
                <div
                    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 relative">
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-bl-full opacity-10">
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                            {{ __('messages.units') }}</h3>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                            {{ number_format($unitsCount) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-3 rtl:space-x-reverse text-xs">
                                        <span class="flex items-center text-green-600 dark:text-green-400">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-1 rtl:ml-1"></div>
                                            {{ $availableUnitsCount }} متاحة
                                        </span>
                                        <span class="flex items-center text-red-600 dark:text-red-400">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-1 rtl:ml-1"></div>
                                            {{ $occupiedUnitsCount }} مؤجرة
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.units.index') }}"
                                        class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform text-purple-600 dark:text-purple-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tenants Card -->
                <div
                    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 relative">
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-600 rounded-bl-full opacity-10">
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                            {{ __('messages.tenants') }}</h3>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                            {{ number_format($tenantsCount) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                                        <span
                                            class="text-xs text-orange-600 dark:text-orange-400 font-medium">{{ number_format(($occupiedUnitsCount / $unitsCount) * 100, 1) }}%
                                            إشغال</span>
                                    </div>
                                    <a href="{{ route('admin.tenants.index') }}"
                                        class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform text-orange-600 dark:text-orange-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">الإجراءات السريعة</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    <!-- Add New Tenant -->
                    <a href="{{ route('admin.tenants.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800/30 dark:hover:to-blue-700/30 transition-all duration-200 border border-blue-200 dark:border-blue-700">
                        <div
                            class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">إضافة مستأجر</span>
                    </a>

                    <!-- units.available -->
                    <a href="{{ route('units.available') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/30 dark:hover:to-green-700/30 transition-all duration-200 border border-green-200 dark:border-green-700">
                        <div
                            class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">الغرف المتاحة</span>
                    </a>
                    <!-- room_bookings -->
                    <a href="{{ route('admin.bookings.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-sky-50 to-sky-100 dark:from-sky-900/20 dark:to-sky-800/20 hover:from-sky-100 hover:to-sky-200 dark:hover:from-sky-800/30 dark:hover:to-sky-700/30 transition-all duration-200 border border-sky-200 dark:border-sky-700">
                        <div
                            class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h3a2 2 0 012 2v2h6V6a2 2 0 012-2h1a2 2 0 012 2v14a2 2 0 01-2 2h-1a2 2 0 01-2-2v-2H8v2a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">حجز غرفة</span>
                    </a>
                    <!-- Manage Payments -->
                    <a href="{{ route('admin.payments.index') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 hover:from-teal-100 hover:to-teal-200 dark:hover:from-teal-800/30 dark:hover:to-teal-700/30 transition-all duration-200 border border-teal-200 dark:border-teal-700">
                        <div
                            class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">المدفوعات</span>
                    </a>
                    <!-- expenses -->
                    <a href="{{ route('admin.expenses.index') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 hover:from-purple-100 hover:to-purple-200 dark:hover:from-purple-800/30 dark:hover:to-purple-700/30 transition-all duration-200 border border-purple-200 dark:border-purple-700">
                        <div
                            class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.105 0-2 .672-2 1.5S10.895 11 12 11s2 .672 2 1.5S13.105 14 12 14m0-6v.01M12 14v2m0 6c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">المصروفات</span>
                    </a>
                    <!-- maintenance -->
                    <a href="{{ route('admin.maintenance_requests.index') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 hover:from-yellow-100 hover:to-yellow-200 dark:hover:from-yellow-800/30 dark:hover:to-yellow-700/30 transition-all duration-200 border border-yellow-200 dark:border-yellow-700">
                        <div
                            class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 3a.75.75 0 011.5 0v1.5a.75.75 0 01-1.5 0V3zM3 9.75a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5H3zm15.75 0a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5h-1.5zM9.75 19.5a.75.75 0 011.5 0V21a.75.75 0 01-1.5 0v-1.5zM6.364 6.364a.75.75 0 011.06-1.06l1.06 1.06a.75.75 0 01-1.06 1.06L6.364 6.364zm9.192 0a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06zM6.364 17.636a.75.75 0 010-1.06l1.06-1.06a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06 0zm9.192 0a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 111.06-1.06l1.06 1.06a.75.75 0 010 1.06zM12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">طلبات الصيانة</span>
                    </a>
                    <!-- role_manager -->
                    @role("Admin's")
                        <a href="{{ route('admin.role_manager.index') }}"
                            class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/30 dark:hover:to-green-700/30 transition-all duration-200 border border-green-200 dark:border-green-700">
                            <div
                                class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354l6.364 2.122a1 1 0 01.636.928v4.338c0 5.052-3.507 9.607-8.5 10.258-4.993-.65-8.5-5.206-8.5-10.258V7.404a1 1 0 01.636-.928L12 4.354z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">الصلاحيات</span>
                        </a>
                    @endrole
					@role("Admin's")
    <a href="{{ route('admin.settings.edit') }}"
        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 hover:from-yellow-100 hover:to-yellow-200 dark:hover:from-yellow-800/30 dark:hover:to-yellow-700/30 transition-all duration-200 border border-yellow-200 dark:border-yellow-700">
        <div
            class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.75 3a.75.75 0 011.5 0v1.5a.75.75 0 01-1.5 0V3zM3 9.75a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5H3zm15.75 0a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5h-1.5zM9.75 19.5a.75.75 0 011.5 0V21a.75.75 0 01-1.5 0v-1.5zM6.364 6.364a.75.75 0 011.06-1.06l1.06 1.06a.75.75 0 01-1.06 1.06L6.364 6.364zm9.192 0a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06zM6.364 17.636a.75.75 0 010-1.06l1.06-1.06a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06 0zm9.192 0a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 111.06-1.06l1.06 1.06a.75.75 0 010 1.06zM12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z" />
            </svg>
        </div>
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">إعدادات النظام</span>
    </a>
@endrole

                    <!-- maintenance archive -->
                    <a href="{{ route('admin.maintenance_requests.archive') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 hover:from-yellow-100 hover:to-yellow-200 dark:hover:from-yellow-800/30 dark:hover:to-yellow-700/30 transition-all duration-200 border border-yellow-200 dark:border-yellow-700">
                        <div
                            class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">أرشيف الصيانة</span>
                    </a>


                </div>
            </div>

            <!-- Charts and Analytics Section -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-10">
                <!-- Revenue Chart -->
                <div
                    class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.rental_stats') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">الإيرادات والمصروفات الشهرية</p>
                        </div>
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-300">الإيرادات</span>
                            </div>
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-300">المصروفات</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="rentalChart"></canvas>
                    </div>
                </div>

                <!-- Expiring Contracts -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.expiring_contracts') }}</h2>
                        @if ($expiringContracts->count() > 0)
                            <span
                                class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $expiringContracts->count() }}
                            </span>
                        @endif
                    </div>

                    @if ($expiringContracts->count() > 0)
                        <div class="space-y-4 max-h-80 overflow-y-auto">
                            @foreach ($expiringContracts as $contract)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-xl border border-red-200 dark:border-red-800 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">
                                                {{ $contract->tenant->name }}</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                {{ $contract->unit->unit_number }} - {{ $contract->unit->building->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @php $days = floor(now()->diffInDays($contract->end_date)); @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                            {{ $days }} يوم
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.contracts.index') }}"
                                class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                عرض جميع العقود
                                <svg class="w-4 h-4 mr-2 rtl:ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_expiring_contracts') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activities -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.recent_activities') }}
                    </h2>
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    @forelse ($recentActivities as $activity)
                        <div
                            class="flex items-start space-x-4 rtl:space-x-reverse p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">

                            {{-- دائرة الأيقونة --}}
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>

                            {{-- تفاصيل النشاط --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $activity->description }}
                                </p>

                                {{-- معلومات إضافية --}}
                                <div class="flex flex-wrap text-xs text-gray-500 dark:text-gray-400 mt-1 gap-x-2 gap-y-1">
                                    <span class="flex items-center">
                                        <i class="fa-regular fa-user-circle mr-1"></i>
                                        {{ $activity->user->name ?? 'مستخدم غير معروف' }}
                                    </span>

                                    <span class="flex items-center">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ $activity->created_at->translatedFormat('Y/m/d h:i A') }}
                                    </span>

                                    <span class="flex items-center">
                                        <i class="fa-solid fa-hourglass-half mr-1"></i>
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-300 py-8">
                            لا يوجد نشاطات حتى الآن.
                        </div>
                    @endforelse
                    {{ $recentActivities->links() }}
                </div>
            </div>
            <!-- Financial Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Total Income -->
                <!--  <div
                        class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg text-white p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold opacity-90">{{ __('messages.total_income') }}</h3>
                                    <p class="text-3xl font-bold mt-2">{{ number_format($totalIncome, 2) }}
                                        {{ __('messages.currency') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <svg class="w-4 h-4 text-green-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    <span class="text-sm opacity-90">+15.3% من الشهر الماضي</span>
                                </div>
                                <a href="{{ route('admin.payments.due_report') }}"
                                    class="text-white hover:text-green-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>-->

                <!-- Total Expenses -->
                <!--    <div
                        class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg text-white p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold opacity-90">{{ __('messages.total_expenses') }}</h3>
                                    <p class="text-3xl font-bold mt-2">{{ number_format($totalExpenses, 2) }}
                                        {{ __('messages.currency') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <svg class="w-4 h-4 text-red-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    <span class="text-sm opacity-90">-8.2% من الشهر الماضي</span>
                                </div>
                                <a href="{{ route('admin.expenses.index') }}"
                                    class="text-white hover:text-red-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>-->
            </div>

        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle Functionality
            const themeToggle = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            // Check for saved theme preference or default to light
            const currentTheme = localStorage.getItem('theme') || 'light';

            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }

            themeToggle.addEventListener('click', function() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    darkIcon.classList.remove('hidden');
                    lightIcon.classList.add('hidden');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                }
            });

            // Rental Stats Chart
            const ctx = document.getElementById('rentalChart').getContext('2d');

            // Chart configuration with dark mode support
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#E5E7EB' : '#374151';
            const gridColor = isDark ? '#374151' : '#E5E7EB';

            const rentalChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس',
                        'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
                    ],
                    datasets: [{
                        label: '{{ __('messages.rental_income') }}',
                        data: @json($monthlyIncome),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }, {
                        label: '{{ __('messages.expenses') }}',
                        data: @json($monthlyExpenses),
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                color: textColor,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? 'rgba(17, 24, 39, 0.95)' :
                                'rgba(255, 255, 255, 0.95)',
                            titleColor: textColor,
                            bodyColor: textColor,
                            borderColor: gridColor,
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('ar-EG')
                                        .format(context.parsed.y) + ' {{ __('messages.currency') }}';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridColor,
                                drawBorder: false,
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false,
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return new Intl.NumberFormat('ar-EG', {
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value);
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            // Update chart colors when theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const isDark = document.documentElement.classList.contains('dark');
                        const newTextColor = isDark ? '#E5E7EB' : '#374151';
                        const newGridColor = isDark ? '#374151' : '#E5E7EB';

                        rentalChart.options.plugins.legend.labels.color = newTextColor;
                        rentalChart.options.scales.x.ticks.color = newTextColor;
                        rentalChart.options.scales.y.ticks.color = newTextColor;
                        rentalChart.options.scales.x.grid.color = newGridColor;
                        rentalChart.options.scales.y.grid.color = newGridColor;
                        rentalChart.update();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 8px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #6B7280;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }

        /* Light mode scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F3F4F6;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>
@endsection
