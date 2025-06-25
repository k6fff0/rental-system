@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1
                            class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 transition-colors duration-300">
                            {{ __('messages.user_profile') }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('messages.user_details_subtitle') }}
                        </p>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 transition-all duration-200">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ app()->getLocale() === 'ar' ? 'M14 5l7 7m0 0l-7 7m7-7H3' : 'M10 19l-7-7m0 0l7-7m-7 7h18' }}" />
                        </svg>
                        {{ __('messages.back') }}
                    </a>
                </div>
            </div>

            <!-- Main Profile Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300 mb-6">
                <!-- Profile Header -->
                <div
                    class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 px-6 sm:px-8 py-8 sm:py-12">
                    <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6">
                        <!-- User Avatar -->
                        <div class="relative">
                            <div
                                class="w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden ring-4 ring-white/20 backdrop-blur-sm">
                                @if ($user->photo_url)
                                    <a href="{{ $user->photo_url }}" data-fancybox="user-avatar">
                                        <img src="{{ asset($user->photo_url) }}"
                                            class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                            alt="{{ $user->name }}"
                                            onerror="this.src='{{ asset('storage/users/default-avatar.png') }}'">
                                    </a>
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-white/20 to-white/10 flex items-center justify-center backdrop-blur-sm">
                                        <span class="text-white font-bold text-3xl sm:text-4xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            <div
                                class="absolute -bottom-2 {{ app()->getLocale() === 'ar' ? '-left-2' : '-right-2' }} 
                                {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} 
                                text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg flex items-center">
                                <div
                                    class="w-2 h-2 rounded-full bg-white {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }} animate-pulse">
                                </div>
                                {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 text-center lg:text-left">
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-blue-100 mb-4">
                                <div class="flex items-center justify-center lg:justify-start">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                    <span class="break-all">{{ $user->email }}</span>
                                </div>
                                @if ($user->phone)
                                    <div class="hidden sm:block text-blue-200">•</div>
                                    <div class="flex items-center justify-center lg:justify-start">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ $user->phone }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Join Date -->
                            <div class="flex items-center justify-center lg:justify-start text-blue-200 text-sm">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('messages.member_since') }} {{ $user->created_at->format('F Y') }}
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                            @role("Admin's")
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('messages.edit') }}
                                </a>
                            @endrole
                            @role("Admin's")
                                @if ($user->is_active)
                                    <button onclick="confirmAction('disable')"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500/20 hover:bg-yellow-500/30 text-white rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                        </svg>
                                        {{ __('messages.disable') }}
                                    </button>
                                @else
                                    <button onclick="confirmAction('enable')"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-green-500/20 hover:bg-green-500/30 text-white rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ __('messages.enable') }}
                                    </button>
                                @endif
                            @endrole
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Roles Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-blue-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('messages.roles') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        @if ($user->roles->count() > 0)
                            <div class="space-y-3">
                                @foreach ($user->roles as $role)
                                    @php
                                        $roleColors = [
                                            'admin' =>
                                                'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border-red-200 dark:border-red-700',
                                            'supervisor' =>
                                                'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-700',
                                            'technician' =>
                                                'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border-green-200 dark:border-green-700',
                                            'user' =>
                                                'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border-blue-200 dark:border-blue-700',
                                            'broker' =>
                                                'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-700',
                                        ];
                                        $roleColor =
                                            $roleColors[$role->name] ??
                                            'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600';
                                    @endphp
                                    <div
                                        class="flex items-center justify-between p-3 rounded-lg border {{ $roleColor }} transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-current opacity-20 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span
                                                class="font-medium">{{ __('roles.' . $role->name) ?? $role->name }}</span>
                                        </div>
                                        <span class="text-xs opacity-75">{{ $role->permissions->count() }}
                                            {{ __('messages.permissions') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('messages.no_role_assigned') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Permissions Card -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-green-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                {{ __('messages.permissions') }}
                            </h3>
                            @php
                                $permissions = $user->getAllPermissions()->pluck('name');
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                {{ $permissions->count() }} {{ __('messages.permissions') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($permissions->isNotEmpty())
                            <div x-data="{ expanded: false }" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach ($permissions->take(8) as $index => $permission)
                                        <div
                                            class="flex items-center p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-sm">
                                            <div
                                                class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ __('permissions.' . $permission) ?? $permission }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($permissions->count() > 8)
                                    <div x-show="expanded" x-collapse class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($permissions->skip(8) as $permission)
                                            <div
                                                class="flex items-center p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-sm">
                                                <div
                                                    class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ __('permissions.' . $permission) ?? $permission }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <button type="button" @click="expanded = !expanded"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                            <span x-show="!expanded" class="flex items-center">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                                {{ __('messages.show_all_permissions') }} ({{ $permissions->count() - 8 }}
                                                {{ __('messages.more') }})
                                            </span>
                                            <span x-show="expanded" class="flex items-center">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                                {{ __('messages.hide_permissions') }}
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    {{ __('messages.no_permissions_assigned') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div
                class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-indigo-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('messages.additional_information') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Account Status -->
                        <div
                            class="text-center p-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center {{ $user->is_active ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }}">
                                <svg class="w-6 h-6 {{ $user->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($user->is_active)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                    @endif
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.account_status') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
                            </p>
                        </div>

                        <!-- Registration Date -->
                        <div
                            class="text-center p-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.joined') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $user->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Total Roles -->
                        <div
                            class="text-center p-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.total_roles') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->roles->count() }}</p>
                        </div>

                        <!-- Total Permissions -->
                        <div
                            class="text-center p-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.total_permissions') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $permissions->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Confirmation Modal -->
    <div id="actionModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modalIcon"
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Icon will be set by JavaScript -->
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modalTitle">
                                <!-- Title will be set by JavaScript -->
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400" id="modalMessage">
                                    <!-- Message will be set by JavaScript -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="actionForm" method="POST" class="inline">
                        @csrf
                        <button type="submit" id="confirmButton"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            <!-- Button text will be set by JavaScript -->
                        </button>
                    </form>
                    <button type="button" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>
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

        /* Animation for status badge */
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

        /* Profile image hover effect */
        .profile-image:hover {
            transform: scale(1.05);
        }

        /* Permission grid animations */
        .permission-item {
            animation: slideUp 0.6s ease-out;
        }

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

        /* Modal animations */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Focus states for better accessibility */
        .focus-visible:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dark .focus-visible:focus {
            outline-color: #60a5fa;
        }

        /* Alpine.js collapse animation */
        [x-cloak] {
            display: none !important;
        }
    </style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ✅ تفعيل المودال عند الضغط على تفعيل/تعطيل
        window.confirmAction = function (action) {
            const modal = document.getElementById('actionModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const actionForm = document.getElementById('actionForm');
            const confirmButton = document.getElementById('confirmButton');

            if (action === 'disable') {
                modalTitle.textContent = '{{ __('messages.disable_user') }}';
                modalMessage.innerHTML = '{{ __('messages.disable_user_confirmation') }} "<span class=text-gray-900 dark:text-gray-100 font-semibold">{{ $user->name }}</span>"?';
                actionForm.action = '{{ route('admin.users.toggle-active', $user->id) }}';
                confirmButton.textContent = '{{ __('messages.disable') }}';
            } else if (action === 'enable') {
                modalTitle.textContent = '{{ __('messages.enable_user') }}';
                modalMessage.innerHTML = '{{ __('messages.enable_user_confirmation') }} "<span class=text-gray-900 dark:text-gray-100 font-semibold">{{ $user->name }}</span>"?';
                actionForm.action = '{{ route('admin.users.toggle-active', $user->id) }}';
                confirmButton.textContent = '{{ __('messages.enable') }}';
            }

            modal.classList.remove('hidden');
        };

        // ✅ إغلاق المودال
        window.closeModal = function () {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
        };

        // ✅ إغلاق عند الضغط برا المودال
        window.addEventListener('click', function (e) {
            const modal = document.getElementById('actionModal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // ✅ اختصارات لوحة المفاتيح
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('actionModal');
                if (!modal.classList.contains('hidden')) {
                    closeModal();
                }
            }

            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                window.location.href = '{{ route('admin.users.edit', $user->id) }}';
            }

            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                window.location.href = '{{ route('admin.users.index') }}';
            }
        });
    });
</script>

@endsection
