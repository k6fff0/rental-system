@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">
                    {{ __('messages.profile_settings') }}
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('messages.profile_settings_description') }}
                </p>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PATCH')

                <!-- Profile Photo -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.profile_photo') }}
                    </label>
                    <div class="flex items-center">
                        <div class="relative">
                            <img src="{{ $user->photo_url }}" alt="{{ __('messages.profile_photo') }}"
                                class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            <div class="absolute bottom-0 right-0 bg-gray-200 dark:bg-gray-600 rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 sm:ml-6 flex-1">
                            <input type="file" name="photo_url" accept="image/*"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gray-100 dark:file:bg-gray-700
                                      file:text-gray-700 dark:file:text-gray-300
                                      hover:file:bg-gray-200 dark:hover:file:bg-gray-600
                                      transition-colors duration-200">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('messages.profile_photo_help') }}
                            </p>
                            @error('photo_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ __('messages.personal_information') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.personal_information_description') }}
                        </p>
                    </div>

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.phone') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white"
                                required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Professional Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ __('messages.professional_information') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.professional_information_description') }}
                        </p>
                    </div>

                    <div class="space-y-5">
                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.department') }}
                            </label>
                            <input type="text" id="department" name="department"
                                value="{{ old('department', auth()->user()->department) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white">
                            @error('department')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="technician_status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.status') }}
                            </label>
                            <select id="technician_status" name="technician_status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                       dark:bg-gray-700 dark:text-white">
                                <option value="available"
                                    {{ auth()->user()->technician_status === 'available' ? 'selected' : '' }}>
                                    {{ __('messages.available') }}
                                </option>
                                <option value="unavailable"
                                    {{ auth()->user()->technician_status === 'unavailable' ? 'selected' : '' }}>
                                    {{ __('messages.unavailable') }}
                                </option>
                            </select>
                        </div>

                        <!-- Preferred Language -->
                        <div>
                            <label for="preferred_language"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.preferred_language') }}
                            </label>
                            <select id="preferred_language" name="preferred_language"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                       dark:bg-gray-700 dark:text-white">
                                <option value="ar" {{ auth()->user()->preferred_language === 'ar' ? 'selected' : '' }}>
                                    العربية
                                </option>
                                <option value="en" {{ auth()->user()->preferred_language === 'en' ? 'selected' : '' }}>
                                    English
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ __('messages.additional_information') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.additional_information_description') }}
                        </p>
                    </div>

                    <div>
                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.notes') }}
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                         focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                         dark:bg-gray-700 dark:text-white">{{ old('notes', auth()->user()->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ __('messages.change_password') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.change_password_description') }}
                        </p>
                    </div>

                    <div class="space-y-5">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.new_password') }}
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.confirm_password') }}
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                      dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('profile.edit') }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium 
                          text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium 
                               rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                               transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('messages.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
