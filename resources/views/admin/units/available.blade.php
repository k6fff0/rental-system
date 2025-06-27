@extends('layouts.app')

@section('title', __('الوحدات المتاحة'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Header Section -->
        <header class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-5"></div>

            <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-12 text-center sm:text-start"
                    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

                    <!-- Logo Circle -->
                    <div
                        class="w-32 h-32 object-contain rounded-2xl overflow-hidden shadow-md border-4 border-white dark:border-gray-700 shrink-0">
                        <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Logo"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Title & Subtitle -->
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.available_units_title') }}
                        </h1>
                        <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl">
                            {{ __('messages.available_units_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Mobile Filters Toggle -->
            <button id="toggleFilters"
                class="md:hidden mb-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z">
                    </path>
                </svg>
                {{ __('messages.filters') }}
            </button>

            <!-- Search and Filters -->
            <form method="GET" action="{{ route('units.available') }}" id="filtersForm"
                class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 md:p-6 transition-all duration-300 hidden md:block">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    <!-- Search Box -->
                    <div class="md:col-span-4">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.search') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="{{ __('messages.search_placeholder_available_units') }}">
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.price_range') }}
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                placeholder="{{ __('messages.from') }}"
                                class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <span class="text-gray-400 text-sm">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                placeholder="{{ __('messages.to') }}"
                                class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Unit Type -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.unit_type') }}
                        </label>
                        <select name="unit_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('messages.all_types') }}</option>
                            @foreach ($unitTypes as $type)
                                <option value="{{ $type }}" {{ request('unit_type') == $type ? 'selected' : '' }}>
                                    {{ __('messages.' . $type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Zone -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.zone') }}
                        </label>
                        <select name="zone_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('messages.all_zones') }}</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}"
                                    {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="md:col-span-1">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200 text-sm">
                            {{ __('messages.search') }}
                        </button>
                    </div>
                </div>

                <!-- Results Count & Clear Filters -->
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span>{{ __('messages.total_units') }}</span>
                        <span
                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full font-semibold">
                            {{ $units->total() ?? count($units) }}
                        </span>
                    </div>

                    @if (request()->hasAny(['search', 'min_price', 'max_price', 'unit_type', 'zone_id']))
                        <a href="{{ route('units.available') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
                            {{ __('messages.clear_filters') }}
                        </a>
                    @endif
                </div>
            </form>

            <!-- Units Grid -->
            <section id="units-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($units as $unit)
                    <article
                        class="unit-card group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
                        data-unit-id="{{ $unit->id }}">

                        <!-- Image Gallery -->
                        <div class="relative aspect-[4/3] bg-gray-100 dark:bg-gray-800 rounded-t-2xl overflow-hidden">
                            @if ($unit->images->isNotEmpty())
                                <div class="relative h-48 overflow-hidden rounded-t-2xl bg-gray-100 dark:bg-gray-800">
                                    @foreach ($unit->images->take(3) as $image)
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                            data-fancybox="gallery-{{ $unit->id }}"
                                            data-caption="{{ __('وحدة') }} {{ $unit->unit_number }} - {{ __('صورة') }} {{ $loop->iteration }}"
                                            class="block h-full">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" loading="lazy"
                                                alt="{{ __('messages.unit_image') }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        </a>
                                        @if ($loop->first)
                                            @break
                                        @endif
                                    @endforeach

                                    <!-- Hidden images for gallery -->
                                    @foreach ($unit->images->skip(1) as $image)
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                            data-fancybox="gallery-{{ $unit->id }}"
                                            data-caption="{{ __('وحدة') }} {{ $unit->unit_number }} - {{ __('صورة') }} {{ $loop->iteration + 1 }}"
                                            class="hidden"></a>
                                    @endforeach
                                </div>

                                <!-- Image Counter -->
                                @if ($unit->images->count() > 1)
                                    <div
                                        class="absolute bottom-2 right-2 bg-black/70 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $unit->images->count() }} {{ __('messages.images') }}
                                    </div>
                                @endif
                            @else
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Status Badges -->
                            <div class="absolute top-3 right-3 flex flex-col gap-1">
                                <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                                    {{ __('messages.available') }}
                                </span>
                                @if ($unit->is_first_tenant)
                                    <span class="bg-yellow-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                                        {{ __('messages.first_tenant_badge') }}
                                    </span>
                                @endif
                                @if ($unit->has_special_offer)
                                    <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                                        🔥 {{ __('messages.special_offer') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                <!-- Favorite Button -->
                                <!-- <button onclick="toggleFavorite({{ $unit->id }})"
                                        class="favorite-btn w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md group/fav"
                                        title="{{ __('messages.add_to_favorites') }}">
                                        <svg class="w-4 h-4 text-gray-400 group-hover/fav:text-red-500 transition-colors duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                    </button>-->

                                <!-- Info Button -->
                                <!--<button onclick="showUnitDetails({{ $unit->id }})"
                                                class="info-btn w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md group/info"
                                                title="{{ __('messages.more_details') }}">
                                                <svg class="w-4 h-4 text-gray-400 group-hover/info:text-blue-500 transition-colors duration-200"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>-->
                            </div>
                        </div>

                        <!-- Unit Details -->
                        <div class="p-4">
                            <!-- Unit Number & Rating -->
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ __('messages.unit') }} {{ $unit->unit_number }}
                                </h3>
                                <div class="flex items-center text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            <!-- Building Name -->
                            <a href="{{ $unit->building->location_url }}" target="_blank"
                                class="inline-flex items-center text-xs sm:text-sm text-indigo-600 dark:text-indigo-400 hover:underline mt-1 space-x-1 rtl:space-x-reverse mb-3">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $unit->building->name }}</span>
                            </a>

                            <!-- Unit Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        {{ __('messages.floor') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $unit->floor ? __('messages.floor_' . $unit->floor) : __('messages.not_specified') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('messages.type') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ __('messages.' . $unit->unit_type) }}
                                    </span>
                                </div>

                                @if ($unit->location)
                                    <div class="flex items-center justify-between text-xs sm:text-sm">
                                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10.293 15.707a1 1 0 001.414 0l7-7a1 1 0 00-1.414-1.414L11 13.586V3a1 1 0 10-2 0v10.586L3.707 7.293A1 1 0 002.293 8.707l7 7z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('messages.unit_location') }}
                                        </span>
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ __('messages.' . $unit->location) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Building Photo Link -->
                            @if ($unit->building && $unit->building->image)
                                <a href="{{ asset('storage/' . $unit->building->image) }}"
                                    data-fancybox="building-image-{{ $unit->id }}"
                                    data-caption="{{ $unit->building->name }}"
                                    class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 hover:underline mb-3"
                                    title="{{ __('messages.view_building_photo') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h2l2-3h10l2 3h2a1 1 0 011 1v11a2 2 0 01-2 2H4a2 2 0 01-2-2V8a1 1 0 011-1z" />
                                        <circle cx="12" cy="13" r="4" stroke="currentColor"
                                            stroke-width="2" fill="none" />
                                    </svg>
                                    {{ __('messages.view_building_photo') }}
                                </a>
                            @endif

                            <!-- Price -->
                            <div class="mb-4">
                                <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ number_format($unit->rent_price, 0) }}
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">
                                        {{ __('messages.aed') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('admin.bookings.create', ['unit_id' => $unit->id]) }}"
                                class="inline-flex items-center justify-center w-full px-4 py-3 md:py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H3a1 1 0 110-2h6V3a1 1 0 011-1z" />
                                </svg>
                                {{ __('messages.book_now') }}
                            </a>
                        </div>
                    </article>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <div
                                class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ __('messages.no_units_available') }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto text-sm">
                                {{ __('messages.no_units_message') }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 text-sm">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('messages.back_to_dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </section>

            <!-- Pagination -->
            @if (isset($units) && method_exists($units, 'links'))
                <div class="mt-8 flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-2">
                        {{ $units->appends(request()->query())->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </main>
    </div>

    <!-- Unit Details Modal -->
    <div id="unitDetailsModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                    {{ __('messages.additional_details') }}
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl">
                    ✕
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6" id="modalContent">
                <!-- Content will be loaded dynamically -->
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">{{ __('messages.loading') }}...</p>
                </div>
            </div>

            <!-- Modal Footer with Contact Buttons -->
            <div class="flex gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                <a href="tel:+971501234567"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                        </path>
                    </svg>
                    {{ __('messages.call') }}
                </a>
                <a href="https://wa.me/971501234567" target="_blank"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.109" />
                    </svg>
                    {{ __('messages.whatsapp') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* RTL Support */
        [dir="rtl"] .rtl\:space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Custom Pagination */
        .pagination {
            @apply flex items-center space-x-1 rtl:space-x-reverse;
        }

        .pagination .page-link {
            @apply px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200;
        }

        .pagination .page-item.active .page-link {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }

        .pagination .page-item.disabled .page-link {
            @apply text-gray-400 cursor-not-allowed hover:bg-transparent;
        }

        /* Smooth transitions for unit cards */
        .unit-card {
            will-change: transform;
        }

        .unit-card:hover {
            transform: translateY(-4px);
        }

        /* Favorite button states */
        .favorite-btn.favorited svg {
            color: #ef4444 !important;
            fill: #ef4444 !important;
        }

        /* Modal backdrop */
        #unitDetailsModal {
            backdrop-filter: blur(4px);
        }

        /* Image loading states */
        .image-loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .unit-card {
                margin-bottom: 1rem;
            }

            .favorite-btn,
            .info-btn {
                width: 36px;
                height: 36px;
            }

            .favorite-btn svg,
            .info-btn svg {
                width: 18px;
                height: 18px;
            }

            .pagination .page-link {
                @apply px-2 py-1 text-xs;
            }
        }

        /* Dark mode enhancements */
        @media (prefers-color-scheme: dark) {
            .unit-card {
                border: 1px solid rgba(75, 85, 99, 0.3);
            }
        }

        /* Accessibility improvements */
        .unit-card:focus-within {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .unit-card {
                transition: none;
            }

            .unit-card:hover {
                transform: none;
            }

            .image-loading {
                animation: none;
            }
        }

        /* Print styles */
        @media print {
            .unit-card {
                break-inside: avoid;
                page-break-inside: avoid;
                box-shadow: none;
                border: 1px solid #ccc;
            }

            .favorite-btn,
            .info-btn {
                display: none;
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- Fancybox CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.min.js"></script>

    <script>
        // Global variables
        let favorites = [];

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializePage();
        });

        function initializePage() {
            // Load favorites from localStorage
            loadFavorites();

            // Initialize Fancybox
            initializeFancybox();

            // Setup mobile filters toggle
            setupMobileFilters();

            // Setup form auto-submit for some filters
            setupFilterAutoSubmit();

            // Update favorite buttons UI
            updateAllFavoritesUI();
        }

        // Fancybox initialization
        function initializeFancybox() {
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    l10n: {
                        CLOSE: "إغلاق",
                        NEXT: "التالي",
                        PREV: "السابق",
                        MODAL: "يمكنك إغلاق هذه النافذة بالضغط على ESC",
                        ERROR: "حدث خطأ، يرجى المحاولة لاحقاً",
                        IMAGE_ERROR: "الصورة غير موجودة"
                    },
                    Thumbs: {
                        autoStart: false
                    },
                    Toolbar: {
                        display: {
                            left: [],
                            middle: [],
                            right: ["close"]
                        }
                    },
                    Image: {
                        zoom: true,
                        wheel: false
                    }
                });
            }
        }

        // Mobile filters toggle
        function setupMobileFilters() {
            const toggleBtn = document.getElementById('toggleFilters');
            const filtersForm = document.getElementById('filtersForm');

            if (toggleBtn && filtersForm) {
                toggleBtn.addEventListener('click', function() {
                    filtersForm.classList.toggle('hidden');
                    filtersForm.classList.toggle('block');
                });
            }
        }

        // Auto-submit for zone filter
        function setupFilterAutoSubmit() {
            const zoneSelect = document.querySelector('select[name="zone_id"]');
            if (zoneSelect) {
                zoneSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        }

        // Favorites management
        function loadFavorites() {
            try {
                favorites = JSON.parse(localStorage.getItem('unit_favorites') || '[]');
            } catch (e) {
                favorites = [];
            }
        }

        function saveFavorites() {
            try {
                localStorage.setItem('unit_favorites', JSON.stringify(favorites));
            } catch (e) {
                console.log('Could not save favorites');
            }
        }

        function toggleFavorite(unitId) {
            const index = favorites.indexOf(unitId);

            if (index > -1) {
                favorites.splice(index, 1);
            } else {
                favorites.push(unitId);
            }

            saveFavorites();
            updateFavoriteUI(unitId, index === -1);
        }

        function updateFavoriteUI(unitId, isFavorited) {
            const btn = document.querySelector(`[data-unit-id="${unitId}"] .favorite-btn`);
            if (btn) {
                if (isFavorited) {
                    btn.classList.add('favorited');
                    btn.title = "{{ __('messages.remove_from_favorites') }}";
                } else {
                    btn.classList.remove('favorited');
                    btn.title = "{{ __('messages.add_to_favorites') }}";
                }
            }
        }

        function updateAllFavoritesUI() {
            favorites.forEach(unitId => {
                updateFavoriteUI(unitId, true);
            });
        }

        // Unit details modal
        function showUnitDetails(unitId) {
            const modal = document.getElementById('unitDetailsModal');
            const modalContent = document.getElementById('modalContent');

            if (!modal || !modalContent) return;

            // Show modal
            modal.classList.remove('hidden');

            // Show loading state
            modalContent.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">{{ __('messages.loading') }}...</p>
                </div>
            `;

            // Simulate loading and show mock data
            setTimeout(() => {
                modalContent.innerHTML = generateModalContent(unitId);
            }, 800);
        }

        function generateModalContent(unitId) {
            return `
                <div class="space-y-4">
                    <!-- Nearby Services -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('messages.nearby_services') }}
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                </svg>
                                <span>{{ __('messages.school_nearby') }} - 300{{ __('messages.meters') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ __('messages.hospital_nearby') }} - 1.2{{ __('messages.km') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ __('messages.mall_nearby') }} - 800{{ __('messages.meters') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Costs -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('messages.additional_costs') }}
                        </h4>
                        <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                            <div class="flex justify-between">
                                <span>{{ __('messages.security_deposit') }}:</span>
                                <span class="font-medium">1,000 {{ __('messages.aed') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('messages.commission') }}:</span>
                                <span class="font-medium">5%</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('messages.utilities') }}:</span>
                                <span class="font-medium">{{ __('messages.as_per_usage') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Building Amenities -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            {{ __('messages.building_amenities') }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full text-sm">
                                {{ __('messages.elevator') }}
                            </span>
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full text-sm">
                                {{ __('messages.parking') }}
                            </span>
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200 rounded-full text-sm">
                                {{ __('messages.security') }}
                            </span>
                            <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 rounded-full text-sm">
                                {{ __('messages.internet_ready') }}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }

        function closeModal() {
            const modal = document.getElementById('unitDetailsModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Close modal on background click
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('unitDetailsModal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Lazy loading for images (lightweight implementation)
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('image-loading');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        // Apply lazy loading to images
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            img.classList.add('image-loading');
            imageObserver.observe(img);
        });
    </script>
@endsection
