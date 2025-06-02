@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6"
            dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

            {{-- Header Section --}}
            @can('create buildings')
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.building_list') }}</h1>
                    <a href="{{ route('admin.buildings.create') }}"
                        class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('messages.add_building') }}
                    </a>
                </div>
            @endcan

            {{-- Search Filters --}}
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {{-- Dropdown Filter --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">{{ __('messages.select_from_list') }}</label>
                        <div class="relative">
                            <select id="buildingSelect"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm transition-colors duration-200">
                                <option value="">{{ __('messages.all_buildings') }}</option>
                                @foreach ($buildings as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('messages.search_by_name') }}
                        </label>
                        <div class="relative">
                            <input type="text" id="smartSearch"
                                placeholder="{{ __('messages.type_building_name_or_number') }}"
                                class="w-full py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200 
                      {{ app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }}">

                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none 
                    {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            {{-- No Results Message --}}
            <div id="noResults" class="bg-white rounded-xl shadow-md p-8 text-center text-gray-500 hidden">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.291-1.002-5.824-2.651m10.647-.8c-.044-.105-.09-.209-.139-.313M2.3 8.7c-.044.105-.09.209-.139.313">
                    </path>
                </svg>
                <p class="text-lg font-medium">{{ __('messages.no_results_found') }}</p>
            </div>

            {{-- Desktop Table View --}}
            <div id="buildingsTable" class="hidden sm:block bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.building_name') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.building_number') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.address') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.unit_count') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.created_at') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.location') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.residency_type') }}</th>
                                <th
                                    class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    {{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="buildingsTableBody" class="bg-white divide-y divide-gray-200">
                            @foreach ($buildings as $building)
                                @php
                                    $confirmMessage =
                                        app()->getLocale() === 'ar'
                                            ? '⚠️ هل أنت متأكد أنك تريد حذف هذا المبنى؟ سيتم أيضًا حذف كل الغرف المرتبطة به، وقد تؤدي العملية إلى حذف عقود مرتبطة.'
                                            : '⚠️ Are you sure you want to delete this building? All related units will also be deleted, and this may include linked contracts.';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200"
                                    data-name="{{ strtolower($building->name) }}" data-id="{{ $building->id }}"
                                    data-number="{{ strtolower($building->building_number ?? '') }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $building->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $building->building_number ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $building->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $building->units->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $building->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($building->location_url)
                                            <a href="{{ $building->location_url }}" target="_blank"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'عرض الموقع' : 'View Map' }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($building->families_only)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                {{ __('messages.only_families') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                {{ __('messages.general') }}
                                            </span>
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div
                                            class="flex items-center space-x-2 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                                            @can('view building details')
                                                <a href="{{ route('admin.buildings.show', $building->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                    {{ app()->getLocale() == 'ar' ? 'عرض' : 'Show' }}
                                                </a>
                                            @endcan

                                            @can('edit buildings')
                                                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                    {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                                                </a>
                                            @endcan

                                            @can('delete buildings')
                                                <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                                                    method="POST" onsubmit="return confirm('{{ $confirmMessage }}')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                        {{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Card View --}}
            <div id="buildingsMobile" class="block sm:hidden space-y-4">
                @foreach ($buildings as $building)
                    @php
                        $confirmMessage =
                            app()->getLocale() === 'ar'
                                ? '⚠️ هل أنت متأكد أنك تريد حذف هذا المبنى؟ سيتم أيضًا حذف كل الغرف المرتبطة به، وقد تؤدي العملية إلى حذف عقود مرتبطة.'
                                : '⚠️ Are you sure you want to delete this building? All related units will also be deleted, and this may include linked contracts.';
                    @endphp
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mobile-card"
                        data-name="{{ strtolower($building->name) }}" data-id="{{ $building->id }}"
                        data-number="{{ strtolower($building->building_number ?? '') }}">
                        <div class="p-4">
                            {{-- Header with Building Name and Family Status --}}
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $building->name }}</h3>
                                    @if ($building->building_number)
                                        <p class="text-sm text-gray-600">{{ __('messages.building_number') }}:
                                            {{ $building->building_number }}</p>
                                    @endif
                                </div>
                                {{-- Family Status Badge --}}
                                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                                    @if ($building->families_only)
                                        <div class="flex items-center bg-pink-100 text-pink-800 px-2 py-1 rounded-full">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span
                                                class="text-xs font-medium">{{ app()->getLocale() == 'ar' ? 'عائلات فقط' : 'Only Families' }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span
                                                class="text-xs font-medium">{{ app()->getLocale() == 'ar' ? 'عام' : 'General' }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="mb-4">
                                @if ($building->location_url)
                                    <a href="{{ $building->location_url }}" target="_blank"
                                        class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'عرض الموقع' : 'View Location' }}
                                    </a>
                                @else
                                    <span
                                        class="text-gray-400 text-sm">{{ app()->getLocale() == 'ar' ? 'لا يوجد موقع' : 'No location' }}</span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div
                                class="flex items-center justify-end space-x-2 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} pt-3 border-t border-gray-100">
                                @can('view building details')
                                    <a href="{{ route('admin.buildings.show', $building->id) }}"
                                        class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'عرض' : 'Show' }}
                                    </a>
                                @endcan

                                @can('edit buildings')
                                    <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                        class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                                    </a>
                                @endcan

                                @can('delete buildings')
                                    <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST"
                                        onsubmit="return confirm('{{ $confirmMessage }}')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            {{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const smartSearch = document.getElementById('smartSearch');
            const buildingSelect = document.getElementById('buildingSelect');
            const buildingsTableBody = document.getElementById('buildingsTableBody');
            const buildingsMobile = document.getElementById('buildingsMobile');
            const noResults = document.getElementById('noResults');
            const buildingsTable = document.getElementById('buildingsTable');

            const desktopRows = Array.from(document.querySelectorAll('#buildingsTableBody tr'));
            const mobileCards = Array.from(document.querySelectorAll('.mobile-card'));

            // Check if we're on mobile
            function isMobile() {
                return window.innerWidth < 640; // Tailwind's sm breakpoint
            }

            // Smart filtering with debounce
            smartSearch.addEventListener('input', debounce(function() {
                filterBuildings();
            }, 300));

            // Filter on dropdown change
            buildingSelect.addEventListener('change', function() {
                filterBuildings();
            });

            function filterBuildings() {
                const searchTerm = smartSearch.value.toLowerCase();
                const selectedBuildingId = buildingSelect.value;
                const mobile = isMobile();

                let hasVisibleItems = false;

                if (mobile) {
                    // Filter only mobile cards on mobile devices
                    mobileCards.forEach(card => {
                        const buildingName = card.getAttribute('data-name');
                        const buildingId = card.getAttribute('data-id');
                        const buildingNumber = card.getAttribute('data-number')?.toLowerCase() || '';

                        const matchesSearch = searchTerm === '' ||
                            buildingName.includes(searchTerm) ||
                            buildingId.includes(searchTerm) ||
                            buildingNumber.includes(searchTerm);

                        const matchesSelect = selectedBuildingId === '' || buildingId ===
                            selectedBuildingId;

                        if (matchesSearch && matchesSelect) {
                            card.style.display = '';
                            hasVisibleItems = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show/hide appropriate containers for mobile
                    if (!hasVisibleItems) {
                        buildingsMobile.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    } else {
                        buildingsMobile.classList.remove('hidden');
                        noResults.classList.add('hidden');
                    }
                } else {
                    // Filter only desktop table rows on desktop devices
                    desktopRows.forEach(row => {
                        const buildingName = row.getAttribute('data-name');
                        const buildingId = row.getAttribute('data-id');
                        const buildingNumber = row.getAttribute('data-number')?.toLowerCase() || '';

                        const matchesSearch = searchTerm === '' ||
                            buildingName.includes(searchTerm) ||
                            buildingId.includes(searchTerm) ||
                            buildingNumber.includes(searchTerm);

                        const matchesSelect = selectedBuildingId === '' || buildingId ===
                            selectedBuildingId;

                        if (matchesSearch && matchesSelect) {
                            row.style.display = '';
                            hasVisibleItems = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show/hide appropriate containers for desktop
                    if (!hasVisibleItems) {
                        buildingsTable.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    } else {
                        buildingsTable.classList.remove('hidden');
                        noResults.classList.add('hidden');
                    }
                }
            }

            // Listen for window resize to handle orientation changes
            window.addEventListener('resize', debounce(function() {
                filterBuildings(); // Re-run filter when screen size changes
            }, 100));

            // Debounce function for search input
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }
        });
    </script>

    <style>
        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
        }

        [dir="rtl"] .space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Mobile Responsive Fixes */
        @media (max-width: 640px) {

            /* Prevent zoom on iOS */
            input,
            select,
            textarea {
                font-size: 16px !important;
            }

            /* Better spacing on mobile */
            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            /* Ensure proper touch targets */
            button,
            a {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Custom select arrow positioning for RTL */
        [dir="rtl"] select {
            background-position: left 0.75rem center;
            padding-right: 2.5rem;
            padding-left: 0.75rem;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Enhanced shadows */
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom scrollbar for better UX */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
