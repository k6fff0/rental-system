@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
     dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="max-w-6xl mx-auto">
        {{-- Header Section - Enhanced --}}
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-700 dark:to-blue-700 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6 text-white shadow-lg mx-2 sm:mx-4 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)" />
                </svg>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 sm:mb-2 flex items-center gap-3">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base sm:text-lg">{{ __('messages.technician_report') }}</span>
                            <span class="text-sm sm:text-base font-medium text-cyan-100 dark:text-cyan-200">{{ $technician->name }}</span>
                        </div>
                    </h1>
                    <p class="text-cyan-100 dark:text-cyan-200 opacity-90 text-sm sm:text-base">{{ __('messages.detailed_performance_report') }}</p>
                    
                    {{-- Current Date & Time Display --}}
                    <div class="mt-3 flex items-center gap-2 text-cyan-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm" id="currentDateTime">{{ now()->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Export Button --}}
                 {{--   <button onclick="exportReport()" 
                        class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('messages.export_report') }}
                    </button>--}}
                    
                    <a href="{{ route('admin.technicians.index') }}"
                        class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-2 sm:px-4">
            {{-- Filter Form - Enhanced --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-colors duration-300 mb-4 sm:mb-6 border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
                        </svg>
                        {{ __('messages.date_filter') }}
                    </h2>
                </div>

                <div class="p-4 sm:p-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4 items-end" id="filterForm">
                        <div class="w-full sm:w-auto flex-1">
                            <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('messages.from_date') }}
                                </span>
                            </label>
                            <input type="date" name="from" id="from" 
                                value="{{ request('from') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200">
                        </div>
                        
                        <div class="w-full sm:w-auto flex-1">
                            <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('messages.to_date') }}
                                </span>
                            </label>
                            <input type="date" name="to" id="to" 
                                value="{{ request('to') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200">
                        </div>
                        
                        {{-- Quick Filter Buttons --}}
                        <div class="w-full sm:w-auto">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.quick_filters') }}</label>
                            <div class="flex gap-2 mb-2">
                                <button type="button" onclick="setDateRange('today')" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">{{ __('messages.today') }}</button>
                                <button type="button" onclick="setDateRange('week')" class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">{{ __('messages.this_week') }}</button>
                                <button type="button" onclick="setDateRange('month')" class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition-colors">{{ __('messages.this_month') }}</button>
                            </div>
                        </div>
                        
                        <div class="w-full sm:w-auto">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                </svg>
                                {{ __('messages.filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Enhanced Statistics Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
                {{-- Total Tasks Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 border border-gray-200 dark:border-gray-700">
                    <div class="p-4 sm:p-6 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.total_tasks') }}</p>
                                <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1" id="totalTasksCounter">{{ $total }}</p>
                                <div class="flex items-center mt-2 text-xs">
                                    <svg class="w-3 h-3 text-green-500 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-green-600">+12% {{ __('messages.from_last_month') }}</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Completed Tasks Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 border border-gray-200 dark:border-gray-700">
                    <div class="p-4 sm:p-6 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.completed_tasks') }}</p>
                                <p class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400 mt-1" id="completedTasksCounter">{{ $completed }}</p>
                                <div class="flex items-center mt-2 text-xs">
                                    <svg class="w-3 h-3 text-green-500 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-green-600">+8% {{ __('messages.from_last_month') }}</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- In Progress Tasks Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 border border-gray-200 dark:border-gray-700">
                    <div class="p-4 sm:p-6 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.in_progress_tasks') }}</p>
                                <p class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1" id="inProgressTasksCounter">{{ $inProgress }}</p>
                                <div class="flex items-center mt-2 text-xs">
                                    <svg class="w-3 h-3 text-red-500 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                    <span class="text-red-600">-3% {{ __('messages.from_last_month') }}</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Success Rate Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 border border-gray-200 dark:border-gray-700">
                    <div class="p-4 sm:p-6 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('messages.success_rate') }}</p>
                                <p class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1" id="successRateCounter">
                                    {{ $total > 0 ? round(($completed / $total) * 100, 1) : 0 }}%
                                </p>
                                <div class="flex items-center mt-2 text-xs">
                                    <svg class="w-3 h-3 text-green-500 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-green-600">+5% {{ __('messages.from_last_month') }}</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                {{-- Monthly Performance Chart --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-blue-200 dark:border-blue-700">
                        <h3 class="text-base sm:text-lg font-semibold text-blue-800 dark:text-blue-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            {{ __('messages.monthly_performance') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="monthlyChart" height="300"></canvas>
                    </div>
                </div>

                {{-- Task Distribution Chart --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-green-200 dark:border-green-700">
                        <h3 class="text-base sm:text-lg font-semibold text-green-800 dark:text-green-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                            {{ __('messages.task_distribution') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="distributionChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            {{-- Weekly Performance Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-purple-200 dark:border-purple-700">
                    <h3 class="text-base sm:text-lg font-semibold text-purple-800 dark:text-purple-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('messages.weekly_performance') }}
                    </h3>
                </div>
                <div class="p-6">
                    <canvas id="weeklyChart" height="200"></canvas>
                </div>
            </div>

            {{-- Enhanced Detailed Statistics Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-colors duration-300 border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 px-4 sm:px-6 py-3 sm:py-4 border-b border-blue-200 dark:border-blue-700">
                    <h3 class="text-base sm:text-lg font-semibold text-blue-800 dark:text-blue-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('messages.detailed_statistics') }}
                    </h3>
                </div>
                
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                        {{-- Task Status Statistics --}}
                        <div class="space-y-4">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wide border-b border-gray-200 dark:border-gray-600 pb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.task_status') }}
                            </h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-green-50 dark:bg-green-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        {{ __('messages.completed_tasks') }}
                                    </span>
                                    <span class="font-bold text-green-600 dark:text-green-400">{{ $completed }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-red-50 dark:bg-red-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        {{ __('messages.rejected_tasks') }}
                                    </span>
                                    <span class="font-bold text-red-600 dark:text-red-400">{{ $rejected }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        {{ __('messages.new_tasks') }}
                                    </span>
                                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $new }}</span>
                                </div>

                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        {{ __('messages.in_progress_tasks') }}
                                    </span>
                                    <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $inProgress }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Performance Metrics --}}
                        <div class="space-y-4">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wide border-b border-gray-200 dark:border-gray-600 pb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ __('messages.performance_metrics') }}
                            </h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-cyan-50 dark:bg-cyan-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.average_duration') }}</span>
                                    <span class="font-bold text-cyan-600 dark:text-cyan-400">
                                        {{ $averageDuration ? round($averageDuration, 2) . ' ' . __('messages.hours') : '' }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-green-50 dark:bg-green-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.fastest_task') }}</span>
                                    <span class="font-bold text-green-500 dark:text-green-300">
                                        {{ $averageDuration ? round($averageDuration, 2) . ' ' . __('messages.hours') : '' }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-rose-50 dark:bg-rose-900/20">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.slowest_task') }}</span>
                                    <span class="font-bold text-rose-500 dark:text-rose-300">
                                        {{ $averageDuration ? round($averageDuration, 2) . ' ' . __('messages.hours') : '' }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 border-t-2 border-indigo-200 dark:border-indigo-600">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ __('messages.total_cost') }}</span>
                                    <span class="font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ number_format($totalCost, 2) }} {{ __('messages.currency') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
			{{-- Technician Recent Activity Timeline --}}
<div class="space-y-4 mt-10">
    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wide border-b border-gray-200 dark:border-gray-600 pb-2 flex items-center gap-2">
        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('messages.recent_activity') }}
    </h4>

    <div class="space-y-3 max-h-[350px] overflow-y-auto">
        @forelse ($requests->sortByDesc('updated_at') as $req)
            @php
                $unit = optional($req->unit)->unit_number ?? 'غير معروف';
                $sub = optional($req->subSpecialty)->name ?? 'غير محدد';
                $time = $req->updated_at->diffForHumans();

                switch ($req->status) {
                    case 'completed':
                        $color = 'bg-green-500';
                        $text = "تم إكمال مهمة صيانة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                        break;
                    case 'in_progress':
                        $color = 'bg-yellow-500';
                        $text = "بدأ تنفيذ مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                        break;
                    case 'rejected':
                        $color = 'bg-red-500';
                        $text = "تم رفض مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                        break;
                    case 'new':
                        $color = 'bg-blue-500';
                        $text = "تم تعيين مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                        break;
						 case 'delayed':
                $color = 'bg-purple-500';
                $text = "⏳ تم تأجيل مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                break;
                    default:
                        $color = 'bg-gray-400';
                        $text = "تم تحديث مهمة - الوحدة <strong>{$unit}</strong>";
                        break;
                }
            @endphp

            <div class="flex items-start gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 shadow-sm">
                <div class="w-2 h-2 {{ $color }} rounded-full mt-2 flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{!! $text !!}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $time }}</p>
                </div>
            </div>
        @empty
            <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                {{ __('messages.no_activity_found') }}
            </div>
        @endforelse
    </div>
</div>


        </div>
    </div>

    {{-- Enhanced JavaScript with Chart.js Integration --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update current time
            function updateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    @if(app()->getLocale() === 'ar')
                    timeZone: 'Asia/Dubai',
                    locale: 'ar-AE'
                    @else
                    timeZone: 'UTC'
                    @endif
                };
                document.getElementById('currentDateTime').textContent = now.toLocaleDateString('{{ app()->getLocale() === "ar" ? "ar-AE" : "en-US" }}', options);
            }

            setInterval(updateTime, 1000);
            updateTime();

            // Counter animation
            function animateCounter(elementId, finalValue, duration = 2000) {
                const element = document.getElementById(elementId);
                const startValue = 0;
                const startTime = performance.now();
                
                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const currentValue = Math.floor(startValue + (finalValue - startValue) * progress);
                    
                    if (elementId === 'successRateCounter') {
                        element.textContent = currentValue + '%';
                    } else {
                        element.textContent = currentValue;
                    }
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                }
                
                requestAnimationFrame(updateCounter);
            }

            // Animate counters
            animateCounter('totalTasksCounter', {{ $total }});
            animateCounter('completedTasksCounter', {{ $completed }});
            animateCounter('inProgressTasksCounter', {{ $inProgress }});
            animateCounter('successRateCounter', {{ $total > 0 ? round(($completed / $total) * 100, 1) : 0 }});

            // Date filter functions
            window.setDateRange = function(period) {
                const today = new Date();
                const fromInput = document.getElementById('from');
                const toInput = document.getElementById('to');
                
                let fromDate, toDate = today;
                
                switch(period) {
                    case 'today':
                        fromDate = today;
                        break;
                    case 'week':
                        fromDate = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                        break;
                    case 'month':
                        fromDate = new Date(today.getFullYear(), today.getMonth(), 1);
                        break;
                }
                
                fromInput.value = fromDate.toISOString().split('T')[0];
                toInput.value = toDate.toISOString().split('T')[0];
            };

            // Export function
            window.exportReport = function() {
                showNotification('{{ __("messages.export_starting") }}', 'info');
                // Add your export logic here
                setTimeout(() => {
                    showNotification('{{ __("messages.export_completed") }}', 'success');
                }, 2000);
            };

            // Chart.js configurations
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                family: 'Segoe UI'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                }
            };

            // Monthly Performance Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: ['{{ __("messages.week") }} 1', '{{ __("messages.week") }} 2', '{{ __("messages.week") }} 3', '{{ __("messages.week") }} 4'],
                    datasets: [{
                        label: '{{ __("messages.completed_tasks") }}',
                        data: [32, 38, 35, {{ $completed }}],
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                        pointRadius: 6
                    }, {
                        label: '{{ __("messages.new_tasks") }}',
                        data: [35, 40, 38, {{ $total }}],
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointRadius: 6
                    }]
                },
                options: chartOptions
            });

            // Task Distribution Chart
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: [
                        '{{ __("messages.completed_tasks") }}',
                        '{{ __("messages.in_progress_tasks") }}',
                        '{{ __("messages.rejected_tasks") }}',
                        '{{ __("messages.new_tasks") }}'
                    ],
                    datasets: [{
                        data: [{{ $completed }}, {{ $inProgress }}, {{ $rejected }}, {{ $new }}],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(59, 130, 246, 0.8)'
                        ],
                        borderColor: [
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(59, 130, 246, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Weekly Performance Chart
            const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: [
                        '{{ __("messages.saturday") }}',
                        '{{ __("messages.sunday") }}',
                        '{{ __("messages.monday") }}',
                        '{{ __("messages.tuesday") }}',
                        '{{ __("messages.wednesday") }}',
                        '{{ __("messages.thursday") }}',
                        '{{ __("messages.friday") }}'
                    ],
                    datasets: [{
                        label: '{{ __("messages.completed_tasks") }}',
                        data: [12, 15, 18, 14, 16, 13, 8],
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    }, {
                        label: '{{ __("messages.working_hours") }}',
                        data: [8, 9, 10, 8.5, 9.5, 8, 6],
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                        borderColor: 'rgba(139, 92, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    }]
                },
                options: chartOptions
            });

            // Enhanced form submission and validation
            const fromDate = document.getElementById('from');
            const toDate = document.getElementById('to');
            const form = document.getElementById('filterForm');
            const submitBtn = form.querySelector('button[type="submit"]');

            if (fromDate && toDate) {
                fromDate.addEventListener('change', function() {
                    toDate.min = this.value;
                    if (toDate.value && toDate.value < this.value) {
                        toDate.value = '';
                        showNotification('{{ __("messages.end_date_must_be_after_start") }}', 'warning');
                    }
                });

                toDate.addEventListener('change', function() {
                    if (fromDate.value && this.value < fromDate.value) {
                        this.value = '';
                        showNotification('{{ __("messages.end_date_must_be_after_start") }}', 'warning');
                    }
                });
            }

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-4 w-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('messages.filtering') }}...
                    `;
                    
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                });
            }

            // Enhanced notification system
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} top-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 {{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }}`;

                const colors = {
                    'info': 'bg-blue-500 text-white',
                    'success': 'bg-green-500 text-white',
                    'warning': 'bg-yellow-500 text-white',
                    'error': 'bg-red-500 text-white'
                };

                notification.className += ` ${colors[type] || colors.info}`;
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="flex-1 text-sm font-medium">${message}</div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                document.body.appendChild(notification);
                setTimeout(() => notification.classList.remove('{{ app()->getLocale() === "ar" ? "-translate-x-full" : "translate-x-full" }}'), 100);
                setTimeout(() => {
                    notification.classList.add('{{ app()->getLocale() === "ar" ? "-translate-x-full" : "translate-x-full" }}');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            }

            window.showNotification = showNotification;


           

            // Mobile optimizations
            if (window.innerWidth <= 768) {
                if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                    const inputs = document.querySelectorAll('input, button');
                    inputs.forEach(input => {
                        input.addEventListener('focus', function() {
                            if (this.style.fontSize !== '16px') {
                                this.style.fontSize = '16px';
                            }
                        });
                    });
                }
            }
        });
    </script>
@endsection