@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" 
         dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden w-full lg:w-auto transition-colors duration-300">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 px-4 sm:px-6 py-4 sm:py-5">
                        <div class="flex items-center space-x-3 sm:space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-white">
                                    {{ __('messages.edit_user') }}
                                </h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    {{ __('messages.edit_user_subtitle') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
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

                    <!-- Account Status Toggle -->
                    @if ($user->is_active)
                        <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-900 transition-all duration-200"
                                onclick="return confirm('{{ __('messages.disable_user_confirmation') }}')">
                                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                </svg>
                                {{ __('messages.disable_account') }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-900 transition-all duration-200"
                                onclick="return confirm('{{ __('messages.enable_user_confirmation') }}')">
                                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.enable_account') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 transition-colors duration-300">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('messages.user_information') }}
                    </h3>
                </div>
                <div class="px-4 sm:px-6 py-6">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <div class="relative">
                                @if ($user->photo_url)
                                    <a href="{{ $user->photo_url }}" data-fancybox="user-avatar">
                                        <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover ring-4 ring-gray-100 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                            src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                                            onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=null;">
                                    </a>
                                @else
                                    <div class="h-20 w-20 sm:h-24 sm:w-24 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center ring-4 ring-gray-100 dark:ring-gray-600">
                                        <span class="text-white font-semibold text-2xl sm:text-3xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <span class="absolute -bottom-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $user->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-700' }}">
                                    <div class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></div>
                                    {{ $user->is_active ? __('messages.active') : __('messages.disabled') }}
                                </span>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- Name -->
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ __('messages.name') }}
                                    </label>
                                    <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 font-medium">{{ $user->name }}</p>
                                </div>

                                <!-- Email -->
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                        {{ __('messages.email') }}
                                    </label>
                                    <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 font-medium break-all">{{ $user->email }}</p>
                                </div>

                                <!-- Phone -->
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ __('messages.phone') }}
                                    </label>
                                    <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $user->phone ?? __('messages.not_specified') }}
                                    </p>
                                </div>

                                <!-- Registration Date -->
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ __('messages.registration_date') }}
                                    </label>
                                    <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $user->created_at->format('Y-m-d') }}
                                    </p>
                                </div>

                                <!-- Current Role -->
                                <div class="space-y-1 sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        {{ __('messages.role') }}
                                    </label>
                                    <div class="flex flex-wrap gap-2">
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                @php
                                                    $roleColors = [
                                                        'admin' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border-red-200 dark:border-red-700',
                                                        'supervisor' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-700',
                                                        'technician' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border-green-200 dark:border-green-700',
                                                        'user' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border-blue-200 dark:border-blue-700',
                                                        'broker' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-700',
                                                    ];
                                                    $roleColor = $roleColors[$role->name] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $roleColor }}">
                                                    {{ __('roles.' . $role->name) ?? $role->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                                {{ __('messages.no_role') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editUserForm"
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                @csrf
                @method('PUT')

                <!-- Role Selection -->
                <div class="px-4 sm:px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('messages.role_assignment') }}
                    </h3>

                    <div class="space-y-3">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.select_role') }}
                        </label>
                        <select name="role" id="role"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                            <option value="">{{ __('messages.no_role') }}</option>
                            @foreach ($roles as $role)
                                @continue($role->name === 'سوبر يوزر')
                                <option value="{{ $role->name }}"
                                    {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                    {{ __('roles.' . $role->name) ?? $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="px-4 sm:px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            {{ __('messages.permissions') }}
                        </h3>
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                                onclick="toggleAllPermissions()">
                            <label for="select-all"
                                class="ml-2 block text-sm text-gray-700 dark:text-gray-300">{{ __('messages.select_all') }}</label>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 max-h-96 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $rolePermissions = $user->roles->flatMap->permissions->pluck('id')->unique();
                            @endphp

                            @foreach ($permissions as $permission)
                                @continue($permission->name === 'super-admin')

                                @php
                                    $isFromRole = $rolePermissions->contains($permission->id);
                                    $isDirect = $user->permissions->contains($permission->id);
                                @endphp

                                <label class="relative flex items-start p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 cursor-pointer transition-all duration-200 {{ $isFromRole ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-700' : '' }}">
                                    <div class="flex items-center h-5">
                                        <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                            value="{{ $permission->id }}"
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 transition-colors duration-200"
                                            {{ $isDirect ? 'checked' : '' }} 
                                            {{ $isFromRole ? 'checked disabled' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <div class="font-medium text-gray-700 dark:text-gray-300">
                                            {{ __('permissions.' . $permission->name) ?? $permission->name }}
                                        </div>
                                        @if ($isFromRole)
                                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 flex items-center">
                                                <svg class="w-3 h-3 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ __('messages.from_role') }}
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-900 flex flex-col sm:flex-row justify-end gap-3 {{ app()->getLocale() === 'ar' ? 'sm:space-x-reverse' : '' }}">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" id="submitBtn"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="submitText">{{ __('messages.save_changes') }}</span>
                        <svg class="w-5 h-5 ml-2 animate-spin hidden" id="loadingIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Disable User Confirmation Modal -->
    <div id="disableModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                {{ __('messages.disable_user') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.disable_user_confirmation') }} "<span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</span>"?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            {{ __('messages.disable_account') }}
                        </button>
                    </form>
                    <button type="button" onclick="document.getElementById('disableModal').classList.add('hidden')"
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

        /* Checkbox animations */
        input[type="checkbox"]:checked + div {
            transform: scale(1.05);
        }

        /* Form validation styling */
        .field-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .field-success {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        /* Focus states for better accessibility */
        .focus-visible:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dark .focus-visible:focus {
            outline-color: #60a5fa;
        }

        /* Animation for status badge */
        .status-indicator {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
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

        .form-section {
            animation: slideUp 0.6s ease-out;
        }

        /* Button loading state */
        .button-loading {
            position: relative;
            pointer-events: none;
        }

        .button-loading::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: inherit;
        }

        /* Hover effects for permission cards */
        .permission-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dark .permission-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
    </style>

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle all permissions functionality
            window.toggleAllPermissions = function() {
                const checkboxes = document.querySelectorAll('input[name="permissions[]"]:not(:disabled)');
                const selectAll = document.getElementById('select-all');
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    // Add animation effect
                    if (selectAll.checked) {
                        cb.closest('label').style.transform = 'scale(1.02)';
                        setTimeout(() => {
                            cb.closest('label').style.transform = 'scale(1)';
                        }, 150);
                    }
                });
            };

            // Form submission with loading state
            const form = document.getElementById('editUserForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingIcon = document.getElementById('loadingIcon');

            form?.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.classList.add('button-loading');
                submitText.textContent = '{{ __("messages.saving") }}...';
                loadingIcon.classList.remove('hidden');
            });

            // Auto-check "Select All" when all permissions are manually selected
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]:not(:disabled)');
            const selectAllCheckbox = document.getElementById('select-all');

            permissionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const totalCheckboxes = permissionCheckboxes.length;
                    const checkedCheckboxes = document.querySelectorAll('input[name="permissions[]"]:not(:disabled):checked').length;
                    
                    selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes;
                    selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
                });
            });

            // Enhanced modal functionality
            window.confirmDisable = function() {
                const modal = document.getElementById('disableModal');
                modal.classList.remove('hidden');
                
                // Add animation
                modal.style.opacity = '0';
                modal.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    modal.style.opacity = '1';
                    modal.style.transform = 'scale(1)';
                }, 10);
            };

            // Close modal with animation
            function closeModal() {
                const modal = document.getElementById('disableModal');
                modal.style.opacity = '0';
                modal.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 150);
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('disableModal');
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Close modal on Escape key
                if (e.key === 'Escape') {
                    const modal = document.getElementById('disableModal');
                    if (!modal.classList.contains('hidden')) {
                        closeModal();
                    }
                }
                
                // Quick save with Ctrl+S
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    form?.requestSubmit();
                }
            });

            // Role selection change handler
            const roleSelect = document.getElementById('role');
            roleSelect?.addEventListener('change', function() {
                // Add visual feedback when role changes
                this.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
                
                // You can add logic here to auto-select permissions based on role
                // Example: if certain roles should have default permissions
            });

            // Add status indicator animation
            const statusBadges = document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]');
            statusBadges.forEach(badge => {
                if (badge.textContent.trim().includes('{{ __("messages.active") }}') || 
                    badge.textContent.trim().includes('{{ __("messages.disabled") }}')) {
                    badge.classList.add('status-indicator');
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

            // Observe form sections for stagger animation
            const formSections = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            formSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(section);
            });

            // Permission card hover effects
            const permissionLabels = document.querySelectorAll('label[for^="permission-"]');
            permissionLabels.forEach(label => {
                label.classList.add('permission-card');
            });

            // Smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Auto-save draft functionality (optional)
            let draftTimer;
            function saveDraft() {
                const formData = new FormData(form);
                const draftData = {};
                for (let [key, value] of formData.entries()) {
                    if (key !== '_token' && key !== '_method') {
                        if (draftData[key]) {
                            if (Array.isArray(draftData[key])) {
                                draftData[key].push(value);
                            } else {
                                draftData[key] = [draftData[key], value];
                            }
                        } else {
                            draftData[key] = value;
                        }
                    }
                }
                localStorage.setItem('editUserFormDraft_{{ $user->id }}', JSON.stringify(draftData));
            }

            // Save draft periodically
            const formInputs = form?.querySelectorAll('input, select');
            formInputs?.forEach(input => {
                input.addEventListener('change', () => {
                    clearTimeout(draftTimer);
                    draftTimer = setTimeout(saveDraft, 2000);
                });
            });

            // Clear draft on successful submission
            form?.addEventListener('submit', function() {
                localStorage.removeItem('editUserFormDraft_{{ $user->id }}');
            });

            // Enhanced accessibility
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('focus', function() {
                    this.closest('label').style.outline = '2px solid #3b82f6';
                    this.closest('label').style.outlineOffset = '2px';
                });
                
                checkbox.addEventListener('blur', function() {
                    this.closest('label').style.outline = 'none';
                });
            });
        });
    </script>
@endsection