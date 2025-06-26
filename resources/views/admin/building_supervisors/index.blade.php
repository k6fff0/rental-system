@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.building_supervisors_section') }}
                        </h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('messages.manage_building_supervisors_description') }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Supervisors -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.total_supervisors') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Supervisors -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.active_supervisors') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $users->where('supervised_zones_count', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Zones -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.total_zones_supervised') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $users->sum('supervised_zones_count') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Unassigned Supervisors -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('messages.unassigned_supervisors') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $users->where('supervised_zones_count', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <form method="GET" class="flex">
                            <div class="relative flex-1">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="{{ __('messages.search_name_phone') }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                {{ __('messages.search') }}
                            </button>
                        </form>
                    </div>

                    <!-- Filter -->
                    <div class="sm:w-48">
                        <form method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="status_filter" onchange="this.form.submit()"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">{{ __('messages.all_supervisors') }}</option>
                                <option value="active" {{ request('status_filter') == 'active' ? 'selected' : '' }}>
                                    {{ __('messages.active_only') }}</option>
                                <option value="unassigned"
                                    {{ request('status_filter') == 'unassigned' ? 'selected' : '' }}>
                                    {{ __('messages.unassigned_only') }}</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Supervisors Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('messages.supervisors_list') }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.showing_results', ['count' => $users->count(), 'total' => $users->total()]) }}
                        </span>
                    </div>
                </div>

                @forelse($users as $user)
                    <!-- Supervisor Row -->
                    <div
                        class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-12 gap-4 items-center">

                                <!-- Avatar & Name (3 columns) -->
                                <div class="col-span-3 flex items-center space-x-4">
                                    <div class="flex-shrink-0 relative">
                                        @if ($user->photo_url)
                                            <a href="{{ $user->photo_url }}"
                                                data-fancybox="user-avatar-{{ $user->id }}">
                                                <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                                    src="{{ $user->photo_url }}" alt="{{ $user->name }}">
                                            </a>
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-white font-semibold text-lg">{{ mb_substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif

                                        <!-- Online/Zone status -->
                                        <div
                                            class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white dark:border-gray-800
                    {{ $user->supervised_zones_count > 0 ? 'bg-green-500' : 'bg-gray-400' }}">
                                        </div>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $user->name }}</h4>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1
                    {{ $user->supervised_zones_count > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                                            {{ $user->supervised_zones_count > 0 ? __('messages.active') : __('messages.unassigned') }}
                                        </span>
                                    </div>
                                </div>



                                <!-- Phone (2 columns) -->
                                <div class="col-span-2">
                                    @if ($user->phone)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span class="truncate">{{ $user->phone }}</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-sm text-gray-400 dark:text-gray-500">{{ __('messages.not_available') }}</span>
                                    @endif
                                </div>

                                <!-- Email (3 columns) -->
                                <div class="col-span-3">
                                    @if ($user->email)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                            <span class="truncate">{{ $user->email }}</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-sm text-gray-400 dark:text-gray-500">{{ __('messages.not_available') }}</span>
                                    @endif
                                </div>

                                <!-- Zones Count (1 column) -->
                                <div class="col-span-1 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full">
                                        <span
                                            class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $user->supervised_zones_count }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.zones') }}
                                    </div>
                                </div>

                                <!-- Actions (3 columns) -->
                                <div class="col-span-3 flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.building-supervisors.show', $user) }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ __('messages.view') }}
                                    </a>

                                    <a href="{{ route('admin.building-supervisors.edit', $user) }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('messages.manage_zones') }}
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="px-6 py-12 text-center">
                        <div
                            class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            {{ __('messages.no_supervisors_found') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('messages.no_supervisors_description') }}
                        </p>

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 max-w-md mx-auto">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3 text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium">{{ __('messages.supervisor_note') }}</p>
                                    <p class="mt-1">{{ __('messages.supervisor_note_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
