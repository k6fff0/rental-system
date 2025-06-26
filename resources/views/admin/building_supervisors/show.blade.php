@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-6xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('messages.supervisor_data') }}: {{ $user->name }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            {{ __('messages.supervisor_details_description') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.building-supervisors.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                          text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_supervisors') }}
                    </a>
                </div>
            </div>

            <!-- Supervisor Profile Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('messages.personal_information') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            @if ($user->photo_url)
                                <a href="{{ $user->photo_url }}" data-fancybox="profile-avatar-{{ $user->id }}">
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-md cursor-pointer transition-all duration-200 hover:ring-2 hover:ring-blue-500">
                                </a>
                            @else
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>


                        <!-- Info Grid -->
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.name') }}</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.phone') }}</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $user->phone ?? __('messages.not_available') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.email') }}</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $user->email ?? __('messages.not_available') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('messages.supervised_zones') }}</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $user->supervisedZones->count() }} {{ __('messages.zones') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zones and Buildings Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ __('messages.buildings_by_zones') }}
                    </h3>
                </div>
                <div class="p-6">
                    @forelse ($user->supervisedZones as $zone)
                        <div
                            class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 
                                border border-purple-200 dark:border-purple-700 rounded-xl p-6 mb-6 last:mb-0">
                            <!-- Zone Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-purple-700 dark:text-purple-300">
                                            {{ $zone->name }}</h4>
                                        <p class="text-sm text-purple-600 dark:text-purple-400">
                                            {{ $zone->buildings->count() }} {{ __('messages.buildings') }}
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                    {{ __('messages.zone') }}
                                </span>
                            </div>

                            <!-- Buildings List -->
                            @if ($zone->buildings->count())
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($zone->buildings as $building)
                                        <div
                                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                            <div class="flex items-start">
                                                <div
                                                    class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg mr-3 flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5
                                                        class="font-semibold text-gray-900 dark:text-white text-sm mb-1 truncate">
                                                        {{ $building->name }}
                                                    </h5>
                                                    @if ($building->address)
                                                        <p
                                                            class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                                            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            </svg>
                                                            <span class="truncate">{{ $building->address }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                        {{ __('messages.no_buildings_in_zone') }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ __('messages.no_zones_assigned') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.no_zones_assigned_description') }}</p>
                            <a href="{{ route('admin.zones.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ __('messages.manage_zones') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Account Information -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mt-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('messages.account_information') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.created_at') }}</span>
                            <span
                                class="text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.last_updated') }}</span>
                            <span
                                class="text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="flex flex-col sm:flex-row gap-4 mt-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.building-supervisors.edit', $user) }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 
                      bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 
                      text-white font-semibold rounded-lg shadow-lg hover:shadow-xl 
                      transform hover:scale-105 transition-all duration-200
                      focus:ring-4 focus:ring-amber-300 dark:focus:ring-amber-800 focus:outline-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('messages.edit_supervisor') }}
                </a>
            </div>
        </div>
    </div>
@endsection
