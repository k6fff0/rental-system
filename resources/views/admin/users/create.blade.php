@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1
                            class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 transition-colors duration-300">
                            {{ __('messages.add_user') }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('messages.add_user_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div
                class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 px-6 py-5">
                    <div class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-white">
                                {{ __('messages.user_information') }}
                            </h2>
                            <p class="text-blue-100 text-sm">
                                {{ __('messages.fill_required_fields') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 sm:p-8 space-y-6" id="userForm">
                    @csrf

                    <!-- Photo Upload Section -->
                    <div class="flex flex-col items-center space-y-4 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div id="photoPreview"
                                class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center border-4 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 cursor-pointer overflow-hidden">
                                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <label for="photo"
                                class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                        </div>
                        <div class="text-center">
                            <label for="photo"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                {{ __('messages.user_photo') }}
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('messages.photo_requirements') }}
                            </p>
                        </div>
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                    </div>

                    <!-- Basic Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('messages.name') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                placeholder="{{ __('messages.enter_name') }}">
                            @error('name')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                {{ __('messages.email') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                placeholder="{{ __('messages.enter_email') }}">
                            @error('email')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ __('messages.password') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 pr-12"
                                    placeholder="{{ __('messages.enter_password') }}">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        id="eyeIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.password_confirmation') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 pr-12"
                                    placeholder="{{ __('messages.confirm_password') }}">
                                <button type="button" id="togglePasswordConfirmation"
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        id="eyeIconConfirm">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('messages.role_permissions') }}
                        </h3>

                        <div class="space-y-4">
                            <!-- Role Selection -->
                            <div class="space-y-2">
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('messages.select_role') }}
                                </label>
                                <select name="role" id="role"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                    <option value="">{{ __('messages.no_role') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ __('roles.' . $role->name) ?? $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Additional Permissions -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('messages.select_permissions') }}
                                </label>

                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 max-h-48 overflow-y-auto">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($permissions as $permission)
                                            <label
                                                class="relative flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 cursor-pointer transition-all duration-200">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->id }}" class="sr-only peer"
                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <div
                                                    class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded peer-checked:bg-blue-600 peer-checked:border-blue-600 flex items-center justify-center transition-all duration-200">
                                                    <svg class="w-3 h-3 text-white hidden peer-checked:block"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                                    {{ __('permissions.' . $permission->name) ?? $permission->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.users.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ app()->getLocale() === 'ar' ? 'M14 5l7 7m0 0l-7 7m7-7H3' : 'M10 19l-7-7m0 0l7-7m-7 7h18' }}" />
                            </svg>
                            {{ __('messages.back') }}
                        </a>

                        <button type="submit" id="submitBtn"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="submitText">{{ __('messages.save') }}</span>
                            <svg class="w-5 h-5 ml-2 animate-spin hidden" id="loadingIcon" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </form>
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

        /* Custom file input styling */
        input[type="file"] {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        /* Photo preview animations */
        #photoPreview img {
            transition: all 0.3s ease;
        }

        #photoPreview:hover img {
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

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: #ef4444;
            width: 25%;
        }

        .strength-fair {
            background: #f59e0b;
            width: 50%;
        }

        .strength-good {
            background: #10b981;
            width: 75%;
        }

        .strength-strong {
            background: #059669;
            width: 100%;
        }

        /* Custom scrollbar */
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
        input[type="checkbox"]:checked+div {
            transform: scale(1.1);
        }

        /* Focus states for better accessibility */
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
    </style>

    <!-- JavaScript for Enhanced Functionality -->
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

                // Add animation effect
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            });

            // Photo Upload Preview
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');

            photoInput?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.innerHTML =
                            `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-full">`;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Password Toggle Functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword?.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });

            // Password Confirmation Toggle
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');

            togglePasswordConfirmation?.addEventListener('click', function() {
                const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                passwordConfirmationInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeIconConfirm.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    `;
                } else {
                    eyeIconConfirm.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });

            // Password Strength Checker
            passwordInput?.addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = document.getElementById('passwordStrength');

                if (!strengthIndicator) {
                    // Create strength indicator if it doesn't exist
                    const strengthDiv = document.createElement('div');
                    strengthDiv.id = 'passwordStrength';
                    strengthDiv.className = 'password-strength mt-2';
                    this.parentNode.appendChild(strengthDiv);
                }

                const strength = calculatePasswordStrength(password);
                updatePasswordStrength(strength);
            });

            function calculatePasswordStrength(password) {
                let score = 0;
                if (password.length >= 8) score++;
                if (/[a-z]/.test(password)) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;
                return score;
            }

            function updatePasswordStrength(strength) {
                const indicator = document.getElementById('passwordStrength');
                if (!indicator) return;

                const classes = ['strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
                indicator.className = 'password-strength mt-2';

                if (strength > 0) {
                    indicator.classList.add(classes[Math.min(strength - 1, 3)]);
                }
            }

            // Real-time Form Validation
            const form = document.getElementById('userForm');
            const inputs = form.querySelectorAll('input[required], select[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', debounce(validateField, 500));
            });

            function validateField(e) {
                const field = e.target;
                const value = field.value.trim();

                // Remove existing validation classes
                field.classList.remove('field-error', 'field-success');

                if (field.hasAttribute('required') && !value) {
                    field.classList.add('field-error');
                    return false;
                }

                // Email validation
                if (field.type === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.classList.add('field-error');
                        return false;
                    }
                }

                // Password confirmation validation
                if (field.name === 'password_confirmation' && value) {
                    const password = document.getElementById('password').value;
                    if (value !== password) {
                        field.classList.add('field-error');
                        return false;
                    }
                }

                field.classList.add('field-success');
                return true;
            }

            // Form submission with loading state
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingIcon = document.getElementById('loadingIcon');

            form?.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.classList.add('button-loading');
                submitText.textContent = '{{ __('messages.saving') }}...';
                loadingIcon.classList.remove('hidden');

                // Validate all fields before submission
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField({
                            target: input
                        })) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('button-loading');
                    submitText.textContent = '{{ __('messages.save') }}';
                    loadingIcon.classList.add('hidden');
                }
            });

            // Checkbox animations
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkDiv = this.nextElementSibling;
                    if (this.checked) {
                        checkDiv.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            checkDiv.style.transform = 'scale(1)';
                        }, 150);
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Quick dark mode toggle with Ctrl+D
                if (e.ctrlKey && e.key === 'd') {
                    e.preventDefault();
                    darkModeToggle?.click();
                }

                // Quick save with Ctrl+S
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    form?.requestSubmit();
                }
            });

            // Debounce function for input validation
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Auto-save draft functionality (optional)
            let draftTimer;

            function saveDraft() {
                const formData = new FormData(form);
                const draftData = {};
                for (let [key, value] of formData.entries()) {
                    if (key !== '_token' && key !== 'photo') {
                        draftData[key] = value;
                    }
                }
                localStorage.setItem('userFormDraft', JSON.stringify(draftData));
            }

            function loadDraft() {
                const draft = localStorage.getItem('userFormDraft');
                if (draft) {
                    const draftData = JSON.parse(draft);
                    Object.keys(draftData).forEach(key => {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field && field.type !== 'password') {
                            field.value = draftData[key];
                        }
                    });
                }
            }

            // Load draft on page load (uncomment if needed)
            // loadDraft();

            // Save draft periodically
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    clearTimeout(draftTimer);
                    draftTimer = setTimeout(saveDraft, 2000);
                });
            });

            // Clear draft on successful submission
            form?.addEventListener('submit', function() {
                localStorage.removeItem('userFormDraft');
            });

            // Add form section animations
            const formSections = document.querySelectorAll('.space-y-6 > *');
            formSections.forEach((section, index) => {
                section.classList.add('form-section');
                section.style.animationDelay = `${index * 0.1}s`;
            });

            // Smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

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

            // Observe form elements for stagger animation
            formSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(section);
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
