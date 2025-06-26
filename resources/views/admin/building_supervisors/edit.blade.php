@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-4xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('messages.edit_supervisor_data') }}: {{ $user->name }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            {{ __('messages.edit_supervisor_description') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.building-supervisors.show', $user) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                          text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_supervisor') }}
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('messages.supervisor_assignment') }}
                    </h3>
                </div>

                <form action="{{ route('admin.building-supervisors.update', $user) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Supervisor Name (Read Only) -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('messages.supervisor_name') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ $user->name }}" disabled
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                          bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300
                                          cursor-not-allowed opacity-75">
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.name_cannot_be_changed') }}
                            </p>
                        </div>

                        <!-- Zones Assignment -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('messages.responsible_zones') }}
                                </label>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('messages.selected') }}: <span id="zones-count">{{ count($assigned) }}</span>
                                </span>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-64 overflow-y-auto">
                                @forelse($zones as $zone)
                                    @if ($loop->first)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @endif

                                    <label
                                        class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-600 
                                              hover:bg-purple-50 dark:hover:bg-gray-550 cursor-pointer transition-colors
                                              border border-gray-200 dark:border-gray-500">
                                        <input type="checkbox" name="zones[]" value="{{ $zone->id }}"
                                            {{ in_array($zone->id, $assigned) ? 'checked' : '' }}
                                            class="w-4 h-4 text-purple-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 
                                                  rounded focus:ring-purple-500 dark:focus:ring-purple-600 focus:ring-2
                                                  zones-checkbox">
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="text-sm font-medium text-gray-700 dark:text-gray-300 block truncate">
                                                {{ $zone->name }}
                                            </span>
                                            @if ($zone->buildings_count > 0)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $zone->buildings_count }} {{ __('messages.buildings') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-purple-500 dark:text-purple-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                        </div>
                                    </label>

                                    @if ($loop->last)
                            </div>
                            @endif
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('messages.no_zones_available') }}
                                </p>
                                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">
                                    {{ __('messages.create_zones_first') }}</p>
                            </div>
                            @endforelse
                        </div>

                        @if ($zones->count() > 0)
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800 dark:text-blue-200">
                                        <p class="font-medium mb-1">{{ __('messages.assignment_note') }}</p>
                                        <p>{{ __('messages.assignment_note_description') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Current Assignment Summary -->
                    @if (count($assigned) > 0)
                        <div
                            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-green-800 dark:text-green-200 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.current_assignments') }}
                            </h4>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                {{ __('messages.currently_supervising') }} {{ count($assigned) }}
                                {{ __('messages.zones') }}
                                {{ __('messages.with_total_buildings', ['count' => $zones->whereIn('id', $assigned)->sum('buildings_count')]) }}
                            </p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 
                                       bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 
                                       text-white font-semibold rounded-lg shadow-lg hover:shadow-xl 
                                       transform hover:scale-105 transition-all duration-200
                                       focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800 focus:outline-none">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ __('messages.update_assignments') }}
                        </button>

                        <a href="{{ route('admin.building-supervisors.show', $user) }}"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 
                                  bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                                  text-gray-700 dark:text-gray-300 font-semibold rounded-lg 
                                  transition-colors duration-200 border border-gray-300 dark:border-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('messages.cancel') }}
                        </a>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update zones count
            const zonesCheckboxes = document.querySelectorAll('.zones-checkbox');
            const zonesCount = document.getElementById('zones-count');

            function updateZonesCount() {
                const checked = document.querySelectorAll('.zones-checkbox:checked').length;
                zonesCount.textContent = checked;
            }

            zonesCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateZonesCount);
            });
        });
    </script>
@endsection
