@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-4xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('messages.add_new_zone') }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            {{ __('messages.add_zone_description') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.zones.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                          text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_zones') }}
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('messages.new_zone_information') }}
                    </h3>
                </div>

                <form action="{{ route('admin.zones.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-8">
                        <!-- Zone Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('messages.zone_name') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                      bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                      focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400
                                      transition-colors duration-200
                                      @error('name') border-red-500 dark:border-red-400 @enderror"
                                placeholder="{{ __('messages.enter_zone_name') }}">
                            @error('name')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buildings Selection -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('messages.select_buildings') }}
                                </label>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('messages.selected') }}: <span id="buildings-count">0</span>
                                </span>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-64 overflow-y-auto">
                                @forelse($buildings as $building)
                                    @if ($loop->first)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @endif

                                    <label
                                        class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-600 
                                              hover:bg-blue-50 dark:hover:bg-gray-550 cursor-pointer transition-colors
                                              border border-gray-200 dark:border-gray-500">
                                        <input type="checkbox" name="buildings[]" value="{{ $building->id }}"
                                            {{ in_array($building->id, old('buildings', [])) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 
                                                  rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2
                                                  buildings-checkbox">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex-1">
                                            {{ $building->name }}
                                        </span>
                                    </label>

                                    @if ($loop->last)
                            </div>
                            @endif
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    {{ __('messages.no_buildings_available') }}</p>
                                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">
                                    {{ __('messages.add_buildings_first') }}</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Technicians Selection -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('messages.select_technicians') }}
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('messages.selected') }}: <span id="technicians-count">0</span>
                            </span>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-64 overflow-y-auto">
                            @forelse($technicians as $tech)
                                @if ($loop->first)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @endif

                                <label
                                    class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-600 
                                              hover:bg-green-50 dark:hover:bg-gray-550 cursor-pointer transition-colors
                                              border border-gray-200 dark:border-gray-500">
                                    <input type="checkbox" name="technicians[]" value="{{ $tech->id }}"
                                        {{ in_array($tech->id, old('technicians', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 text-green-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 
                                                  rounded focus:ring-green-500 dark:focus:ring-green-600 focus:ring-2
                                                  technicians-checkbox">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex-1">
                                        {{ $tech->name }}
                                    </span>
                                </label>

                                @if ($loop->last)
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                {{ __('messages.no_technicians_available') }}</p>
                            <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">
                                {{ __('messages.add_technicians_first') }}</p>
                        </div>
                        @endforelse
                    </div>
            </div>

            <!-- Supervisors Selection -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ __('messages.select_zone_supervisors') }}
                    </label>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('messages.selected') }}: <span id="supervisors-count">0</span>
                    </span>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-64 overflow-y-auto">
                    @forelse($supervisors as $supervisor)
                        @if ($loop->first)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @endif

                        <label
                            class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-600 
                                              hover:bg-purple-50 dark:hover:bg-gray-550 cursor-pointer transition-colors
                                              border border-gray-200 dark:border-gray-500">
                            <input type="checkbox" name="supervisors[]" value="{{ $supervisor->id }}"
                                {{ in_array($supervisor->id, old('supervisors', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 
                                                  rounded focus:ring-purple-500 dark:focus:ring-purple-600 focus:ring-2
                                                  supervisors-checkbox">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex-1">
                                {{ $supervisor->name }}
                            </span>
                        </label>

                        @if ($loop->last)
                </div>
                @endif
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('messages.no_supervisors_available') }}</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">{{ __('messages.add_supervisors_first') }}
                    </p>
                </div>
                @endforelse
            </div>
        </div>

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
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('messages.save_zone') }}
            </button>

            <a href="{{ route('admin.zones.index') }}"
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 
                                  bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                                  text-gray-700 dark:text-gray-300 font-semibold rounded-lg 
                                  transition-colors duration-200 border border-gray-300 dark:border-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
            // Update buildings count
            const buildingsCheckboxes = document.querySelectorAll('.buildings-checkbox');
            const buildingsCount = document.getElementById('buildings-count');

            function updateBuildingsCount() {
                const checked = document.querySelectorAll('.buildings-checkbox:checked').length;
                buildingsCount.textContent = checked;
            }

            buildingsCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBuildingsCount);
            });

            // Update technicians count
            const techniciansCheckboxes = document.querySelectorAll('.technicians-checkbox');
            const techniciansCount = document.getElementById('technicians-count');

            function updateTechniciansCount() {
                const checked = document.querySelectorAll('.technicians-checkbox:checked').length;
                techniciansCount.textContent = checked;
            }

            techniciansCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTechniciansCount);
            });

            // Update supervisors count
            const supervisorsCheckboxes = document.querySelectorAll('.supervisors-checkbox');
            const supervisorsCount = document.getElementById('supervisors-count');

            function updateSupervisorsCount() {
                const checked = document.querySelectorAll('.supervisors-checkbox:checked').length;
                supervisorsCount.textContent = checked;
            }

            supervisorsCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSupervisorsCount);
            });

            // Initial count update
            updateBuildingsCount();
            updateTechniciansCount();
            updateSupervisorsCount();
        });
    </script>
@endsection
