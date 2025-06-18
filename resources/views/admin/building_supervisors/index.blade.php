@extends('layouts.app')

@section('title', __('messages.building_supervisors'))

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">

            {{-- Header with Search --}}
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                    <!-- العنوان والوصف -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ __('messages.building_supervisors') }}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ __('messages.manage_building_supervisors') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 🔍 مربع البحث -->
                    <form method="GET" class="w-full xl:w-auto">
                        <div class="relative w-full xl:w-80">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="{{ __('messages.search_supervisors') }}..."
                                class="w-full {{ app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4' }} py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none {{ app()->getLocale() === 'ar' ? 'right-4' : 'left-4' }}">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            @if (request('search'))
                                <button type="button" onclick="clearSearch()"
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- إجمالي المشرفين -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.total_supervisors') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $users->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- المشرفين النشطين -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.active_supervisors') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $users->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- المباني المُدارة -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.managed_buildings') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $users->sum('buildings_count') }}</p>
                        </div>
                    </div>
                </div>

                <!-- متوسط المباني لكل مشرف -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.avg_buildings_per_supervisor') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $users->count() > 0 ? number_format($users->sum('buildings_count') / $users->count(), 1) : '0' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Cards View --}}
            <div class="block lg:hidden space-y-4">
                @forelse($users as $user)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="p-4 sm:p-6">
                            <div
                                class="flex items-start space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-12 w-12 sm:h-16 sm:w-16 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                        src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}"
                                        alt="{{ $user->name }}">
                                    <!-- Status Indicator -->
                                    <div
                                        class="absolute -bottom-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} w-4 h-4 {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full border-2 border-white dark:border-gray-800">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3
                                            class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                                            {{ $user->name }}
                                        </h3>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->buildings_count > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                            {{ $user->buildings_count }} {{ __('messages.buildings') }}
                                        </span>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                            <span class="break-all">{{ $user->email }}</span>
                                        </div>
                                        @if ($user->phone)
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $user->phone }}
                                            </div>
                                        @endif
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ __('messages.joined') }} {{ $user->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-gray-50 dark:bg-gray-900 px-4 sm:px-6 py-3 flex gap-3">
                            <a href="{{ route('admin.building-supervisors.show', $user->id) }}"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('messages.view') }}
                            </a>
                            <a href="{{ route('admin.building-supervisors.edit', $user->id) }}"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                {{ __('messages.edit') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center transition-colors duration-300">
                        <div class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500 mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('messages.no_supervisors') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_supervisors_message') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div
                class="hidden lg:block bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.supervisor') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.contact') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.status') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.total_buildings') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 relative">
                                                <a href="{{ $user->photo_url ?? asset('images/default-avatar.png') }}"
                                                    data-fancybox="user-avatar-{{ $user->id }}">
                                                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                                        src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}"
                                                        alt="{{ $user->name }}">
                                                </a>
                                                <!-- Status Indicator -->
                                                <div
                                                    class="absolute -bottom-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }}
                                                           w-3 h-3 {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}
                                                           rounded-full border-2 border-white dark:border-gray-800">
                                                </div>
                                            </div>

                                            <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $user->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('messages.joined') }} {{ $user->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-gray-100 break-all">
                                            {{ $user->email }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $user->phone ?? __('messages.no_phone') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700">
                                                <div
                                                    class="w-1.5 h-1.5 bg-green-400 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}">
                                                </div>
                                                {{ __('messages.active') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-700">
                                                <div
                                                    class="w-1.5 h-1.5 bg-red-400 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}">
                                                </div>
                                                {{ __('messages.inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->buildings_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $user->buildings_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                            <a href="{{ route('admin.building-supervisors.show', $user->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ __('messages.view') }}
                                            </a>
                                            <a href="{{ route('admin.building-supervisors.edit', $user->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                {{ __('messages.edit') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div
                                                class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                                    {{ __('messages.no_supervisors') }}</h3>
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    {{ __('messages.no_supervisors_message') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Enhanced Pagination --}}
                @if ($users->hasPages())
                    <div
                        class="bg-white dark:bg-gray-800 px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Results Info -->
                            <div class="text-sm text-gray-700 dark:text-gray-300 order-2 sm:order-1">
                                <span>{{ __('messages.showing') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-gray-100">{{ $users->firstItem() ?? 0 }}</span>
                                <span>{{ __('messages.to') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-gray-100">{{ $users->lastItem() ?? 0 }}</span>
                                <span>{{ __('messages.of') }}</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $users->total() }}</span>
                                <span>{{ __('messages.results') }}</span>
                            </div>

                            <!-- Pagination Links -->
                            <div class="order-1 sm:order-2">
                                <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px"
                                    aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($users->onFirstPage())
                                        <span
                                            class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}" />
                                            </svg>
                                            <span
                                                class="{{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('messages.previous') }}</span>
                                        </span>
                                    @else
                                        <a href="{{ $users->previousPageUrl() }}"
                                            class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm font-medium transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}" />
                                            </svg>
                                            <span
                                                class="{{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('messages.previous') }}</span>
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $start = max(1, $users->currentPage() - 2);
                                        $end = min($users->lastPage(), $users->currentPage() + 2);
                                    @endphp

                                    @if ($start > 1)
                                        <a href="{{ $users->url(1) }}"
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm font-medium transition-all duration-200">
                                            1
                                        </a>
                                        @if ($start > 2)
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium">
                                                ...
                                            </span>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $users->currentPage())
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 border border-blue-500 dark:border-blue-400 bg-blue-600 dark:bg-blue-700 text-white text-sm font-medium z-10">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $users->url($page) }}"
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm font-medium transition-all duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if ($end < $users->lastPage())
                                        @if ($end < $users->lastPage() - 1)
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium">
                                                ...
                                            </span>
                                        @endif
                                        <a href="{{ $users->url($users->lastPage()) }}"
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm font-medium transition-all duration-200">
                                            {{ $users->lastPage() }}
                                        </a>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($users->hasMorePages())
                                        <a href="{{ $users->nextPageUrl() }}"
                                            class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm font-medium transition-all duration-200">
                                            <span
                                                class="{{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}">{{ __('messages.next') }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ app()->getLocale() === 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed text-sm font-medium">
                                            <span
                                                class="{{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}">{{ __('messages.next') }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ app()->getLocale() === 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}" />
                                            </svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Mobile Pagination --}}
            @if ($users->hasPages())
                <div class="block lg:hidden mt-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 transition-colors duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                <span>{{ __('messages.showing') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-gray-100">{{ $users->firstItem() ?? 0 }}</span>
                                <span>{{ __('messages.to') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-gray-100">{{ $users->lastItem() ?? 0 }}</span>
                                <span>{{ __('messages.of') }}</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $users->total() }}</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ __('messages.page') }} {{ $users->currentPage() }} {{ __('messages.of') }}
                                {{ $users->lastPage() }}
                            </div>
                        </div>

                        <div class="flex justify-between gap-3">
                            @if ($users->onFirstPage())
                                <div
                                    class="flex-1 px-4 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed text-sm font-medium">
                                    {{ __('messages.previous') }}
                                </div>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"
                                    class="flex-1 px-4 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-all duration-200">
                                    {{ __('messages.previous') }}
                                </a>
                            @endif

                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"
                                    class="flex-1 px-4 py-2 text-center border border-transparent rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:from-blue-700 hover:to-blue-800 text-sm font-medium transition-all duration-200">
                                    {{ __('messages.next') }}
                                </a>
                            @else
                                <div
                                    class="flex-1 px-4 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed text-sm font-medium">
                                    {{ __('messages.next') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Smooth transitions for dark mode */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .dark ::-webkit-scrollbar-track {
            @apply bg-gray-800;
        }

        .dark ::-webkit-scrollbar-thumb {
            @apply bg-gray-600 rounded-lg;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-500;
        }

        /* Light mode scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 rounded-lg;
        }

        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400;
        }

        /* RTL Support for spacing */
        [dir="rtl"] .space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
            margin-right: calc(0.75rem * var(--tw-space-x-reverse));
            margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)));
        }

        /* Status indicator animation */
        .status-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        /* Card hover effects */
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .card-hover:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Enhanced focus states */
        .focus-visible:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dark .focus-visible:focus {
            outline-color: #60a5fa;
        }

        /* Form animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        /* Custom pagination styles */
        .pagination-nav a:hover {
            transform: translateY(-1px);
        }

        /* Mobile responsive improvements */
        @media (max-width: 640px) {
            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Enhanced button states */
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dark .btn-hover:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
    </style>

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear search function
            window.clearSearch = function() {
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.form.submit();
                }
            };

            // Auto-submit search after typing delay
            const searchInput = document.querySelector('input[name="search"]');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            this.form.submit();
                        }
                    }, 500);
                });
            }

            // Add status pulse animation to active indicators
            const statusIndicators = document.querySelectorAll('.bg-green-500, .bg-red-500');
            statusIndicators.forEach(indicator => {
                indicator.classList.add('status-pulse');
            });

            // Add slide-up animation to cards
            const cards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add hover effects to buttons
            const buttons = document.querySelectorAll('a[href], button');
            buttons.forEach(button => {
                button.classList.add('btn-hover');
            });

            // Enhanced keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Quick search focus with Ctrl+K
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    searchInput?.focus();
                }

                // Clear search with Escape
                if (e.key === 'Escape' && searchInput === document.activeElement) {
                    clearSearch();
                }
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe table rows for stagger animation
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition =
                    `opacity 0.6s ease ${index * 0.05}s, transform 0.6s ease ${index * 0.05}s`;
                observer.observe(row);
            });

            // Smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Add loading states for form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.style.opacity = '0.7';
                        submitButton.innerHTML =
                            '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' +
                            '{{ __('messages.loading') }}...';
                    }
                });
            });
        });
    </script>
@endsection
