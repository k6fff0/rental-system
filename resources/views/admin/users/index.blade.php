@extends('layouts.app')

@section('content')

    @php use Illuminate\Support\Str; @endphp

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

            <!-- Header Section with Action Buttons -->
            <div class="mb-6 sm:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden w-full lg:w-auto transition-colors duration-300">
                    <div
                        class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 px-4 sm:px-6 py-4 sm:py-5">
                        <div
                            class="flex items-center space-x-3 sm:space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">

                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-white">
                                    {{ __('messages.users_list') }}
                                </h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    {{ __('messages.manage_users_subtitle') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <!-- Back Button -->
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 transition-all duration-200">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ app()->getLocale() === 'ar' ? 'M14 5l7 7m0 0l-7 7m7-7H3' : 'M10 19l-7-7m0 0l7-7m-7 7h18' }}" />
                        </svg>
                        {{ __('messages.back') }}
                    </a>

                    <!-- Create User Button -->
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-900 transition-all duration-200">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('messages.create_user') }}
                    </a>
                </div>
            </div>

            <!-- Users Table Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <!-- Table Header with Search and Filters -->
                <div
                    class="bg-gray-50 dark:bg-gray-900 px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                        <div class="flex items-center">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.users_data') }}
                            </h2>
                            <span
                                class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                {{ $users->total() }} {{ __('messages.users') }}
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <form method="GET" action="{{ route('admin.users.index') }}">
                                <div class="relative rounded-lg shadow-sm">
                                    <div
                                        class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 block w-full {{ app()->getLocale() === 'ar' ? 'pr-10' : 'pl-10' }} sm:text-sm border-gray-300 dark:border-gray-600 rounded-lg h-10 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-300"
                                        placeholder="{{ __('messages.search_users') }}">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Mobile Cards View (Visible on small screens) -->
                <div class="block lg:hidden">
                    @forelse($users as $user)
                        <div
                            class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <!-- User Header -->
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0 relative">
                                        <a href="{{ $user->photo_url }}" data-fancybox="user-avatar-{{ $user->id }}">
                                            <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                                src="{{ $user->photo_url }}" alt="{{ $user->name }}">
                                        </a>
                                        <!-- Online Status Indicator -->
                                        <div class="absolute -bottom-0.5 -right-0.5 
                                            {{ $user->is_active ? 'h-4 w-4 bg-green-500' : 'h-4 w-4 bg-red-500' }} 
                                            rounded-full border-2 border-white dark:border-gray-800 transition-all duration-300"
                                            title="{{ $user->is_active ? __('نشط') : __('معطل') }}">
                                        </div>
                                    </div>
                                    <!-- User Info -->
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $user->name }}
                                            </p>
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                #{{ $loop->iteration }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ __('messages.member_since') }} {{ $user->created_at->format('M Y') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Role Badge -->
                                @php
                                    $role = $user->getRoleNames()->first();
                                    $roleColors = [
                                        'admin' =>
                                            'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border-red-200 dark:border-red-700',
                                        'technician' =>
                                            'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border-green-200 dark:border-green-700',
                                        'user' =>
                                            'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border-blue-200 dark:border-blue-700',
                                        'supervisor' =>
                                            'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-700',
                                        'broker' =>
                                            'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-700',
                                    ];
                                    $roleColor =
                                        $roleColors[$role] ??
                                        'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $roleColor }}">
                                    {{ $role ? __('roles.' . $role) : __('messages.no_role') }}
                                </span>
                            </div>

                            <!-- Contact Info -->
                            <div class="space-y-2 mb-4">
                                <div
                                    class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                    <span
                                        class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</span>
                                </div>
                                @if ($user->phone)
                                    <div
                                        class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->phone }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="flex-1 min-w-0 inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ __('messages.view') }}
                                </a>

                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="flex-1 min-w-0 inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('messages.edit') }}
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="flex-1 min-w-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition-all duration-200 confirm-delete"
                                        data-user-name="{{ $user->name }}">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div
                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                        {{ __('messages.no_users_found') }}</h3>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_users_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View (Hidden on small screens) -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.user_info') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.contact_info') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.role_specialty') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <!-- User Info Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                            <!-- User Avatar -->
                                            <div class="flex-shrink-0 relative">
                                                <a href="{{ $user->photo_url }}"
                                                    data-fancybox="user-avatar-{{ $user->id }}">
                                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                                        src="{{ $user->photo_url }}" alt="{{ $user->name }}">
                                                </a>
                                                <!-- Online Status Indicator -->
                                                <div class="absolute bottom-0 right-0 
                                                    {{ $user->is_active ? 'h-3 w-3 bg-green-500' : 'h-4 w-4 bg-red-500' }} 
                                                    rounded-full border-2 border-white dark:border-gray-800 transition-all duration-300"
                                                    title="{{ $user->is_active ? __('نشط') : __('معطل') }}">
                                                </div>
                                            </div>
                                            <!-- User Details -->
                                            <div class="flex-1 min-w-0">
                                                <div
                                                    class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 truncate"
                                                        style="max-width: 150px;">
                                                        {{ $user->name }}
                                                    </p>
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        #{{ $loop->iteration }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ __('messages.member_since') }}
                                                    {{ $user->created_at->format('M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact Info Column -->
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div
                                                class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                                </svg>
                                                <span class="text-sm text-gray-600 dark:text-gray-400 truncate"
                                                    style="max-width: 200px;">{{ $user->email }}</span>
                                            </div>
                                            @if ($user->phone)
                                                <div
                                                    class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    <span
                                                        class="text-sm text-gray-600 dark:text-gray-400">{{ $user->phone }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Role Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $role = $user->getRoleNames()->first();
                                            $roleColors = [
                                                'admin' =>
                                                    'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border-red-200 dark:border-red-700',
                                                'technician' =>
                                                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border-green-200 dark:border-green-700',
                                                'user' =>
                                                    'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border-blue-200 dark:border-blue-700',
                                                'supervisor' =>
                                                    'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-700',
                                                'broker' =>
                                                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-700',
                                            ];
                                            $roleColor =
                                                $roleColors[$role] ??
                                                'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600';
                                        @endphp

                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $roleColor }}">
                                            {{ $role ? __('roles.' . $role) : __('messages.no_role') }}
                                        </span>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ __('messages.view') }}
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                {{ __('messages.edit') }}
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition-all duration-200 confirm-delete"
                                                    data-user-name="{{ $user->name }}">
                                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div
                                                class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                                    {{ __('messages.no_users_found') }}</h3>
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    {{ __('messages.no_users_description') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div
                        class="bg-white dark:bg-gray-800 px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if ($users->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 cursor-default">
                                        {{ __('messages.previous') }}
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        {{ __('messages.previous') }}
                                    </a>
                                @endif

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}"
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        {{ __('messages.next') }}
                                    </a>
                                @else
                                    <span
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 cursor-default">
                                        {{ __('messages.next') }}
                                    </span>
                                @endif
                            </div>

                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('messages.showing') }}
                                        <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                                        {{ __('messages.to') }}
                                        <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                                        {{ __('messages.of') }}
                                        <span class="font-medium">{{ $users->total() }}</span>
                                        {{ __('messages.results') }}
                                    </p>
                                </div>
                                <div>
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                {{ __('messages.delete_user') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.delete_user_confirmation') }} "<span id="userNameToDelete"
                                        class="font-semibold text-gray-900 dark:text-gray-100"></span>"?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                    <button type="button" id="cancelDelete"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Dark mode styles for pagination */
        .dark .pagination {
            @apply flex items-center space-x-1;
        }

        .dark .pagination li {
            @apply list-none;
        }

        .dark .pagination a,
        .dark .pagination span {
            @apply px-3 py-1 text-sm font-medium rounded-lg transition-all duration-200;
        }

        .dark .pagination a {
            @apply text-gray-400 hover:text-blue-400 hover:bg-gray-700 bg-gray-800 border border-gray-600;
        }

        .dark .pagination .active span {
            @apply bg-blue-600 text-white shadow-lg border-blue-600;
        }

        .dark .pagination .disabled span {
            @apply text-gray-500 cursor-not-allowed bg-gray-800 border-gray-600;
        }

        /* Light mode pagination styles */
        .pagination {
            @apply flex items-center space-x-1;
        }

        .pagination li {
            @apply list-none;
        }

        .pagination a,
        .pagination span {
            @apply px-3 py-1 text-sm font-medium rounded-lg transition-all duration-200;
        }

        .pagination a {
            @apply text-gray-600 hover:text-blue-600 hover:bg-blue-50 bg-white border border-gray-300;
        }

        .pagination .active span {
            @apply bg-blue-600 text-white shadow-lg border-blue-600;
        }

        .pagination .disabled span {
            @apply text-gray-400 cursor-not-allowed bg-white border-gray-300;
        }

        /* RTL Support */
        [dir="rtl"] .pagination {
            @apply space-x-reverse;
        }

        /* Smooth transitions for dark mode */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
            width: 8px;
            height: 8px;
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

        /* Mobile responsive improvements */
        @media (max-width: 640px) {
            .mobile-card {
                margin: 0.5rem;
                border-radius: 0.75rem;
            }
        }

        /* Animation for status indicators */
        .status-indicator {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Focus states for better accessibility */
        .focus-visible:focus {
            outline: 2px solid;
            outline-color: #3b82f6;
            outline-offset: 2px;
        }

        .dark .focus-visible:focus {
            outline-color: #60a5fa;
        }
    </style>

    <!-- JavaScript for Dark Mode and Enhanced Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dark Mode Toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            const html = document.documentElement;

            // Check for saved dark mode preference or default to light mode
            const isDarkMode = localStorage.getItem('darkMode') === 'true' ||
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);

            if (isDarkMode) {
                html.classList.add('dark');
            }

            darkModeToggle?.addEventListener('click', function() {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('darkMode', isDark);

                // Add a subtle animation effect
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            });

            // Delete confirmation modal
            const deleteButtons = document.querySelectorAll('.confirm-delete');
            const deleteModal = document.getElementById('deleteModal');
            const userNameToDelete = document.getElementById('userNameToDelete');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userName = this.getAttribute('data-user-name');
                    userNameToDelete.textContent = userName;
                    deleteForm.action = this.closest('form').action;
                    deleteModal.classList.remove('hidden');

                    // Add animation
                    deleteModal.style.opacity = '0';
                    deleteModal.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        deleteModal.style.opacity = '1';
                        deleteModal.style.transform = 'scale(1)';
                    }, 10);
                });
            });

            cancelDelete?.addEventListener('click', function() {
                closeModal();
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeModal();
                }
            });

            // Close modal with animation
            function closeModal() {
                deleteModal.style.opacity = '0';
                deleteModal.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 150);
            }

            // Search functionality
            const searchInput = document.getElementById('search');
            let searchTimeout;

            searchInput?.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Add your search logic here
                    console.log('Searching for:', this.value);
                }, 300);
            });

            // Enhanced keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Close modal on Escape key
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeModal();
                }

                // Quick dark mode toggle with Ctrl+D
                if (e.ctrlKey && e.key === 'd') {
                    e.preventDefault();
                    darkModeToggle?.click();
                }
            });

            // Add loading states for buttons
            const actionButtons = document.querySelectorAll('a[href], button[type="submit"]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.tagName === 'A' || this.type === 'submit') {
                        this.style.opacity = '0.7';
                        this.style.pointerEvents = 'none';

                        // Reset after 2 seconds (in case navigation fails)
                        setTimeout(() => {
                            this.style.opacity = '1';
                            this.style.pointerEvents = 'auto';
                        }, 2000);
                    }
                });
            });

            // Improved responsive behavior
            function handleResize() {
                const width = window.innerWidth;
                const mobileView = document.querySelector('.block.lg\\:hidden');
                const desktopView = document.querySelector('.hidden.lg\\:block');

                if (width < 1024) {
                    // Mobile optimizations
                    document.body.style.fontSize = '14px';
                } else {
                    // Desktop optimizations
                    document.body.style.fontSize = '16px';
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial call

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
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
            const tableRows = document.querySelectorAll('tbody tr, .mobile-card');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(row);
            });

            // Add status indicator animation
            const statusIndicators = document.querySelectorAll('[title*="نشط"], [title*="معطل"]');
            statusIndicators.forEach(indicator => {
                indicator.classList.add('status-indicator');
            });
        });

        // System dark mode detection
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('darkMode')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    </script>
@endsection
